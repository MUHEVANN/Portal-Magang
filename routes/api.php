<?php

use App\Http\Controllers\Admin\Table\LowonganController;
use App\Http\Controllers\Api\Admin\CarrerBatch;
use App\Http\Controllers\Api\Admin\DaftarPendaftar;
use App\Http\Controllers\Api\Admin\DaftarPendaftarMenunggu;
use App\Http\Controllers\Api\Admin\DaftarPengguna;
use App\Http\Controllers\Api\Admin\Trashed;
use App\Http\Controllers\Api\Auth\UserAuthApi;
use App\Http\Controllers\Api\User\ApplyControllerApi;
use App\Http\Controllers\Api\User\JobMagangApi;
use App\Http\Controllers\Api\User\ProfileControllerApi;
use App\Http\Controllers\Auth\UserAuth;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [UserAuthApi::class, 'logout']);
    // Auth verif
    Route::get('/email/verifikasi', [VerifUserEmail::class, 'kirim_verif']);
    // verif user
    Route::get('/email/verifikasi/{verif}', [VerifUserEmail::class, 'verif'])->name('verif');
    // profile
    Route::get('/profile', [ProfileControllerApi::class, 'profile']);
    Route::put('/profile', [ProfileControllerApi::class, 'update']);
    Route::post('/apply', [ApplyControllerApi::class, 'apply'])->middleware('checkDate');
    // search apply
    Route::get('/pendaftar/search', [DaftarPendaftar::class, 'search']);
    // change password
    Route::post('/change-password', [UserAuth::class, 'ganti_password']);
    Route::middleware('role:admin')->group(function () {
        // pengguna
        Route::get('/daftar-pengguna', [DaftarPengguna::class, 'index']);
        Route::get('/daftar-pengguna/{id}', [DaftarPengguna::class, 'show']);
        Route::put('/daftar-pengguna/{id}', [DaftarPengguna::class, 'update']);
        Route::delete('/daftar-pengguna/{id}', [DaftarPengguna::class, 'delete']);
        // lowongan
        Route::post('/lowongan', [JobMagangApi::class, 'store']);
        Route::put('/lowongan/{id}', [JobMagangApi::class, 'update']);
        Route::delete('/lowongan/{id}', [JobMagangApi::class, 'delete']);
        Route::get('/lowongan', [JobMagangApi::class, 'index']);
        // pendaftar
        Route::get('/pendaftar', [DaftarPendaftar::class, 'index']);
        Route::put('/pendaftar/{id}', [DaftarPendaftar::class, 'update']);
        Route::get('/pendaftar-dikonfirmasi', [DaftarPendaftar::class, 'pendaftar_konfirmasi']);
        Route::get('/pendaftar-reject/{id}', [DaftarPendaftarMenunggu::class, 'reject']);
        Route::get('/pendaftar-konfirm/{id}', [DaftarPendaftarMenunggu::class, 'konfirm']);
        Route::get('/pendaftar-baru', [DaftarPendaftarMenunggu::class, 'index']);
        Route::delete('/pendaftar-baru/{id}', [DaftarPendaftarMenunggu::class, 'destroy']);
        // trash
        Route::get('/pengguna/only-trash', [Trashed::class, 'index']);
        Route::get('/pengguna/restore/{id}', [Trashed::class, 'restore']);
        // batch
        Route::resource('/batch', CarrerBatch::class);
    });
});

Route::get('/lowongan/filter', [JobMagangApi::class, 'filter']);
Route::get('/lowongan/user', [JobMagangApi::class, 'getJobUser']);
Route::get('/lowongan/{id}', [JobMagangApi::class, 'show']);

Route::post('/register', [UserAuthApi::class, 'register']);
Route::post('/login', [UserAuthApi::class, 'login']);
// Route::middleware('auth:sanctum')->group(function () {
// });
Route::get('/get-apply', [tes::class, 'getApply']);
Route::get('/get-year', [tes::class, 'get_year']);
