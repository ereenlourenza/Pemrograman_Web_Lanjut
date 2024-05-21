<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Ui\AuthCommand;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// =============================Jobsheet 12==========================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/file-upload', [FileUploadController::class, 'fileUpload']);
Route::post('/file-upload', [FileUploadController::class, 'prosesFileUpload']);

Route::get('/file-upload-rename', [FileUploadController::class, 'fileUploadRename']);
Route::post('/file-upload-rename', [FileUploadController::class, 'prosesFileUploadRename']);


// =============================Jobsheet 9==========================

// Route::get('login', [AuthController::class, 'index'])->name('login');
// Route::get('register', [AuthController::class, 'register'])->name('register');
// Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
// Route::get('logout', [AuthController::class, 'logout'])->name('logout');
// Route::post('proses_register', [AuthController::class, 'proses_register'])->name('proses_register');

// Route::group(['middleware'=> ['auth']], function(){
//     Route::group(['middleware'=>['cek_login:1']], function(){
//         Route::resource('admin', AdminController::class);
//     });
//     Route::group(['middleware'=>['cek_login:2']], function(){
//         Route::resource('admin', ManagerController::class);
//     });

// });

// =============================UTS=============================

// Route::get('/login', [AuthController::class, 'index'])->name('login.index');
// Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::get('/register', [AuthController::class, 'register'])->name('register.index');
// Route::post('/register', [AuthController::class, 'storeMember'])->name('register.storeMember');

// Route::middleware(['auth'])->group(function(){
    
//     Route::get('/', [WelcomeController::class, 'index'])->name('beranda.index');

//     Route::group(['prefix' => 'member'], function(){
//         Route::post('/list', [WelcomeController::class, 'list'])->name('member.list');
//         Route::get('/export-pdf', [WelcomeController::class, 'exportPdf'])->name('member.export.pdf');
//         Route::get('/export-excel', [WelcomeController::class, 'exportExcel'])->name('member.export.excel');
//         Route::get('/updateValidation/{id}', [WelcomeController::class, 'updateValidation'])->name('member.updateValidation');
//         Route::get('/{id}', [WelcomeController::class, 'show'])->name('member.show');
//         Route::delete('/{id}', [WelcomeController::class, 'destroy'])->name('member.destroy');
//     });

//     Route::group(['prefix' => 'user'], function(){
//         Route::get('/', [UserController::class, 'index']);          //menampilkan halaman awal user
//         Route::post('/list', [UserController::class, 'list']);      //menampilkan data user dalam bentuk json untuk datatables
//         Route::get('/create', [UserController::class, 'create']);   //menampilkan halaman form tambah user
//         Route::post('/', [UserController::class, 'store']);         //menyimpan data user baru
//         Route::get('/{id}', [UserController::class, 'show']);       //menampilkan detail user
//         Route::get('/{id}/edit', [UserController::class, 'edit']);  //menampilkan halaman form edit user
//         Route::put('/{id}', [UserController::class, 'update']);     //menyimpan perubahan data user
//         Route::delete('/{id}', [UserController::class, 'destroy']); //menghapus data user
//     });

//     Route::group(['prefix' => 'level'], function(){
//         Route::get('/', [LevelController::class, 'index']);
//         Route::post('/list', [LevelController::class, 'list']);
//         Route::get('/create', [LevelController::class, 'create']);
//         Route::post('/', [LevelController::class, 'store']);
//         Route::get('/{id}', [LevelController::class, 'show']);
//         Route::get('/{id}/edit', [LevelController::class, 'edit']);
//         Route::put('/{id}', [LevelController::class, 'update']);
//         Route::delete('/{id}', [LevelController::class, 'destroy']);
//     });

//     Route::group(['prefix' => 'kategori'], function(){
//         Route::get('/', [KategoriController::class, 'index']);
//         Route::post('/list', [KategoriController::class, 'list']);
//         Route::get('/create', [KategoriController::class, 'create']);
//         Route::post('/', [KategoriController::class, 'store']);
//         Route::get('/{id}', [KategoriController::class, 'show']);
//         Route::get('/{id}/edit', [KategoriController::class, 'edit']);
//         Route::put('/{id}', [KategoriController::class, 'update']);
//         Route::delete('/{id}', [KategoriController::class, 'destroy']);
//     });

//     Route::group(['prefix' => 'barang'], function(){
//         Route::get('/', [BarangController::class, 'index']);
//         Route::post('/list', [BarangController::class, 'list']);
//         Route::get('/create', [BarangController::class, 'create']);
//         Route::post('/', [BarangController::class, 'store']);
//         Route::get('/{id}', [BarangController::class, 'show']);
//         Route::get('/{id}/edit', [BarangController::class, 'edit']);
//         Route::put('/{id}', [BarangController::class, 'update']);
//         Route::delete('/{id}', [BarangController::class, 'destroy']);
//     });

//     Route::group(['prefix' => 'stok'], function(){
//         Route::get('/', [StokController::class, 'index']);
//         Route::post('/list', [StokController::class, 'list']);
//         Route::get('/create', [StokController::class, 'create']);
//         Route::post('/', [StokController::class, 'store']);
//         Route::get('/{id}', [StokController::class, 'show']);
//         Route::get('/{id}/edit', [StokController::class, 'edit']);
//         Route::put('/{id}', [StokController::class, 'update']);
//         Route::delete('/{id}', [StokController::class, 'destroy']);
//     });

//     Route::group(['prefix' => 'penjualan'], function(){
//         Route::get('/', [PenjualanController::class, 'index']);
//         Route::get('/list', [PenjualanController::class, 'list']);
//         Route::get('/create', [PenjualanController::class, 'create']);
//         Route::post('/', [PenjualanController::class, 'store']);
//         Route::get('/{id}', [PenjualanController::class, 'show']);
//         Route::get('/{id}/edit', [PenjualanController::class, 'edit']);
//         Route::put('/{id}', [PenjualanController::class, 'update']);
//         Route::delete('/{id}', [PenjualanController::class, 'destroy']);
//     });
// });


// Route::get('/level', [LevelController::class, 'index']);
// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/user', [UserController::class, 'index']);

// Route::get('/user/tambah', [UserController::class, 'tambah']);
// Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
// Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
// Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
// Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);

// Route::get('/kategori', [KategoriController::class, 'index']);
// Route::get('/kategori/create', [KategoriController::class, 'create']);
// Route::post('/kategori', [KategoriController::class, 'store']);

// Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit']);
// Route::post('/kategori/update/{id}', [KategoriController::class, 'update']);
// Route::get('/kategori/delete/{id}', [KategoriController::class, 'delete']);

