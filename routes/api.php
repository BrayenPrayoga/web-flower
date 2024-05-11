<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
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

Route::middleware(['auth:api'])->group(function () {
    Route::group(['namespace'=>'users','prefix'=>'users','as'=>'users.'], function(){
        Route::get('/', [UsersController::class,'index'])->name('index');
        Route::post('store', [UsersController::class,'store'])->name('store');
        Route::post('update', [UsersController::class,'update'])->name('update');
        Route::get('delete/{id}', [UsersController::class,'delete'])->name('delete');
    });
});
