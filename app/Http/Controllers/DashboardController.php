<?php

namespace App\Http\Controllers;

use App\Models\ApplyJob;
use App\Models\CarrerUser;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $applyBelumKonfirmasi = CarrerUser::with('user', 'lowongan')->where('konfirmasi', 'belum')->get();
        return view('Admin.dashboard', ['applyBelumKonfirmasi' => $applyBelumKonfirmasi]);
    }
}
