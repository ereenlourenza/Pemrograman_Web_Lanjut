<?php

use App\Http\Controllers\BabyKidController;
use App\Http\Controllers\BeautyHealthController;
use App\Http\Controllers\FoodBeverageController;
use App\Http\Controllers\HomeCareController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});

Route::get('/home', [HomeController::class, 'index']);

Route::prefix('category')->group(function(){
    Route::get('/food-beverage', [FoodBeverageController::class, 'index']);
    Route::get('/beauty-health',[BeautyHealthController::class, 'index']);
    Route::get('/home-care',[HomeCareController::class, 'index']);
    Route::get('/baby-kid', [BabyKidController::class, 'index']);
});

Route::get('user/{id}/name/{name}', function($id,$name){
    return App\Http\Controllers\UserController::index($id,$name);
});

Route::get('/penjualan', [PenjualanController::class, 'index']);
