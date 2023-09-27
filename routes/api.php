<?php

use App\Http\Controllers\Admin\Table\LowonganController;
use App\Http\Controllers\Api\Admin\CarrerBatch;
use App\Http\Controllers\Api\Admin\DaftarPendaftar;
use App\Http\Controllers\Api\Admin\DaftarPengguna;
use App\Http\Controllers\Api\Admin\Trashed;
use App\Http\Controllers\Api\Auth\UserAuthApi;
use App\Http\Controllers\Api\User\ApplyControllerApi;
use App\Http\Controllers\Api\User\JobMagangApi;
use App\Http\Controllers\Api\User\ProfileControllerApi;
use App\Http\Controllers\tes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('lowongan/{id}', [tes::class, 'update']);
Route::get('/update-profile', [ProfileController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [UserAuthApi::class, 'logout']);
    // Auth verif
    Route::get('/email/verifikasi', [VerifUserEmail::class, 'kirim_verif']);
    // verif user
    Route::get('/email/verifikasi/{verif}', [VerifUserEmail::class, 'verif'])->name('verif');
    // profile
    Route::get('/profile', [ProfileControllerApi::class, 'profile']);
    Route::post('/profile', [ProfileControllerApi::class, 'update']);
    Route::post('/apply', [ApplyControllerApi::class, 'apply']);

    Route::middleware('role:admin')->group(function () {
        // pengguna
        Route::get('/daftar-pengguna', [DaftarPengguna::class, 'index']);
        Route::get('/daftar-pengguna/{id}', [DaftarPengguna::class, 'show']);
        Route::put('/daftar-pengguna/{id}', [DaftarPengguna::class, 'update']);
        Route::delete('/daftar-pengguna/{id}', [DaftarPengguna::class, 'delete']);
        // lowongan
        Route::post('/lowongan/{id}', [JobMagangApi::class, 'update']);
        Route::delete('/lowongan/{id}', [JobMagangApi::class, 'delete']);
        // pendaftar
        Route::get('/pendaftar', [DaftarPendaftar::class, 'index']);
        Route::get('/pendaftar-reject/{id}', [DaftarPendaftar::class, 'reject']);
        Route::get('/pendaftar-konfirm/{id}', [DaftarPendaftar::class, 'konfirm']);
        Route::get('/pendaftar-dikonfirmasi', [DaftarPendaftar::class, 'pendaftar_konfirmasi']);
        // trash
        Route::get('/pengguna/only-trash', [Trashed::class, 'index']);
        Route::get('/pengguna/restore/{id}', [Trashed::class, 'restore']);
        // batch
        Route::resource('/batch', CarrerBatch::class);
    });
});

Route::get('/lowongan', [JobMagangApi::class, 'index']);
Route::get('/lowongan/filter', [JobMagangApi::class, 'filter']);
Route::get('/lowongan/{id}', [JobMagangApi::class, 'show']);

Route::post('/register', [UserAuthApi::class, 'register']);
Route::post('/login', [UserAuthApi::class, 'login']);
