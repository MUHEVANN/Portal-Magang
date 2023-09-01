<?php

use App\Http\Controllers\Auth\UserAuth;
use App\Http\Controllers\Auth\VerifUserEmail;
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
    return view('welcome');
})->middleware('auth');

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
// Home
Route::get('/home', function () {
    return view('welcome');
})->middleware('auth');
// changePassword
Route::get('verif-email-changePassword', [UserAuth::class, 'verif_email_changePassword']);
Route::post('verif-email-changePassword', [UserAuth::class, 'code_changePassword']);

Route::get('changePassword', [UserAuth::class, 'changePassword']);
Route::post('changePassword', [UserAuth::class, 'proccess_changePassword']);

// Pages
//  Client
// Home
Route::get('/home', function () {
    return view('Auth.login');
})->middleware('auth');


// Admin
Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('Admin.Dashboard');
    });
    // Lowongan
    Route::resource('lowongan', LowonganController::class);
    // Apply
    Route::get('apply', [ApplyJobController::class, 'index']);
    Route::get('apply-create', [ApplyJobController::class, 'create']);
    Route::post('apply', [ApplyJobController::class, 'store']);
    Route::get('apply-show', [ApplyJobController::class, 'show']);
    Route::post('apply-status-reject', [ApplyJobController::class, 'reject']);
    Route::post('apply-status-konfirm', [ApplyJobController::class, 'konfirm']);
});
