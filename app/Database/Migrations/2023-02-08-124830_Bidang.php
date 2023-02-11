<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bidang extends Migration
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
            'nama_bidang' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'keterangan' => [
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
        $this->forge->createTable('bidang');
    }

    public function down()
    {
        $this->forge->dropTable('bidang');
    }
}
