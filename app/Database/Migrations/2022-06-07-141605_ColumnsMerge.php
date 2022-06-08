<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ColumnsMerge extends Migration
{
    private $tableName = "columns_merge";
 
    public function up()
    {
        $fields = [
            'id' =>  [
                'type'           => 'INT',
                'constraint'     => 255,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'column_name' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => true
            ],
            'merged_columns' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => true
            ],
            'list_id' => [
                'type' => 'INTEGER',
                'constraint' => 255,
                'null' => true
            ]
        ];



        $this->forge->addField($fields);
        $this->forge->addKey('id', true);
        $result = $this->forge->createTable($this->tableName, true);
        if (!$result) return db_connect()->error();
        else
            return $result;
    }

    public function down()
    {
        return $this->forge->dropTable($this->tableName, true);
    }
}
