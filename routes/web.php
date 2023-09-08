<?php

use App\Http\Controllers\ApplyJobController;
use App\Http\Controllers\Auth\UserAuth;
use App\Http\Controllers\Auth\VerifUserEmail;
use App\Http\Controllers\CarrerBatchController;
use App\Http\Controllers\CarrerUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Lowongan\LowonganController;
use App\Http\Controllers\TesCVController;
use App\Models\CarrerUser;
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



// Auth User
// Register User
Route::get('register', [UserAuth::class, 'register']);
Route::post('register', [UserAuth::class, 'proccess_register']);

Route::middleware('auth')->group(function () {
    // verif user
    Route::get('/email/verifikasi/{verif}', [VerifUserEmail::class, 'verif'])->name('verif');
    // logout
    Route::get('logout', [UserAuth::class, 'logout']);
});
// login
Route::get('login', [UserAuth::class, 'login'])->name('login');
Route::post('login', [UserAuth::class, 'proccess_login']);

// changePassword
Route::get('verif-email-changePassword', [UserAuth::class, 'verif_email_changePassword']);
Route::post('verif-email-changePassword', [UserAuth::class, 'code_changePassword']);

Route::get('changePassword', [UserAuth::class, 'changePassword']);
Route::post('changePassword', [UserAuth::class, 'proccess_changePassword']);

// Pages
//  Client
// Home
Route::get('/home', function () {
    return view('welcome');
})->middleware('auth');
Route::get('/apply-form', [ApplyJobController::class, 'formApply'])->middleware('auth');
Route::post('/apply-form', [ApplyJobController::class, 'store'])->middleware('auth');


// Admin
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    // Lowongan
    Route::resource('lowongan', LowonganController::class);
    // Apply
    Route::get('apply', [ApplyJobController::class, 'index']);
    Route::get('apply-create', [ApplyJobController::class, 'create']);
    Route::post('apply', [ApplyJobController::class, 'store']);
    Route::get('apply-show', [ApplyJobController::class, 'show']);
    Route::get('apply-status-reject/{id}', [ApplyJobController::class, 'reject']);
    Route::get('apply-status-konfirm/{id}', [ApplyJobController::class, 'konfirm']);

    Route::get('detail-pemagang/{namaKelompok}', [CarrerUserController::class, 'detailPemagang']);
    Route::get('status-pemagang/lulus', [CarrerUserController::class, 'lulus']);

    // batch carrer
    Route::resource('carrer-batch', CarrerBatchController::class);
});
