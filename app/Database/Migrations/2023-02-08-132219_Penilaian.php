<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penilaian extends Migration
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
            'magang_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'kategori_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
            ],
            'huruf' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'nilai' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'created_at datetime default current_timestamp',
            'updated_at datetime default current_timestamp on update current_timestamp'
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('penilaian');
    }

    public function down()
    {
        $this->forge->dropTable('penilaian');
    }
}
