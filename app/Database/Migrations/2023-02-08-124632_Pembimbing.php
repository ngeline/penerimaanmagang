<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembimbing extends Migration
{
    public function up()
    {
        $this->forge->addField([
            // 'id' => [
            //     'type' => 'INT',
            //     'constraint' => 11,
            //     'unsigned' => true,
            //     'auto_increment' => true
            // ],
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                // 'unique' => true,
            ],
            'users_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'bidang_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => "'l', 'p'",
                'null' => false,
                'default' => 'l',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 20
            ],
            'alamat' => [
                'type' => 'TEXT'
            ],
            'status_hapus' => [
                'type' => 'ENUM',
                'constraint' => "'hapus', 'tidak'",
                'null' => false,
                'default' => 'tidak',
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pembimbing');
    }

    public function down()
    {
        $this->forge->dropTable('pembimbing');
    }
}
