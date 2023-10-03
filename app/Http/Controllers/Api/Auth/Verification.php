<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\EmailUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Verification extends Controller
{
    public function verif(Request $request)
    {
        if ($request->route('verif') === Auth::user()->verif_code) {
            $cek = Auth::user();
            $user = User::where('email', $cek->email)->first();
            $user->update([
                'is_active' => "1",
            ]);
            Session::put('user', Auth::user());
            return $this->successMessage('berhasil verifikasi', 'berhasil verif');
        } else {
            return $this->errorMessage('gagal', 'verifikasi gagal', 400);
        }
    }

    public function kirim_verif()
    {
        $user = Auth::user();
        EmailUser::dispatch($user);
        return $this->successMessage('berhasil', 'kami telah mengirimkan link verifikasi ke email anda');
    }
}
