<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route; //istilah Laravel untuk menyebut class bantu

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

// Route::get('/', function () {
//     return 'Selamat Datang';
// });

// Route::get('/hello',function(){
//     return 'Hello World';
// });

// Route::get('/world', function(){
//     return 'World';
// });

// Route::get('/about', function(){
//     return '2141762044 - Ereen Lourenza Natalia Mamahi';
// });

// Route::get('/user/{name}', function($name){
//     return 'Nama saya '.$name;
// });

// Route::get('/posts/{post}/comments/{comment}', 
//             function($postId, $commentId){
//                 return 'Pos ke-'.$postId." Komentar ke-: ".$commentId;
//             });

// Route::get('/articles/{id}',function($id){
//     return 'Halaman Artikel dengan ID '.$id;
// });

// Route::get('/user/{name?}', function($name=null){
//     return 'Nama saya '.$name;
// });

// Route::get('/user/{name?}', function($name='John'){
//     return 'Nama saya '.$name;
// });

// //==var_dump==//
// Route::get('/hello', function(){
//     $hello = 'Hello World';
//     var_dump($hello);
//     die();

//     return$hello;
// }); //

// //==dd==//
// Route::get('hello', function(){
//     $hello = ['Hello World', 2 => ['Hello Jakarta','Hello Medan']];
//     dd($hello);

//     return $hello;
// }); // untuk mengecek jalannya program (array)

// //==TUGAS==//
// Route::get('/mahasiswa', function(){
//     $arrMahasiswa = ["Rio Hermawan","Risa Lestari","Rudi Hermawan","Bambang Kusumo","Lisa Permata"];
//     return view('polinema.mahasiswa',['mahasiswa' => $arrMahasiswa]);
// });
// Route::get('/dosen', function(){
//     $arrDosen = ["Satya Kencana","Sariwati","Wahyu Agung","Derry Samikan","Indah Bari"];
//     return view('polinema.dosen',['dosen' => $arrDosen]);
// });

// // ==CONTROLLER==//
// Route::get('/hello', [WelcomeController::class,'hello']);

// Route::get('/', [PageController::class,'index']);
// Route::get('/about', [PageController::class,'about']);
// Route::get('/articles/{id}', [PageController::class,'articles']);

// Route::get('/',[HomeController::class,'index']);
// Route::get('/about',[AboutController::class,'about']);
// Route::get('/articles/{id}',[ArticlesController::class,'articles']);

// Route::resource('photos', PhotoController::class);
// Route::resource('photos', PhotoController::class)->only([
//     'index','show'
// ]);
// Route::resource('photos', PhotoController::class)->except([
//     'create','store','update','destroy'
// ]);

// //==VIEW==//
// Route::get('/greeting', function(){
//     return view('blog.hello', ['name' => 'Ereen']);
// });
Route::get('/greeting', [WelcomeController::class, 'greeting']);
