<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\KategoriProdukController;
use App\Http\Controllers\API\KonfirmasiPembayaranController;
use App\Http\Controllers\API\MasterBannerController;
use App\Http\Controllers\API\MasterKuponController;
use App\Http\Controllers\API\ProdukController;
use App\Http\Controllers\API\TransaksiController;
use App\Http\Controllers\API\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login', [AuthController::class,'login'])->name('login');
Route::post('logout', [AuthController::class,'logout'])->name('logout');

Route::group(['prefix'=>'users','as'=>'users.'], function(){
    Route::post('store', [UsersController::class,'store'])->name('store');
});

Route::middleware(['auth:api'])->group(function () {

    Route::group(['prefix'=>'users','as'=>'users.'], function(){
        Route::get('/', [UsersController::class,'index'])->name('index');
        Route::post('update', [UsersController::class,'update'])->name('update');
    });

    Route::group(['prefix'=>'master-banner','as'=>'master-banner.'], function(){
        Route::get('get-banner', [MasterBannerController::class,'index'])->name('index');
    });

    Route::group(['prefix'=>'kategori','as'=>'kategori.'], function(){
        Route::get('get-kategori', [KategoriProdukController::class,'index'])->name('index');
    });
    
    Route::group(['prefix'=>'produk','as'=>'produk.'], function(){
        Route::get('get-produk', [ProdukController::class,'index'])->name('index');
    });
    
    Route::group(['prefix'=>'kupon','as'=>'kupon.'], function(){
        Route::get('cek-kupon', [MasterKuponController::class,'index'])->name('index');
    });
    
    Route::group(['prefix'=>'konfirmasi-pembarayan','as'=>'konfirmasi-pembarayan.'], function(){
        Route::get('get-konfirmasi-pembarayan', [KonfirmasiPembayaranController::class,'index'])->name('index');
        Route::post('store', [KonfirmasiPembayaranController::class,'store'])->name('store');
    });
    
    Route::group(['prefix'=>'transaksi','as'=>'transaksi.'], function(){
        Route::post('store', [TransaksiController::class,'store'])->name('store');
    });

});