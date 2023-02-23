<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kegiatan extends Migration
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
            'kegiatan' => [
                'type' => 'TEXT',
            ],
            'foto_kegiatan' => [
                'type' => 'TEXT',
            ],
            'status_kegiatan' => [
                'type' => 'ENUM',
                'constraint' => "'diterima', 'ditolak', 'diproses'",
                'null' => false,
                'default' => 'diproses',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kegiatan');
    }

    public function down()
    {
        $this->forge->dropTable('kegiatan');
    }
}
