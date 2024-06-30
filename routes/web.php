<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterBannerController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\KonfirmasiPembayaranController;
use App\Http\Controllers\MasterBankController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\MasterKuponController;
use App\Http\Controllers\ProdukTerjualController;
use App\Http\Controllers\TransaksiController;

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
Route::get('reset-password/{id}', [AuthController::class,'resetPassword'])->name('reset-password');
Route::post('update-password', [AuthController::class,'updatePassword'])->name('update-password');

Route::middleware(['auth:admin'])->group(function () {
    Route::group(['prefix'=>'dashboard','as'=>'dashboard.'], function(){
        Route::get('/', [DashboardController::class,'index'])->name('index');
        Route::get('chart-column', [DashboardController::class,'chartColumn'])->name('chartColumn');
        Route::get('chart-pie', [DashboardController::class,'chartPie'])->name('chartPie');
    });

    // Profil
    Route::group(['prefix'=>'profil','as'=>'profil.'], function(){
        Route::get('/', [ProfilController::class,'index'])->name('index');
        Route::post('update', [ProfilController::class,'update'])->name('update');
    });

    // Master User
    Route::group(['prefix'=>'users','as'=>'users.'], function(){
        Route::get('/', [UsersController::class,'index'])->name('index');
        Route::post('store', [UsersController::class,'store'])->name('store');
        Route::post('update', [UsersController::class,'update'])->name('update');
        Route::get('delete/{id}', [UsersController::class,'delete'])->name('delete');
    });

    // Master Bank
    Route::group(['prefix'=>'master-bank','as'=>'master-bank.'], function(){
        Route::get('/', [MasterBankController::class,'index'])->name('index');
        Route::post('store', [MasterBankController::class,'store'])->name('store');
        Route::post('update', [MasterBankController::class,'update'])->name('update');
        Route::get('delete/{id}', [MasterBankController::class,'delete'])->name('delete');
    });
    
    // Master Banner
    Route::group(['prefix'=>'master-banner','as'=>'master-banner.'], function(){
        Route::get('/', [MasterBannerController::class,'index'])->name('index');
        Route::post('store', [MasterBannerController::class,'store'])->name('store');
        Route::post('update', [MasterBannerController::class,'update'])->name('update');
        Route::get('delete/{id}', [MasterBannerController::class,'delete'])->name('delete');
    });
    
    // Master Kupon
    Route::group(['prefix'=>'master-kupon','as'=>'master-kupon.'], function(){
        Route::get('/', [MasterKuponController::class,'index'])->name('index');
        Route::post('store', [MasterKuponController::class,'store'])->name('store');
        Route::post('update', [MasterKuponController::class,'update'])->name('update');
        Route::get('delete/{id}', [MasterKuponController::class,'delete'])->name('delete');
    });
    
    // Kategori Produk
    Route::group(['prefix'=>'kategori','as'=>'kategori.'], function(){
        Route::get('/', [KategoriProdukController::class,'index'])->name('index');
        Route::post('store', [KategoriProdukController::class,'store'])->name('store');
        Route::post('update', [KategoriProdukController::class,'update'])->name('update');
        Route::get('delete/{id}', [KategoriProdukController::class,'delete'])->name('delete');
    });
    
    // Produk
    Route::group(['prefix'=>'produk','as'=>'produk.'], function(){
        Route::get('/', [ProdukController::class,'index'])->name('index');
        Route::post('store', [ProdukController::class,'store'])->name('store');
        Route::post('update', [ProdukController::class,'update'])->name('update');
        Route::get('delete/{id}', [ProdukController::class,'delete'])->name('delete');
    });
    
    // Checkout
    Route::group(['prefix'=>'checkout','as'=>'checkout.'], function(){
        Route::get('/', [CheckoutController::class,'index'])->name('index');
    });
    
    // Transaksi
    Route::group(['prefix'=>'transaksi','as'=>'transaksi.'], function(){
        Route::get('/', [TransaksiController::class,'index'])->name('index');
        Route::post('store', [TransaksiController::class,'store'])->name('store');
        Route::post('update', [TransaksiController::class,'update'])->name('update');
        Route::get('delete/{id}', [TransaksiController::class,'delete'])->name('delete');
        Route::get('detail-produk', [TransaksiController::class,'detailProduk'])->name('detailProduk');
    });
    
    // Konfirmasi Pembayaran
    Route::group(['prefix'=>'konfirmasi-pembarayan','as'=>'konfirmasi-pembarayan.'], function(){
        Route::get('/', [KonfirmasiPembayaranController::class,'index'])->name('index');
        Route::post('store', [KonfirmasiPembayaranController::class,'store'])->name('store');
    });
    
    // Produk Terjual
    Route::group(['prefix'=>'produk-terjual','as'=>'produk-terjual.'], function(){
        Route::get('/', [ProdukTerjualController::class,'index'])->name('index');
        Route::post('store', [ProdukTerjualController::class,'store'])->name('store');
    });
});
