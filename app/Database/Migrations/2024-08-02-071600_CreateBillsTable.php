<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateBillsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ], 
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],        
            'total_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],            
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP')
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'default' => null,
                'on update' => 'CURRENT_TIMESTAMP'
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('bills');
    }

    public function down()
    {
        $this->forge->dropTable('bills');
    }
}
