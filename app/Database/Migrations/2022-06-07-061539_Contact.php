<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Contact extends Migration
{
    private $tableName = "contacts";
 
    public function up()
    {
        $fields = [
            'id' =>  [
                'type'           => 'INT',
                'constraint'     => 255,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'firstname' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => true
            ],
            'lastname' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => true
            ],
            'category' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => true
            ],
            'linkedin' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => true
            ],
            'personal_email' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => true
            ],
            'work_email' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => true
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => true
            ],
            'domain' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
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
