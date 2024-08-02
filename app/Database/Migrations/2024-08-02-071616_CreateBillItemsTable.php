<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateBillItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'bill_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'product_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],            
            'price' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2'
            ],
            'qty' => [
                'type' => 'INT',
                'default' => 0
            ],
            'amount' => [
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
        $this->forge->addForeignKey('bill_id', 'bills', 'id');
        $this->forge->addForeignKey('product_id', 'products', 'id');
        $this->forge->createTable('bill_items');
    }

    public function down()
    {
        $this->forge->dropTable('bill_items');
    }
}
