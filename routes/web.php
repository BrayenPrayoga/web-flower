<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterBannerController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\ProdukController;

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
    return view('login');
});

Route::post('login', [AuthController::class,'login'])->name('login');
Route::get('logout', [AuthController::class,'logout'])->name('logout');

Route::middleware(['auth:admin'])->group(function () {
    Route::group(['namespace'=>'dashboard','prefix'=>'dashboard','as'=>'dashboard.'], function(){
        Route::get('/', [DashboardController::class,'index'])->name('index');
    });

    // Master User
    Route::group(['namespace'=>'users','prefix'=>'users','as'=>'users.'], function(){
        Route::get('/', [UsersController::class,'index'])->name('index');
        Route::post('store', [UsersController::class,'store'])->name('store');
        Route::post('update', [UsersController::class,'update'])->name('update');
        Route::get('delete/{id}', [UsersController::class,'delete'])->name('delete');
    });
    
    // Master Banner
    Route::group(['namespace'=>'master-banner','prefix'=>'master-banner','as'=>'master-banner.'], function(){
        Route::get('/', [MasterBannerController::class,'index'])->name('index');
        Route::post('store', [MasterBannerController::class,'store'])->name('store');
        Route::post('update', [MasterBannerController::class,'update'])->name('update');
        Route::get('delete/{id}', [MasterBannerController::class,'delete'])->name('delete');
    });
    
    // Kategori Produk
    Route::group(['namespace'=>'kategori','prefix'=>'kategori','as'=>'kategori.'], function(){
        Route::get('/', [KategoriProdukController::class,'index'])->name('index');
        Route::post('store', [KategoriProdukController::class,'store'])->name('store');
        Route::post('update', [KategoriProdukController::class,'update'])->name('update');
        Route::get('delete/{id}', [KategoriProdukController::class,'delete'])->name('delete');
    });
    
    // Produk
    Route::group(['namespace'=>'produk','prefix'=>'produk','as'=>'produk.'], function(){
        Route::get('/', [ProdukController::class,'index'])->name('index');
        Route::post('store', [ProdukController::class,'store'])->name('store');
        Route::post('update', [ProdukController::class,'update'])->name('update');
        Route::get('delete/{id}', [ProdukController::class,'delete'])->name('delete');
    });
});
