<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KepalaDinas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'kepala_dinas' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'ttd' => [
                'type' => 'TEXT',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kepala_dinas');
    }

    public function down()
    {
        $this->forge->dropTable('kepala_dinas');
    }
}
