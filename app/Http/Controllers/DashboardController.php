<?php

namespace App\Http\Controllers;

use App\Models\ApplyJob;
use App\Models\Apply;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

        $allApply = User::with('kelompok.apply')->where('jabatan', 1)->get();
        return view('Admin.dashboard', ['allApply' => $allApply]);
    }
}
