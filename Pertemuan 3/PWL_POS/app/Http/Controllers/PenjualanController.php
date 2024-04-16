<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\StokModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    //Home Penjualan
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page =(object)[
            'title' => 'Daftar penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan'; //set menu yang sedang aktif

        $user = UserModel::all(); //ambil data user untuk filter user
        
        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user,'activeMenu' => $activeMenu]);

    }

    // //Ambil data penjualan dalam bentuk json untuk datatables
    // public function list(Request $request){
    //     $penjualans = PenjualanModel::select('penjualan_id','pembeli', 'penjualan_kode', 'penjualan_tanggal', 'user_id') ->with('user');

    //     //Filter data penjualan berdasarkan user_id
    //     if($request->user_id){
    //         $penjualans->where('user_id', $request->user_id);
    //     }
        
    //     return DataTables::of($penjualans)
    //         ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
    //         ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
    //             $btn = '<a href="'.url('/penjualan/' . $penjualan->penjualan_id).'" class="btn btn-info btn-sm">Detail</a> ';
    //             $btn .= '<a href="'.url('/penjualan/' . $penjualan->penjualan_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
    //             $btn .= '<form class="d-inline-block" method="POST" action="'. url('/penjualan/'.$penjualan->penjualan_id).'">'. csrf_field() . method_field('DELETE') . 
    //             '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>'; 
                
    //             return $btn;
    //         })
    //         ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
    //         ->make(true);
    // }

    public function list(Request $request){

        $penjualans = (object) DB::table('t_penjualan as p')
            ->join('t_penjualan_detail as pd', 'p.penjualan_id', '=', 'pd.penjualan_id')
            ->join('m_user as u', 'p.user_id', '=', 'u.user_id')
            ->selectRaw('p.penjualan_id, p.pembeli, p.penjualan_kode, p.penjualan_tanggal , u.nama, sum(pd.harga * pd.jumlah) as total')
            ->groupBy('u.nama')
            ->groupBy('p.penjualan_id')
            ->groupBy('p.pembeli')
            ->groupBy('p.penjualan_kode')
            ->groupBy('p.penjualan_tanggal')
            ->get();

// dd($penjualans);

        // Filter data penjualan berdasarkan user_id
        if($request->user_id){
            $penjualans->where('user_id', $request->user_id);
        }

        return DataTables::of($penjualans)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
                $btn = '<a href="'.url('/penjualan/' . $penjualan->penjualan_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/penjualan/' . $penjualan->penjualan_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'. url('/penjualan/'.$penjualan->penjualan_id).'">'. csrf_field() . method_field('DELETE') . 
                '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>'; 
                
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    //Menampilkan halaman form tambah penjualan
    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah Penjualan',
            'list' => ['Home', 'Penjualan', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah penjualan baru'
        ];

        $user = UserModel::all(); //ambil data user untuk ditampilkan di form
        $barang = StokModel::where('stok_jumlah', '>', 0)->with('barang')->get();

        $activeMenu = 'penjualan'; //set menu yang sedang aktif

        return view('penjualan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan data penjualan baru
    public function store(Request $request){
        $request->validate([
            //penjualan_kode harus diisi, berupa string, minimal 4 karakter, dan bernilai unik di tabel t_penjualan kolom penjualan_kode
            'pembeli'           => 'required|string|max:50',
            'penjualan_kode'    => 'required|required:P|string|min:3|unique:t_penjualan,penjualan_kode',                    
            'penjualan_tanggal' => 'required|date',              //harga_beli harus diisi dan berupa angka
            'user_id'           => 'required|integer',               //user_id harus diisi dan berupa angka
            'barang_id'         => 'required|array'
        ]);

        $barang = BarangModel::all();

        DB::beginTransaction();

        $penjualan = PenjualanModel::create($request->all());
        $barangLaku = $request->only('barang_id');

        foreach($barangLaku as $key => $item){
            PenjualanDetailModel::create([
                'penjualan_id'  => $penjualan->penjualan_id,
                'barang_id'     => $item[0],
                'harga'         => $barang->find($item[0])->harga_jual,
                'jumlah'        => $request->jumlah
            ]);

            $stok = StokModel::where('barang_id', $item[0])->with('barang')->first();
            $stok -> decrement('stok_jumlah', 1);

            if($stok->stok_jumlah < 0){
                return back()->with('error', 'Stok' .$stok->barang_nama. ' Tidak Mencukupi');
            }
        }

        DB::commit();

        // PenjualanModel::create([
        //     'pembeli'           => $request->pembeli,
        //     'penjualan_kode'    => $request->penjualan_kode,
        //     'penjualan_tanggal' => $request->penjualan_tanggal,
        //     'user_id'           => $request->user_id
        // ]);
        
        return redirect('/penjualan')->with('success', 'Data penjualan berhasil disimpan');
    }

    //Menampilkan detail
    public function show(string $id){
        $penjualan = PenjualanModel::with('user')->find($id);
        $penjualan_detail = PenjualanDetailModel::where('penjualan_id', $id)->with('barang')->get();

        $breadcrumb = (object)[
            'title' => 'Detail Penjualan',
            'list'  => ['Home', 'Penjualan', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail penjualan'
        ];

        $activeMenu = 'penjualan'; //set menu yang sedang aktif

        return view('penjualan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'penjualan_detail' => $penjualan_detail, 'activeMenu' => $activeMenu]);
    }

    //Menampilkan halaman form edit penjualan
    public function edit(string $id){
        $penjualan = PenjualanModel::find($id);
        $penjualan_detail = PenjualanDetailModel::where('penjualan_id', $id)->get();

        $barang = StokModel::where('stok_jumlah', '>', 0)->with('barang')->get();
        $user = UserModel::all();

        $breadcrumb = (object)[
            'title' => 'Edit Penjualan',
            'list'  => ['Home', 'Penjualan', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit Penjualan'
        ];

        $activeMenu = 'penjualan'; //set menu yang sedang aktif

        return view('penjualan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'penjualan_detail' => $penjualan_detail, 'barang' => $barang, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    //Menyimpan perubahan data penjualan
    public function update(Request $request, string $id){
        // dd($request->all(), $id);
        $request->validate([
            'pembeli'           => 'nullable|string',
            'penjualan_kode'    => 'nullable|string',
            'penjualan_tanggal' => 'nullable|date',
            'user_id'           => 'nullable|integer',
            'barang_id'         => 'nullable|array',
        ]);

        DB::beginTransaction();

        $penjualan = PenjualanModel::find($id);
        $penjualan->update($request->all());
        $barang = BarangModel::all();

        $barangLaku = $request->only('barang_id');

        if(count($barangLaku) > 0){
            PenjualanDetailModel::where('penjualan_id', $id)->delete();

            foreach ($barangLaku as $key => $item) {

                PenjualanDetailModel::create([
                    'penjualan_id'  => $penjualan->penjualan_id,
                    'barang_id'     => $item[0],
                    'harga'         => $barang->find($item[0])->harga_jual,
                    'jumlah'        => $request->jumlah,
                ]);
    
                $stok = stokModel::where('barang_id', $item[0])->with('barang')->first();
                $stok->decrement('stok_jumlah', 1);
    
                if($stok->stok_jumlah < 0 ){
                    return back()->with('error', 'Stok '.$stok->barang_nama.' Tidak Mencukupi');
                }
            }
        }

        DB::commit();

        return redirect('/penjualan')->with('success', 'Data penjualan berhasil diubah');
    }

    //Menghapus data penjualan
    public function destroy(string $id){
        $check = PenjualanModel::find($id);
        if(!$check){        //untuk mengecek apakah data penjualan dengan id yang dimaksud ada atau tidak
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }

        try{
            $penjualan_detail = PenjualanDetailModel::where('penjualan_id', $id)->get();

            foreach ($penjualan_detail as $key => $item){
                $item->delete();
            }

            PenjualanModel::destroy($id); //Hapus data user

            return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
        }catch(\Illuminate\Database\QueryException $e){

            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/penjualan')->with('error', 'Data penjualan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
