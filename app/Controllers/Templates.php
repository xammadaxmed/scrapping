<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\ExcelHelper;
use App\Helpers\TableHelper;
use Exception;
use Hermawan\DataTables\DataTable;
use Ozdemir\Datatables\DB\Codeigniter4Adapter;

class Templates extends BaseController
{
    public function index()
    {
        return view('templates/index');
    } 

    public function save()
    {
        $params = $this->request->getPost();
        $arr = [];
        $arr['name'] = trim($params['txtName']);
        $arr['domain_column'] = trim($params['txtDomain']);
        $arr['created_at'] = date('Y-m-d H:i:s');
        $this->db->ListTemplates->save($arr);
        $id = $this->db->ListTemplates->getInsertID();

        $file = $this->request->getFile('fuTemplate');
        $fileName = $file->getTempName();
        $excelHelper = new ExcelHelper($fileName);
        $columns = $excelHelper->headings();
        $contactColumns = $this->db->ListTemplates->addContactsColumns();
        $columns = array_merge($columns,$contactColumns);
        $columns = array_unique($columns);

        foreach ($columns as $col) {
            if(empty($col))
                continue;
            $this->db->ListTemplateDetails->save([
                'column_name' => trim($col),
                'template_id' => $id
            ]);
        }
        $strTable = strtolower(str_replace(' ', '_', $params['txtName']));
        $data = TableHelper::createTable($strTable, $columns);
        
        return $this->success('Template has been created',[ $data]);
    }


    public function getlist()
    {
        $db = db_connect();
        $builder = $db->table('list_templates');
        $builder->select("id,name,created_at");

        $datatables  = DataTable::of($builder);
        $datatables->add('action', function ($row) {
            $row = (array) $row;
            return "
            <button href='" . route('/templates/remove') . "?id={$row['id']}' onclick='remove(this)' class='btn btn-danger btn-delete'> <i class='fa fa-trash'  data-id='{$row['id']}'></i> </button>
            <button href='" . route('/templates/details') . "?id={$row['id']}' onclick='details(this)' class='btn btn-info btn-more-info'> <i class='fa fa-info' data-id='{$row['id']}'></i> </button>
            ";
        });
        $datatables->edit('created_at', function ($row) {
            $row = (array) $row;
            return date('Y-m-d', strtotime($row['created_at']));
        });
        return $datatables->toJson();
    }

    public function details()
    {
        $id = $this->request->getGet('id');
        $data = $this->db->query("SELECT * FROM list_templates LEFT OUTER JOIN list_template_details ON list_templates.id = list_template_details.template_id WHERE list_templates.id = '$id'");
        return $this->success("Record Found!", $data);
    }

    public function remove()
    {
        $db = db_connect();
        try {
            $id = $this->request->getGet('id');

            $exist =  $this->db->Lists->where('list_template_id',$id)->get()->getResult();
            if(!empty($exist))
            {
                return $this->error("You Cannot Delete this Template");
                exit;
            }
            $data = $this->db->ListTemplates->where('id', $id)->first();
            $strTableName = strtolower(str_replace(' ', '_', $data['name']));
            $data = $db->query("DELETE FROM list_templates WHERE id='$id'");
            $data = $db->query("DELETE FROM list_template_details WHERE template_id = '$id'");
            TableHelper::dropTable($strTableName);
            return $this->success("List Template has been deleted!");
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }
}
