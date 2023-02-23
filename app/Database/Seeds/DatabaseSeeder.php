<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $user = [
            [
                'id' => Uuid::uuid4()->toString(),
                'username' => 'admin',
                'role' => 'admin',
                'password' => password_hash('12345678', PASSWORD_DEFAULT)
            ]
        ];

        $bidang = [
            [
                'id' => Uuid::uuid4()->toString(),
                'nama_bidang' => 'Bidang Sekretariat',
                'singkatan_bidang' => 'Sekretariat',
                'kepala_bidang' => 'Wahyu Hermawan S. Pd.',
                'nip' => '19780812 20012 2 004',
                'ttd' => 'ttd(1).png',
                'keterangan' => 'Ruangan C1'
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'nama_bidang' => 'Bidang Pembinaan Pendidik dan Tenaga Kependidikan (PTK)',
                'singkatan_bidang' => 'PTK',
                'kepala_bidang' => 'Hiroatus Solihatin S. Pd.',
                'nip' => '19780812 20012 2 014',
                'ttd' => 'ttd(2).png',
                'keterangan' => 'Ruangan C2'
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'nama_bidang' => 'Bidang Pembinaan Pendidikan Dasar (Dikdas)',
                'singkatan_bidang' => 'DIKDAS',
                'kepala_bidang' => 'Erna Suparina S. Pd.',
                'nip' => '19780812 20012 2 114',
                'ttd' => 'ttd(3).png',
                'keterangan' => 'Ruangan C3'
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'nama_bidang' => 'Bidang Pembinaan Pendidikan Anak Usia Dini (PAUD) dan Pendidikan Non Formal (PNF)',
                'singkatan_bidang' => 'PAUD & PNF',
                'kepala_bidang' => 'Maman Setyo S. Pd.',
                'nip' => '19780812 20012 3 444',
                'ttd' => 'ttd(4).png',
                'keterangan' => 'Ruangan C4'
            ],
        ];

        $kategori = [
            [
                'id' => Uuid::uuid4()->toString(),
                'nama_kategori' => 'Kejujuran',
                'keterangan' => 'Sebuah sifat yang membutuhkan kesesuaian antara perkataan yang diucapkan serta perbuatan yang dilakukan oleh seseorang'
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'nama_kategori' => 'Kedisiplinan',
                'keterangan' => 'Suatu kondisi yang tercipta dan terbentuk melalui proses dari serangkaian perilaku yang menunjukkan nilai-nilai ketaatan, kepatuhan, kesetiaan, keteraturan dan ketertiban'
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'nama_kategori' => 'Adaptasi Lingkungan',
                'keterangan' => 'Penyesuaian diri yang dilakukan makhluk hidup terhadap lingkungannya sebagai bentuk pertahanan diri'
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'nama_kategori' => 'Kerjasama Tim',
                'keterangan' => 'Upaya kolaborasi dari suatu kelompok untuk mencapai tujuan bersama atau menyelesaikan tugas dengan cara yang paling efektif dan efisien secara berkelompok'
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'nama_kategori' => 'Kecakapan',
                'keterangan' => 'Kemampuan yang dipelajari untuk bertindak dengan hasil yang ditentukan dengan pelaksanaan yang baik sering kali dalam jumlah waktu, energi, atau keduanya tertentu'
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'nama_kategori' => 'Kreativitas Kerja',
                'keterangan' => 'Kemampuan seseorang memecahkan masalah dunia kerja dengan ide baru atau inovasi.'
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'nama_kategori' => 'Hasil Kerja',
                'keterangan' => 'Objek berwujud atau tak berwujud yang merupakan hasil pelaksanaan proyek, sebagai bagian dari suatu kewajiban atau obligasi'
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'nama_kategori' => 'Penampilan',
                'keterangan' => 'Segala sesuatu yang berhubungan dengan penampilan luar manusia yang mudah diamati dan dinilai oleh manusia lain. Penampilan fisik secara disadari atau tidak, dapat menimbulkan respon atau tanggapan tertentu dari orang lain'
            ],
            [
                'id' => Uuid::uuid4()->toString(),
                'nama_kategori' => 'Etika',
                'keterangan' => 'Nilai moral dan norma yang menjadi pedoman, baik bagi suatu individu maupun suatu kelompok, dalam mengatur tindakan atau perilaku'
            ],
        ];

        $this->db->table('users')->insertBatch($user);
        $this->db->table('bidang')->insertBatch($bidang);
        $this->db->table('kategori_penilaian')->insertBatch($kategori);
    }
}
