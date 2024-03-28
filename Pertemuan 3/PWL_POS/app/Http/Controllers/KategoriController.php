<?php

namespace App\Http\Controllers;

use App\DataTables\KategoriDataTable;
use App\Models\KategoriModel;
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

    public function create(){
        return view('kategori.create');
    }

    public function store(Request $request){
        KategoriModel::create([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori,
        ]);
        return redirect('/kategori');
    }

    public function edit($id){
        $kategori = KategoriModel::find($id);
        return view('kategori.edit',['kategori'=>$kategori]);
    }

    public function update($id, Request $request){
        $kategori = KategoriModel::find($id);
        // dd($request->all());
        // $data = $request->except('_token'); 
        $kategori->update($request->all());
        // $kategori->update([
        //     'kategori_kode' => $request->kategori_kode,
        //     'kategori_nama' => $request->kategori_nama,
        // ]);
        return redirect('/kategori');
    }

    public function delete($id){
        $kategori = KategoriModel::find($id);
        $kategori->delete();
        
        return redirect('/kategori');
    }
}
