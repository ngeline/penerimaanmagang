<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PengajuanAnggota extends Migration
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
            'pengajuan_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'siswa_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengajuan_anggota');
    }

    public function down()
    {
        $this->forge->dropTable('pengajuan_anggota');
    }
}
