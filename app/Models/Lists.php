<?php

namespace App\Models;

use App\Helpers\Convert;
use CodeIgniter\Model;

class Lists extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'lists';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'name', 'list_template_id','created_at','updated_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function saveListRecords($id, $strListName, $arrColumns, $arrData)
    {
        $domainColumn = $this->getDomainColumn($id);
        $db = db_connect();

        $arrColumns[] = 'list_id';
        $strTable = strtolower(str_replace(' ', '_', $strListName));

        foreach($arrData as $key=>$data)
        {
           $exist = $db->query("SELECT * FROM $strTable WHERE $domainColumn LIKE '{$data[$domainColumn]}'")->getRowArray();
           if(empty($exist))
           {
              $data['list_id'] = $id;
              $db->table($strTable)->insert($data);
           }
        }
        return true;
    }

    public function getColumns($id)
    {
        $db = db_connect();
        $arr = $db->query( "SELECT 
        list_template_details.column_name
        FROM lists LEFT OUTER JOIN list_template_details 
        ON list_template_details.template_id = lists.list_template_id WHERE lists.id='$id'")
        ->getResult();
        $arrReturn = [];
        $arrReturn[] = 'id';
      
        foreach ($arr as $ar) {
            $arrReturn[] = $ar->column_name;
        }
        $arrReturn[] = 'status';

        return $arrReturn;
    }


    public function getTableName($id)
    {
        $db = db_connect();
        $arr = $db->query("SELECT list_templates.name FROM list_templates LEFT OUTER JOIN lists ON lists.list_template_id = list_templates.id WHERE lists.id='$id'")->getResult();
        return strtolower(str_replace(' ', '_', $arr[0]->name));
    }

    public function getListData($id, $strTable, $arrColumns)
    {
        $con = db_connect();
        $arrColumns = array_diff($arrColumns, array("status", "id"));
        $strColumns = implode(",", $arrColumns);
        return  $con->query("SELECT $strColumns FROM $strTable WHERE list_id = '$id'")->getResult('array');
    }

    public function getDomainColumn($nListId)
    {
        $con = db_connect();
        $arr = $con->query("SELECT list_templates.domain_column FROM list_templates LEFT OUTER JOIN lists ON lists.list_template_id = list_templates.id WHERE lists.id='$nListId'")
        ->getResult();
        return $arr[0]->domain_column;
    }
}
