<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Absensi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'magang_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'jam' => [
                'type' => 'TIME',
            ],
            'absen' => [
                'type' => 'ENUM',
                'constraint' => "'hadir', 'izin'",
                'null' => false,
                'default' => 'hadir',
            ],
            'foto_absensi' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'file_surat_izin' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'status_absen' => [
                'type' => 'ENUM',
                'constraint' => "'diterima', 'ditolak', 'diproses'",
                'null' => false,
                'default' => 'diproses',
            ],
            'status_kedatangan' => [
                'type' => 'ENUM',
                'constraint' => "'tepat waktu', 'terlambat','izin'",
                'null' => false,
                'default' => 'tepat waktu',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('absensi');
    }

    public function down()
    {
        $this->forge->dropTable('absensi');
    }
}
