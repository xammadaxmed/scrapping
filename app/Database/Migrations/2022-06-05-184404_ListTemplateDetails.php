<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ListTemplateDetails extends Migration
{
    private $tableName = "list_template_details";
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
                'constraint' => 255,
                'null' => true
            ],
            'template_id' => [
                'type' => 'INT',
                'constraint' => 255,
                'null' => true
            ],
            'created_at' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
            'updated_at' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
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
