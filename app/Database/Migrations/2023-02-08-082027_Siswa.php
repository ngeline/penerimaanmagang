<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Siswa extends Migration
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
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => "'l', 'p'",
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
                'null' => true
            ],
            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'jenjang' => [
                'type' => 'ENUM',
                'constraint' => "'Perguruan Tinggi', 'SLTA'",
                'null' => true,
            ],
            'prodi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'jurusan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'kelas' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'tingkat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'asal_sekolah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'perguruan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true
            ],
            'nisn' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true
            ],
            'status_lengkap' => [
                'type' => 'ENUM',
                'constraint' => "'lengkap', 'tidak'",
                'null' => false,
                'default' => 'tidak',
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
        $this->forge->createTable('siswa');
    }

    public function down()
    {
        $this->forge->dropTable('siswa');
    }
}
