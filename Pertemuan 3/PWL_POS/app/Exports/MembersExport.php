<?php

namespace App\Exports;

use App\Models\UserModel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class MembersExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View

    {
        $members = UserModel::with('level')
        ->whereRelation('level', 'level_nama', 'Member' )
        ->get();

        return view('tabel_export.tabel_member', ['members' => $members]);

    }
}
