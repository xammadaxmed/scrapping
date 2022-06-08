<?php

namespace App\Helpers;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\Forge;
use CodeIgniter\Database\SQLSRV\Forge as SQLSRVForge;

class TableHelper extends Migration
{

    private $tableName;
    private $columns;

    public function __construct($strTable, $columns = [])
    {
        $forge = new SQLSRVForge(db_connect());
        parent::__construct($forge);
        $this->columns = $columns;
        $this->tableName = $strTable;
    }

    public function up()
    {
        $fields = $this->forgeColumns($this->columns);
        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $result = $this->forge->createTable($this->tableName,true);
        if (!$result) return db_connect()->error();
        else
            return true;
    }

    public function down()
    {
        $this->forge->dropTable($this->tableName, true);
    }

    private static function forgeColumns($columns)
    {
        $arrFields = [];
        $arrFields['id'] = [
            'type'           => 'INTEGER',
            'constraint'     => 255,
            'unsigned'       => true,
            'auto_increment' => true,
        ];

        foreach ($columns as $column) {
            $arrFields[$column] = [
                'type' => 'TEXT',
                'null' => true
            ];
        }

        $arrFields['status'] = [
            'type' => 'VARCHAR',
            'constraint' => 255,
            'null' => true
        ];

        $arrFields['list_id'] = [
            'type' => 'INTEGER',
            'constraint' => 255,
            'null' => true
        ];

        return $arrFields;
    }
    
    public static function createTable($strTable, $columns)
    {
        $table = new TableHelper($strTable, $columns);
        return $table->up();
    }


    public static function dropTable($strTable)
    {
        $table = new TableHelper($strTable);
        return $table->down();
    }

    public static function alterTable($strTable,$column)
    {
        $table = new TableHelper($strTable);
        return $table->addColumn($column);
       
    }

    public function addColumn($column)
    {
            $field = [
                $column => [  
                'type' => 'TEXT',
                'null' => true]
            ];
           return $this->forge->addColumn($this->tableName,$field);
       
    }
    
}
