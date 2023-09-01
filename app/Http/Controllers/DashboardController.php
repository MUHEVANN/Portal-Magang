<?php

namespace App\Http\Controllers;

use App\Models\ApplyJob;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $applyBelumKonfirmasi = ApplyJob::with('user', 'lowongan')->where('konfirmasi', 'belum')->get();
        return view('Admin.dashboard', ['applyBelumKonfirmasi' => $applyBelumKonfirmasi]);
    }
}
