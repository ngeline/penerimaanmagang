<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Magang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'pengajuan_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'pembimbing_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'siswa_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'status_magang' => [
                'type' => 'ENUM',
                'constraint' => "'berjalan', 'selesai'",
                'null' => false,
                'default' => 'berjalan',
            ],
            'sertifikat' => [
                'type' => 'TEXT',
                'null' => true
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
        $this->forge->createTable('magang');
    }

    public function down()
    {
        $this->forge->dropTable('magang');
    }
}
