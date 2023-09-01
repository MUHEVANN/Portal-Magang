<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\EmailUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VerifUserEmail extends Controller
{
    public function verif(Request $request)
    {
        if ($request->route('verif') === Auth::user()->verif_code) {
            $cek = Auth::user();
            $user = User::where('email', $cek->email)->first();
            $user->update([
                'verif_code' => NULL,
                'is_active' => "1",
            ]);
            Session::put('user', Auth::user());
            return redirect()->to('/')->with('success', 'Akun berhasil diverifikasi');
        } else {
            return redirect()->to('register')->with('error', 'Akun gagal diverifikasi');
        }
    }

    public function kirim_verif()
    {
        $user = Auth::user();
        EmailUser::dispatch($user);
        return redirect()->back()->with(['success' => 'Kami telah mengirimkan verifikasi cek email ada']);
    }
}
