<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class ListTemplate extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'list_templates';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'name','domain_column','created_at','updated_at'];

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

    public function getColumns($id)
    {
        $db = db_connect();
        $arr = $db->query("SELECT column_name from list_template_details WHERE template_id = '$id'")->getResult();
        $arrReturn = [];
        foreach($arr as $ar)
        {
            $arrReturn[] = $ar->column_name;
        }
      
      return $arrReturn;
    }

    public function addContactsColumns($columns = 5)
    {
        $arrColumns = [];
        $arrBase = ['firstname','lastname','personal_email','work_email','linkedin','category','title'];
        for($i=1;$i<=$columns;$i++)
        {
            foreach($arrBase as $base)
            {
                $arrColumns[] = $base."_".$i;
            }

        }
        return $arrColumns;
    }
}
