<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    //Home Barang
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page =(object)[
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang'; //set menu yang sedang aktif

        $kategori = KategoriModel::all(); //ambil data kategori untuk filter kategori
        
        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori,'activeMenu' => $activeMenu, 'notifUser' => UserModel::all()]);

    }

    //Ambil data barang dalam bentuk json untuk datatables
    public function list(Request $request){
        $barangs = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id') ->with('kategori');

        //Filter data barang berdasarkan kategori_id
        if($request->kategori_id){
            $barangs->where('kategori_id', $request->kategori_id);
        }
        
        return DataTables::of($barangs)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi
                $btn = '<a href="'.url('/barang/' . $barang->barang_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/barang/' . $barang->barang_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/barang/'.$barang->barang_id).'">'. csrf_field() . method_field('DELETE') . 
                '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>'; 
                
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    //Menampilkan halaman form tambah barang
    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah barang baru'
        ];

        $kategori = KategoriModel::all(); //ambil data kategori untuk ditampilkan di form

        $activeMenu = 'barang'; //set menu yang sedang aktif

        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu, 'notifUser' => UserModel::all()]);
    }

    //Menyimpan data barang baru
    public function store(Request $request){
        $newBarang = $request->validate([
            //barang_kode harus diisi, berupa string, minimal 4 karakter, dan bernilai unik di tabel m_barang kolom barang_kode
            // 'barang_kode'   => 'required|string|min:3|max:40|unique:m_barang,barang_kode',  
            'barang_nama'   => 'required|string|max:50',        //barang_nama harus diisi, berupa string, dan maksimal 50 karakter                     
            'harga_beli'    => 'required|integer|',//,lt:harga_jual',              //harga_beli harus diisi dan berupa angka
            'harga_jual'    => 'required|integer|gt:harga_beli',              //harga_jual harus diisi dan berupa angka     
            'kategori_id'   => 'required|integer',               //kategori_id harus diisi dan berupa angka
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //Store kode barang
        $kategori = KategoriModel::find($request->kategori_id);
        $dateNow = Carbon::now()->format('dmY');
        $barangKategori = (BarangModel::orderBy('barang_id', 'desc')->first())->barang_id + 1;
        $barangKode = $kategori->kategori_kode . $request->barang_kode . ($barangKategori < 10 ? ('0' . $barangKategori) : $barangKategori) . $dateNow;

        // Store image
        $barangImg = $newBarang['image'];
        $barangName = $request->image->hashName();
        $barangImg->storeAs('public/barang', $barangName);


        BarangModel::create([
            'barang_kode'   => $barangKode,
            'barang_nama'   => $request->barang_nama,
            'harga_beli'    => $request->harga_beli,
            'harga_jual'    => $request->harga_jual,
            'kategori_id'   => $request->kategori_id,
            'image'         => $barangName,
        ]);

        // Overide image
        $newBarang['image'] = $barangName;


        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    //Menampilkan detail
    public function show(string $id){
        $barang = BarangModel::with('kategori')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Barang',
            'list'  => ['Home', 'Barang', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail barang'
        ];

        $activeMenu = 'barang'; //set menu yang sedang aktif

        return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu, 'notifUser' => UserModel::all()]);
    }

    //Menampilkan halaman form edit barang
    public function edit(string $id){
        $barang = BarangModel::find($id);

        $kategori = KategoriModel::all();

        $breadcrumb = (object)[
            'title' => 'Edit Barang',
            'list'  => ['Home', 'Barang', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Barang'
        ];

        $activeMenu = 'barang'; //set menu yang sedang aktif

        return view('barang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang,'kategori' => $kategori, 'activeMenu' => $activeMenu, 'notifUser' => UserModel::all()]);
    }

    //Menyimpan perubahan data barang
    public function update(Request $request, string $id){
        $newBarang = $request->validate([
            //barang_kode harus diisi, berupa string, minimal 3 karakter, maksimal 10 karakter
            //dan bernilai unik di tabel m_barang kolom barang_kode kecuali untuk barang dengan id yang sedang diedit
            // 'barang_kode'   => 'required|string|min:3|max:40|unique:m_barang,barang_kode,'.$id.',barang_id',
            'barang_nama'   => 'required|string|max:50',        //barang_nama harus diisi, berupa string, dan maksimal 50 karakter
            'harga_beli'    => 'required|integer',              //harga_beli harus diisi dan berupa angka
            'harga_jual'    => 'required|integer',              //harga_jual harus diisi dan berupa angka
            'kategori_id'   => 'required|integer',               //kategori_id harus diisi dan berupa angka
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Store image
        $barangImg = $newBarang['image'];
        $barangName = $request->image->hashName();
        $barangImg->storeAs('public/barang', $barangName);
        
        BarangModel::find($id)->update([
            // 'barang_kode'   => $request->barang_kode,
            'barang_nama'   => $request->barang_nama,
            'harga_beli'    => $request->harga_beli,
            'harga_jual'    => $request->harga_jual,
            'kategori_id'   => $request->kategori_id,
            'image'         => $request->image->hashName(),
        ]);

        // Overide image
        $newBarang['image'] = $barangName;

        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }

    //Menghapus data barang
    public function destroy(string $id){
        $check = BarangModel::find($id);
        if(!$check){        //untuk mengecek apakah data barang dengan id yang dimaksud ada atau tidak
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try{
            BarangModel::destroy($id); //Hapus data kategori

            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        }catch(\Illuminate\Database\QueryException $e){

            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
