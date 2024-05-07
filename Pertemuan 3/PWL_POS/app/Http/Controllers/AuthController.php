<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AuthController extends Controller
{
    public function index(){
        // kita ambil data user lalu simpan pada variable $user
        $user = Auth::user();

        // kondisi jika user nya ada
        if ($user){
            // jika user nya memiliki level admin
            if ($user->level_id == '1'){
                return redirect()->intended('admin');
            }   
            // jika user nya memiliki level manager
            else if ($user->level_id == '2'){
                return redirect()->intended('manager');
            }
        }
        return view('login');
    }

    public function proses_login(Request $request){
        // kita buat validasi pada saat tombol login di klik
        // validasi nya username & password wajib di isi
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // ambil data request username & password saja
        $credential = $request->only('username', 'password');
        // cek jika data username dan password valid (sesuai) dengan data
        if (Auth::attempt($credential)){
            // kalau berhasil simpan data user nya di variabel $user
            $user = Auth::user();

            // cek lagi jika level user admin maka arahkan ke halaman admin
            if ($user->level_id == '1'){
                //dd($user->level_id);
                return redirect()->intended('admin');
            }
            //tapi jika level user nya user biasa maka arahkan ke halaman user
            else if ($user->level_id == '2'){
                return redirect()->intended('manager');
            }
            // jika belum ada role maka ke halaman /
            return redirect()->intended('/');
        }
        // jika ga ada data user yang valid maka kembalikan lagi ke halaman login
        // pastikan kirim pesan error juga kalau login gagal ya
        return redirect('login')
            ->withInput()
            ->withErrors(['login_gagal' => 'Pastikan kembali username dan password yang dimasukkan sudah benar']);
    }

    public function register(){
        // tampilkan view register
        return view('register');
    }

    // aksi form register
    public function proses_register(Request $request){
        // validasi semua field wajib di isi 
        // validasi username unique
        $validator = FacadesValidator::make($request->all(),[
            'nama'=> 'required',
            'username'=>'required|unique:m_user',
            'password'=>'required'
        ]);

        // kalau gagal kembali ke halaman register dan muncul pesna error 
        if ($validator ->fails()) {
            return redirect('/regsiter')
            ->withErrors($validator)
            ->withInput();
        }

        // kalau berhasil isi level dan hash passwordnya biar secure
        $request['level_id']='2';
        $request['password'] = Hash::make($request -> password);

        // masukkan semua data pada request ke tabel m_user
        UserModel::create($request->all());

        // kalo berhasil arahkan ke halaman login 
        return redirect()->route('login');
    }

    public function logout(Request $request){
        // logout itu harus menghapus sessionnya 
        $request->session()->flush();

        // jalankan fungsi logout pada auth
        Auth::logout();

        // kembali ke halaman login 
        return redirect('login');
    }

    // =============================================================
    // =============================UTS=============================
    // =============================================================

    // public function index(){
    //     return view('auth.login');
    // }

    // public function authenticate(Request $request){
    //     $credentials = $request->validate([
    //         'username' => ['required'],
    //         'password' => ['required'],
    //     ]);
 
    //     if (Auth::attempt($credentials)) {
    //         $user = UserModel::where('username', $credentials['username'])->first();
            
    //         if($user->status == 0)  return back()->withErrors(['status' => 'Akun Anda belum divalidasi.']);

    //         $request->session()->regenerate();
 
    //         return redirect()->route('beranda.index');
    //     }
 
    //     return back()->withErrors([
    //         'authentication' => 'Username/Password invalid',
    //     ])->onlyInput('username');
    // }

    // public function logout(Request $request){
    //     Auth::logout();
    
    //     $request->session()->invalidate();
    
    //     $request->session()->regenerateToken();
    
    //     return redirect()->route('login.index');
    // }

    // public function register()
    // {
    //     return view('auth.register');
    // }

    // public function storeMember(Request $request): RedirectResponse //: RedirectResponse is return type
    // {
    //     $newUser = $request->validate([
    //         'username' => ['required', 'unique:m_user,username'],
    //         'nama' => ['required'],
    //         'password' => ['required', 'min:6'],
    //         'confirm_password' => ['required', 'same:password'],
    //         'profile_img' => ['required', 'mimes:png,jpg,jpeg', 'max:1024'],
    //     ]);

    //     $newUser['level_id'] = 4; //member
    //     $newUser['status'] = 0; //harus divalidasi

    //     try {
    //         DB::beginTransaction();

    //         // Store profile image
    //         $profileImg = $newUser['profile_img'];
    //         $profileName = Str::random(10).$newUser['profile_img']->getClientOriginalName();
    //         $profileImg->storeAs('public/profile', $profileName);

    //         // Overide profile_img name
    //          $newUser['profile_img'] = $profileName;
            
    //         userModel::create($newUser);

    //         DB::commit();
    //         return redirect()->route('login.index')->with('success', 'Registrasi telah disimpan, tetapi dimohon menunggu untuk validasi akun oleh Admin.');

    //     } catch (\Throwable $th) {
    //         DB::rollback();

    //         return back()->withErrors([
    //             'error' => $th->getMessage(),
    //         ]);
    //     }
    // }
}
