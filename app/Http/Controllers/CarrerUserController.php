<?php

namespace App\Http\Controllers;

use App\Models\Apply;
use App\Models\Carrer;
use App\Models\CarrerUser;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;

class CarrerUserController extends Controller
{
    public function detailPemagang($namaKelompok)
    {
        $kelompok = Kelompok::with('user.lowongan', 'apply')->where('name', $namaKelompok)->get();
        return view('Admin.detail-pemagang', compact('kelompok'));
    }

    public function lulus()
    {
        $user = Apply::with('kelompok.user.lowongan', 'lowongan', 'carrer')->where('status', '!=', 'menunggu')->get();
        return view('Admin.lulus', compact('user'));
    }
}
