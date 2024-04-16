<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Charts\MembersCharts;
use App\Exports\MembersExport;

class WelcomeController extends Controller
{
    public function index(MembersCharts $chart){
        $breadcrumb = (object)[
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Dashboard']
        ];

        $activeMenu = 'dashboard';
        // return view('welcome', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
        return view('beranda.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu, 'chart' => $chart->build()]);
    }

    public function list(Request $request)
    {
        $users = UserModel::with('level')
                ->whereRelation('level', 'level_nama', 'Member' );

        if($request->level_id){
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
        ->addColumn('aksi', function ($user) { // menambahkan kolom aksi
        $btn = '<a href="'.url('/member/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
        $btn .= '<a href="'.url('/member/updateValidation/' . $user->user_id ).'" class="btn btn-warning btn-sm">'.($user->status == 0 ? 'Validate' : 'Unvalidate' ).'</a> ';
        $btn .= '<form class="d-inline-block" method="POST" action="'. url('/member/'.$user->user_id).'">'. csrf_field() . method_field('DELETE') . 
        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Delete</button></form>'; 
        
        return $btn;
        })
        ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
        ->make(true);
    }
    
    public function exportPdf()
    {
        $members = UserModel::with('level')
        ->whereRelation('level', 'level_nama', 'Member' )
        ->get();

        $pdf = Pdf::loadView('tabel_export.tabel_member', [
            'members' => $members,
            'title' => 'Data Member'
        ]);

        return response()->streamDownload(function() use($pdf){
            echo $pdf->stream();
        }, 'Data_Member.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(new MembersExport, 'Data_Member.xlsx');
    }

    public function show(string $id)
    {
        $member = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'Member', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail user'
        ];

        $activeMenu = 'dashboard';

        return view('beranda.member', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page,
            'member' => $member,
            'activeMenu' => $activeMenu
        ]);
    }

    public function updateValidation($id)
    {
        $user = UserModel::find($id);

        $user->update([
            'status' => !(bool) $user->status
        ]);

        return redirect('/')->with('success', 'Status validasi member berhasil diubah');
    }

    public function destroy(string $id)
    {
        $member = UserModel::find($id);

        if(!$member){
            return redirect('/user')->with('error', 'Data member tidak ditemukan');
        }

        try {
            if(!empty( $member->profile_img)){        
                Storage::delete('public/profile/'.$member->profile_img);
            }

            $member->delete();

            return redirect('/')->with('success', 'Data member berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect('/')->with('/error', 'Data member gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
