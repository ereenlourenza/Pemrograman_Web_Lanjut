<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $user = UserModel::where('username', $credentials['username'])->first();
            
            if($user->status == 0)  return back()->withErrors(['status' => 'Akun Anda belum divalidasi.']);

            $request->session()->regenerate();
 
            return redirect()->route('beranda.index');
        }
 
        return back()->withErrors([
            'authentication' => 'Username/Password invalid',
        ])->onlyInput('username');
    }

    public function logout(Request $request){
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('login.index');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function storeMember(Request $request): RedirectResponse //: RedirectResponse is return type
    {
        $newUser = $request->validate([
            'username' => ['required', 'unique:m_user,username'],
            'nama' => ['required'],
            'password' => ['required', 'min:6'],
            'confirm_password' => ['required', 'same:password'],
            'profile_img' => ['required', 'mimes:png,jpg,jpeg', 'max:1024'],
        ]);

        $newUser['level_id'] = 4; //member
        $newUser['status'] = 0; //harus divalidasi

        try {
            DB::beginTransaction();

            // Store profile image
            $profileImg = $newUser['profile_img'];
            $profileName = Str::random(10).$newUser['profile_img']->getClientOriginalName();
            $profileImg->storeAs('public/profile', $profileName);

            // Overide profile_img name
             $newUser['profile_img'] = $profileName;
            
            userModel::create($newUser);

            DB::commit();
            return redirect()->route('login.index')->with('success', 'Registrasi telah disimpan, tetapi dimohon menunggu untuk validasi akun oleh Admin.');

        } catch (\Throwable $th) {
            DB::rollback();

            return back()->withErrors([
                'error' => $th->getMessage(),
            ]);
        }
    }
}
