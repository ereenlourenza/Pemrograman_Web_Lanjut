<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'barang_id' => 1,
                'kategori_id' => 1,
                'barang_kode' => 'ATG',
                'barang_nama' => 'Anting',
                'harga_beli' => 18000,
                'harga_jual' => 20000,
            ],
            [
                'barang_id' => 2,
                'kategori_id' => 1,
                'barang_kode' => 'JTG',
                'barang_nama' => 'Jam Tangan',
                'harga_beli' => 85000,
                'harga_jual' => 100000,
            ],
            [
                'barang_id' => 3,
                'kategori_id' => 2,
                'barang_kode' => 'DDR',
                'barang_nama' => 'Deodoran',
                'harga_beli' => 15000,
                'harga_jual' => 17000,
            ],
            [
                'barang_id' => 4,
                'kategori_id' => 2,
                'barang_kode' => 'SBW',
                'barang_nama' => 'Sabun Wajah',
                'harga_beli' => 26000,
                'harga_jual' => 29000,
            ],
            [
                'barang_id' => 5,
                'kategori_id' => 3,
                'barang_kode' => 'KMR',
                'barang_nama' => 'Kamera',
                'harga_beli' => 3850000,
                'harga_jual' => 4000000,
            ],
            [
                'barang_id' => 6,
                'kategori_id' => 3,
                'barang_kode' => 'PBK',
                'barang_nama' => 'Powerbank',
                'harga_beli' => 75000,
                'harga_jual' => 80000,
            ],
            [
                'barang_id' => 7,
                'kategori_id' => 4,
                'barang_kode' => 'MYK',
                'barang_nama' => 'Minyak',
                'harga_beli' => 11000,
                'harga_jual' => 12000,
            ],
            [
                'barang_id' => 8,
                'kategori_id' => 4,
                'barang_kode' => 'BRS',
                'barang_nama' => 'Beras',
                'harga_beli' => 140000,
                'harga_jual' => 150000,
            ],
            [
                'barang_id' => 9,
                'kategori_id' => 5,
                'barang_kode' => 'DTR',
                'barang_nama' => 'Detergen',
                'harga_beli' => 9000,
                'harga_jual' => 10000,
            ],
            [
                'barang_id' => 10,
                'kategori_id' => 5,
                'barang_kode' => 'TSU',
                'barang_nama' => 'Tisu',
                'harga_beli' => 7000,
                'harga_jual' => 8000,
            ],
        ];
        DB::table('m_barang')->insert($data);
    }
}
