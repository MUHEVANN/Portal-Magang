<?php

namespace App\Http\Controllers;

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
}
