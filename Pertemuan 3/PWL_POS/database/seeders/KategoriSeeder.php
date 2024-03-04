<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kategori_id' => 1,
                'kategori_kode' => 'FSH',
                'kategori_nama' => 'Fashion',
            ],
            [
                'kategori_id' => 2,
                'kategori_kode' => 'KCT',
                'kategori_nama' => 'Kecantikan',
            ],
            [
                'kategori_id' => 3,
                'kategori_kode' => 'ELK',
                'kategori_nama' => 'Elektronik',
            ],
            [
                'kategori_id' => 4,
                'kategori_kode' => 'SBK',
                'kategori_nama' => 'Sembako',
            ],
            [
                'kategori_id' => 5,
                'kategori_kode' => 'PRT',
                'kategori_nama' => 'Perlengkapan Rumah Tangga',
            ],
        ];
        DB::table('m_kategori')->insert($data);
    }
}
