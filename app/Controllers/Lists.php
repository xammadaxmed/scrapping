<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\Convert;
use App\Helpers\DateTime;
use App\Helpers\ExcelHelper;
use App\Helpers\ExportHelper;
use App\Helpers\TableHelper;
use App\Libraries\DeBounce\Bouncer;
use App\Libraries\Kendo\Scrapper as KendoScrapper;
use Exception;
use Hermawan\DataTables\DataTable;

class Lists extends BaseController
{
    public function index()
    {
        $templates =  $this->db->ListTemplates->get()->getResult();
        return view('lists/index', compact('templates'));
    }

    public function getlist()
    {
        $db = db_connect();
        $builder = $db->table('lists');
        $builder->select("id,name,created_at");


        $datatable = DataTable::of($builder);

        $datatable->add('action', function ($row) {
            return "
            <button href='" . route('/lists/remove') . "?id={$row->id}' onclick='remove($(this))' class='btn btn-danger btn-delete'> <i class='fa fa-trash'  data-id='{$row->id}'></i> </button>
            <button href='" . route('/lists/details') . "?id={$row->id}' onclick='details($(this))' class='btn btn-info btn-more-info'> <i class='fa fa-info' data-id='{$row->id}'></i> </button>
            ";
        });

        $datatable->edit('created_at', function ($row) {
            return date('Y-m-d', strtotime($row->created_at));
        });
        return $datatable->toJson();
    }

    public function save()
    {
        try {
            $arrParams = $this->request->getPost();
            $arr = [];
            $arr['name'] = $arrParams['txtName'];
            $arr['list_template_id'] = $arrParams['ddListTemplate'];
            $arr['created_at'] = DateTime::now();
            $this->db->Lists->save($arr);
            $id = $this->db->Lists->getInsertID();
            $file = $this->request->getFile('fuDomainList');
            $fileName = $file->getTempName();
            $excelHelper = ExcelHelper::create($fileName);
            $body = $excelHelper->body();
            $headers = $excelHelper->headings();
            $db_columns =  $this->db->ListTemplates->getColumns($arr['list_template_id']);
            $arrList = $this->db->ListTemplates->where('id', $arr['list_template_id'])->first();
            $data = Convert::toMappedColumns($body, $db_columns);
            $data = $this->db->Lists->saveListRecords($id, $arrList['name'], $db_columns, $data);
            return $this->success("List has been uploaded successfully", [$data]);
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    public function details()
    {
        $id = $this->request->getGet('id');
        $data = [];
        $columns = $this->db->Lists->getColumns($id);
        $columns = $this->mergeHeaders($id, $columns);
        $arrContactColumns = $this->db->ListTemplates->addContactsColumns();
        $data['columns'] = $columns;
        $data['id'] = $id;
        $data['domain_column'] = $this->db->Lists->getDomainColumn($id);
        $data['titles'] = $this->db->Titles->orderBy('name', 'ASC')->get()->getResult();
        $builder = db_connect()->table($this->db->Lists->getTableName($id));
        $result = $builder->select('id')->where('list_id', $id)->get()->getResult();
        $data['totalRows'] = count($result);
        $data['contactsColumns'] = $arrContactColumns;
        $data['emailColumns'] = $this->extractEmailColumns(array_merge($columns,$arrContactColumns));
        return view('lists/details', $data);
    }

    public function extractEmailColumns($columns)
    {
        $columns = array_unique($columns);
        $arrMailColumns = [];
        foreach($columns as $col)
        {
            if(strpos($col,"mail")!==false)
                $arrMailColumns[] = $col;
        }
        return $arrMailColumns;
    }

    public function mergeHeaders($listId, $columns)
    {
        $mergedColumns = db_connect()->table('columns_merge')->where('list_id', $listId)->get()->getResult();
        foreach ($mergedColumns as $column) {
            $columnName = $column->column_name;
            $mreged = $column->merged_columns;
            $exploded = explode(',', $mreged);
            $columns = array_diff($columns, $exploded);
            $columns[] = $columnName;
        }
        $columns = array_unique($columns);
        return $columns;
    }


    public function mergeColumns($listId, $columns)
    {
        $mergedColumns = db_connect()->table('columns_merge')->where('list_id', $listId)->get()->getResult();
        foreach ($mergedColumns as $column) {
            $columnName = $column->column_name;
            $mreged = $column->merged_columns;
            $exploded = explode(',', $mreged);
            $arrNewExploded = [];

            foreach ($exploded as $exp) {
                $arrNewExploded[] = $exp;
                $arrNewExploded[] = "','";
            }
            $mreged = rtrim(implode(',', $arrNewExploded), "','");
            $columns = array_diff($columns, $exploded);
            $strConcat = "CONCAT($mreged) as $columnName ";
            $columns[] = $strConcat;
        }
        return $columns;
    }

    public function getdetailslist()
    {
        $db = db_connect();
        $id = $this->request->getGet('id');
        $listMeta = $db->query("SELECT 
        lists.id,
        lists.name,
        list_templates.name as template_name,
        list_templates.id as template_id
        FROM lists LEFT OUTER JOIN list_templates on list_templates.id = lists.list_template_id WHERE lists.id='$id' ")->getResult();
        $strTable = str_replace(' ', '_', strtolower($listMeta[0]->template_name));
        $arrColumns = $this->db->Lists->getColumns($id);
        $arrColumns = $this->mergeColumns($id, $arrColumns);
        $columns = implode(',', $arrColumns);
        $builder = $db->table($strTable);
        $builder->select($columns)->where('list_id', $id);
        $datatables = DataTable::of($builder);
        $domainColumn = $this->db->Lists->getDomainColumn($id);
        $count = 0;
        foreach ($arrColumns as $col) {
            $datatables->edit($col, function ($row) use ($col, $count, $domainColumn) {
                $row = (array)$row;
                $string = $row[$col];
                $strInput = "";
                if ($count == 1) {
                    $strInput .= "<div style='width:200px;'><input style='display:inline-block;' class='table-input' readonly value='$string'/></div>";
                } else {
                    $strInput .= "<input class='table-input' readonly value='$string'/>";
                }
                return $strInput;
            });

            $count++;
        }

        return $datatables->toJson(true);
    }

    public function getContacts($domain)
    {
        $db = db_connect()->table('contacts')->like('domain', $domain)->get()->getResult();
        return $db;
    }

    public function get_contacts()
    {
        $site = $this->request->getGet('site');
        return $this->success("", $this->getContacts($site));
    }

    public function enrich()
    {
        $rbType = $this->request->getPost('rbType');
        $listId = $this->request->getPost('txtId');

        if ($rbType == "COMPANY") {
            $this->enrichCompany($listId);
        } else if ($rbType == "CONTACT") {
            $this->enrichContacts($listId);
        } else {
            $this->enrichCompany($listId);
            $this->enrichContacts($listId);
        }

        return $this->success("Enrichment completed successfully");
    }

    public function enrichContacts($listId)
    {
        $db =  db_connect();
        $category = $this->request->getPost('ddCategory');
        $txtMaxMails = $this->request->getPost('txtMaxMails');
        $txtKeyWords = $this->request->getPost('txtKeyWords');
        $strTable = $this->db->Lists->getTableName($listId);
        $domainColumn = $this->db->Lists->getDomainColumn($listId);
        $arrData = $db->table($strTable)->select("id,$domainColumn")->where('list_id', $listId)->orderBy('id', 'ASC')->get()->getResultObject();
       
        foreach ($arrData as $data) {
            try {
                $data = (array)$data;
                $arrContacts = (array) KendoScrapper::init()->search($data[$domainColumn])->contacts($category, null, 5)->all();
                $count = 1;
                foreach ($arrContacts as $contact) {
                    $contact = (array)$contact;
                    $dbContact = [];

                    foreach($contact as $key=>$cnt)
                    {
                        $newColumn = $key."_".$count;
                        $dbContact[$newColumn] = $cnt;
                    }

                    $db->table($strTable)->where('id',$data['id'])->update($dbContact);
                    $count++;
                }
            } catch (Exception $ex) {
            }
        }
    }

    public function enrichCompany($listId)
    {
        $db =  db_connect();
        $strTable = $this->db->Lists->getTableName($listId);
        $domainColumn = $this->db->Lists->getDomainColumn($listId);
        $arrData = $db->table($strTable)->select($domainColumn)->where('list_id', $listId)->orderBy('id', 'ASC')->get()->getResultObject();
        foreach ($arrData as $data) {
            try {
                $data = (array)$data;
                $arr = (array) KendoScrapper::init()->search($data[$domainColumn])->company();
                $this->addNewColumns($strTable, $arr, $listId);
                $domain = $data[$domainColumn];
                $arr = Convert::intArrtoString($arr);
                $up = $db->table($strTable)->like('website', $domain)->update($arr);
                dd($up);die;
            } catch (Exception $ex) {
            }
            die;
        }
        die;
    }

    public function addNewColumns($strTable, $payload, $listId)
    {
        $payload = (array)$payload;
        $list = (array) $this->db->Lists->where('id', $listId)->first();

        if (!empty($payload)) {
            $columns = array_keys($payload);
            foreach ($columns as $column) {
                if (TableHelper::alterTable($strTable, $column)) {
                    $arr = [];
                    $arr['column_name'] = $column;
                    $arr['template_id'] = $list['list_template_id'];
                    $this->db->ListTemplateDetails->insert($arr);
                }
            }
        }
    }

    public function export()
    {
        $db = db_connect();
        $post = $this->request->getPost();
        $data = [];
        $columns = [];
        $list = $db->table('lists')->where('id', $post['txtId'])->get()->getRowObject();
        $domainColumn = $this->db->Lists->getDomainColumn($post['txtId']);
        $filename = $list->name;
        if ($post['rbType'] == "OTHER") {
            $strTable = $this->db->Lists->getTableName($post['txtId']);
            $strColumns = implode(",", $post['ddColumns']);
            $result = $db->table($strTable)->select($strColumns)->offset($post['txtFrom'])->limit($post['txtTo'])->get()->getResult('array');
            $data = $result;
            $columns = $post['ddColumns'];
        } else {
            $strTable = $this->db->Lists->getTableName($post['txtId']);
            $strColumns = implode(",", $post['ddContactsColumns']);
            $result = $db->table($strTable)->select($strColumns)->offset($post['txtFrom'])->limit($post['txtTo'])->get()->getResult('array');
            $data = $result;
            $columns = $post['ddContactsColumns'];

            $filename .= "-Contacts";
        }

        if ($post['rbFileType'] == "EXCEL")
            ExportHelper::ExcelDownload($data, $columns, $filename);
        else if ($post['rbFileType'] == "TEXT")
            ExportHelper::DownLoadTextFile($data, $columns, $filename);
        else if ($post['rbFileType'] == "CSV")
            ExportHelper::DownloadCSV($data, $columns, $filename);

        exit;
    }

    public function merge()
    {
        $params = $this->request->getPost();
        $strColumns = implode(',', $params['ddMergeColumns']);
        $arr = [];
        $arr['column_name'] = $params['txtMergeName'];
        $arr['merged_columns'] = $strColumns;
        $arr['list_id'] = $params['txtId'];
        $data = db_connect()->table('columns_merge')
            ->where('column_name', $params['txtMergeName'])
            ->where('merged_columns', $strColumns)
            ->where('list_id', $params['txtId'])->get()->getResult();
        if (empty($data)) {
            db_connect()->table('columns_merge')->insert($arr);
        }
        return $this->success("Columns merged successfully");
    }

    public function remove()
    {
        $id = $this->request->getGet("id");
        $db = db_connect();
        $tableName = $this->db->Lists->getTableName($id);
        $db->table('lists')->where('id', $id)->delete();
        $db->table($tableName)->where('list_id', $id)->delete();
        return $this->success("List Has been delete successfully");
    }

    public function verify_emails()
    {
        $emails = $this->request->getPost('ddEmailColumns');
        $emails[] = "id";
        $strEmails = implode(",",$emails);
        $txtId = $this->request->getPost('txtId');
        $db = db_connect();
        $strTable = $this->db->Lists->getTableName($txtId);
        $data = $db->table($strTable)
        ->select($strEmails)
        ->where('list_id',$txtId)
        ->get()
        ->getResult();
       
        foreach($data as $dt)
        {
            if($this->isArrEmpty($dt))
                continue;
           
                $arr = [];
            foreach($dt as $key=>$value)
            {
                if($key == "id" || empty($value))
                    continue;
                $result =  Bouncer::create()->verify($value);
                $arr[$key] = "$value ($result->result)";

            }
             $db->table($strTable)->where('id',$dt->id)->update($arr);
        }

        return $this->success("Emails has been verified successfully");
    }

    public function isArrEmpty($arr)
    {
        $bEmpty = true;

        foreach($arr as $key=>$value)
        {
            if(!empty($value) && $key!="id")
            {
                $bEmpty = false;
            }
        }

        return $bEmpty;
    }

    public function test_api()
    {
  
    }
}
