<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuth;
use App\Http\Controllers\Auth\VerifUserEmail;
use App\Http\Controllers\CarrerUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Table\ApplyController;
use App\Http\Controllers\Admin\Table\BatchController;
use App\Http\Controllers\Admin\Table\ListPemagangController;
use App\Http\Controllers\Admin\Table\LowonganController;
use App\Http\Controllers\Admin\Table\TrashController;
use App\Http\Controllers\User\ApplyJobController;


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
// Route::get('/home', [HomeController::class, 'home'])->middleware('auth');

Route::get('/apply-form', [ApplyJobController::class, 'formApply'])->middleware('auth');
Route::post('/apply-form', [ApplyJobController::class, 'store'])->middleware('auth');
Route::post('/detail-form', [ApplyJobController::class, 'detail_lowongan'])->middleware('auth');


// Admin
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/pendaftar', [DashboardController::class, 'index']);
    // Lowongan
    Route::get('lowongan-page', [DashboardController::class, 'lowongan_page']);
    Route::resource('lowongan', LowonganController::class);
    // Apply-user
    Route::get('apply', [ApplyJobController::class, 'index']);
    Route::get('apply-create', [ApplyJobController::class, 'create']);
    Route::post('apply', [ApplyJobController::class, 'store']);
    Route::get('apply-show', [ApplyJobController::class, 'show']);
    Route::get('apply-status-reject/{id}', [ApplyJobController::class, 'reject']);
    Route::get('apply-status-konfirm/{id}', [ApplyJobController::class, 'konfirm']);
    Route::get('detail-pemagang/{namaKelompok}', [CarrerUserController::class, 'detailPemagang']);
    Route::get('status-pemagang/lulus', [CarrerUserController::class, 'lulus']);
    // Mangae User Apply
    Route::get('apply-user', [ApplyController::class, 'index']);
    Route::get('apply-user-detail-kelompok/{id}', [ApplyController::class, 'detail_page']);
    Route::get('apply-user-get-detail/{id}', [ApplyController::class, 'detail_kelompok']);
    // batch carrer

    Route::get('batch-page', [DashboardController::class, 'batch_page']);
    Route::resource('carrer-batch', BatchController::class);
    // list Pemagang
    Route::get('all-pemagang', [DashboardController::class, 'list_pemagang_page']);
    Route::get('list-pemagang', [ListPemagangController::class, 'index']);
    Route::get('edit-pemagang/{id}', [ListPemagangController::class, 'edit']);
    Route::put('edit-pemagang/{id}', [ListPemagangController::class, 'update']);
    Route::delete('hapus-pemagang/{id}', [ListPemagangController::class, 'delete']);
    // Trash
    Route::get('trash-page', [DashboardController::class, 'trash_page']);
    Route::get('trash', [TrashController::class, 'trash']);
    Route::put('restore/{id}', [TrashController::class, 'restore']);
});
