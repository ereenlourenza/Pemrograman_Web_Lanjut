<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StokController extends Controller
{
    //Home Stok
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Stok',
            'list' => ['Home', 'Stok']
        ];

        $page =(object)[
            'title' => 'Daftar stok yang terdaftar dalam sistem'
        ];

        $activeMenu = 'stok'; //set menu yang sedang aktif

        $barang = BarangModel::all(); //ambil data barang untuk filter barang
        $user = UserModel::all(); //ambil data user untuk filter user
        
        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);

    }

    //Ambil data stok dalam bentuk json untuk datatables
    public function list(Request $request){
        $stoks = StokModel::select('stok_id', 'stok_tanggal', 'stok_jumlah', 'barang_id', 'user_id') ->with('barang', 'user');

        //Filter data stok berdasarkan barang dan user
        if($request->barang_id){
            $stoks->where('barang_id', $request->barang_id);
        }
        
        if($request->user_id){
            $stoks->where('user_id', $request->user_id);
        }
        
        return DataTables::of($stoks)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($stok) { // menambahkan kolom aksi
                $btn = '<a href="'.url('/stok/' . $stok->stok_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/stok/' . $stok->stok_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/stok/'.$stok->stok_id).'">'. csrf_field() . method_field('DELETE') . 
                '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>'; 
                
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    //Menampilkan halaman form tambah stok
    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah Stok',
            'list' => ['Home', 'Stok', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah stok baru'
        ];

        $barang = BarangModel::all(); //ambil data barang untuk ditampilkan di form
        $user = UserModel::all(); //ambil data barang untuk ditampilkan di form

        $activeMenu = 'stok'; //set menu yang sedang aktif

        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan data stok baru
    public function store(Request $request){
        $request->validate([
            'stok_tanggal'  => 'required|date',
            'stok_jumlah'   => 'required|integer',
            'barang_id'     => 'required|integer',
            'user_id'       => 'required|integer',
        ]);

        StokModel::create([
            'stok_tanggal'  => $request->stok_tanggal,
            'stok_jumlah'   => $request->stok_jumlah,
            'barang_id'     => $request->barang_id,
            'user_id'       => $request->user_id
        ]);

        return redirect('/stok')->with('success', 'Data stok berhasil disimpan');
    }

    //Menampilkan detail
    public function show(string $id){
        $stok = StokModel::with('barang', 'user')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Stok',
            'list'  => ['Home', 'Stok', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail stok'
        ];

        $activeMenu = 'stok'; //set menu yang sedang aktif

        return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }

    //Menampilkan halaman form edit stok
    public function edit(string $id){
        $stok = StokModel::find($id);

        $barang = BarangModel::all();
        $user = UserModel::all();

        $breadcrumb = (object)[
            'title' => 'Edit Stok',
            'list'  => ['Home', 'Stok', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Stok'
        ];

        $activeMenu = 'stok'; //set menu yang sedang aktif

        return view('stok.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan perubahan data stok
    public function update(Request $request, string $id){
        $request->validate([
            'stok_tanggal'  => 'required|date',
            'stok_jumlah'   => 'required|integer',
            'barang_id'     => 'required|integer',
            'user_id'       => 'required|integer',
        ]);
        
        StokModel::find($id)->update([
            'stok_tanggal'  => $request->stok_tanggal,
            'stok_jumlah'   => $request->stok_jumlah,
            'barang_id'     => $request->barang_id,
            'user_id'       => $request->user_id
        ]);

        return redirect('/stok')->with('success', 'Data stok berhasil diubah');
    }

    //Menghapus data stok
    public function destroy(string $id){
        $check = StokModel::find($id);
        if(!$check){        //untuk mengecek apakah data stok dengan id yang dimaksud ada atau tidak
            return redirect('/stok')->with('error', 'Data stok tidak ditemukan');
        }

        try{
            StokModel::destroy($id); //Hapus data kategori

            return redirect('/stok')->with('success', 'Data stok berhasil dihapus');
        }catch(\Illuminate\Database\QueryException $e){

            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/stok')->with('error', 'Data stok gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
