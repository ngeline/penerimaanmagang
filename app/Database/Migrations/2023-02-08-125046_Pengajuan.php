<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengajuan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'siswa_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'tanggal_mulai' => [
                'type' => 'DATE',
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
            ],
            'file_proposal' => [
                'type' => 'TEXT'
            ],
            'file_surat_pengajuan' => [
                'type' => 'TEXT'
            ],
            'file_surat_balasan' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'status_pengajuan' => [
                'type' => 'ENUM',
                'constraint' => "'diterima', 'ditolak', 'diproses'",
                'null' => false,
                'default' => 'diproses'
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengajuan');
    }

    public function down()
    {
        $this->forge->dropTable('pengajuan');
    }
}
