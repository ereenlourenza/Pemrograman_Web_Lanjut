<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $user = UserModel::firstOrNew(
            [
                'username' => 'manager33',
                'nama' => 'Manager Tiga Tiga',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],
        );
        $user->save();
        return view('user',['data' => $user]);
        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager',
        //     ],
        // );
        // return view('user',['data' => $user]);
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager22',
        //         'nama' => 'Manager Dua Dua',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );
        // return view('user',['data' => $user]);
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager'
        //     ],
        // );
        // return view('user',['data' => $user]);

        // Ambil model dengan kunci utamanya...

        // $user = UserModel::where('level_id',2)->count();
        // // dd($user);
        // return view('user',['data' => $user]);

        // $user = UserModel::where('username','manager')->firstOrFail();
        // $user = UserModel::findOurFail(1);
        // $user = UserModel::findOr(1, ['username', 'nama'], function(){
        //     abort(404);
        // }); //coba kalau idnya 20
        // $user = UserModel::firstWhere('level_id',1);
        // $user = UserModel::where('level_id',1)->first();
        // $user = UserModel::find(1);
        // return view('user', ['data' => $user]);
        
        // //tambah data user dengan Eloquent Model
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_tiga',
        //     'nama' => 'Manager 3',
        //     'password' => Hash::make('12345'),
        // ];
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_dua',
        //     'nama' => 'Manager 2',
        //     'password' => Hash::make('12345'),
        // ];
        // UserModel::create($data);

        // //update data user dengan Eloquent Model
        // $data = [
        //     'nama' => 'Pelanggan Pertama',
        // ];
        // UserModel::where('username', 'customer-1')->update($data); //update data user

        // //coba akses model UserModal
        // $user = UserModel::all(); //ambil semua data dari tabel m_user
        // return view('user', ['data' => $user]);
    }
}