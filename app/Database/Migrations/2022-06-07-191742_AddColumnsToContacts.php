<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsToContacts extends Migration
{
    private $tableName = "contacts";
 
    public function up()
    {
        $fields = [
            'list_id' => [
                'type' => 'INTEGER',
                'constraint' => 255,
                'null' => true
            ]
        ];

        $this->forge->addColumn($this->tableName,$fields);
    }

    public function down()
    {
        return $this->forge->dropTable($this->tableName, true);
    }
}
