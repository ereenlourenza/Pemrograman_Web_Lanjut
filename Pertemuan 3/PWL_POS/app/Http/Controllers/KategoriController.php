<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable){
        return $dataTable->render('kategori.index');
        // $data = [
        //     'kategori_kode' => 'SNK',
        //     'kategori_nama' => 'Snack/Makanan Ringan',
        //     'created_at' => now(),
        // ];
        // DB::table('m_kategori')->INSERT($data);
        // return 'Insert data baru berhasil';

        // $row = DB::table('m_kategori')
        // ->WHERE('kategori_kode', 'SNK')
        // ->UPDATE(['kategori_nama' => 'Camilan']);
        // return 'Update data berhasil. Jumlah data yang diupdate: ' .$row. ' baris';

        // $row = DB::table('m_kategori')
        // ->WHERE('kategori_kode', 'SNK')
        // ->DELETE();
        // return 'Delete data berhasil. Jumlah data yang dihapus: ' .$row. ' baris';

        // $data = DB::table('m_kategori')->get();
        // return view('kategori', ['data' => $data]);
    }
}
