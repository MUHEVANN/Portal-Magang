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

        // $allApply = Apply::with('lowongan', 'kelompok.user')
        //     ->whereHas('kelompok.user', function ($query) {
        //         $query->where('jabatan', 1);
        //     })
        //     ->get();
        $allApply = Apply::with('kelompok.user', 'lowongan')
            ->whereHas('kelompok', function ($query) {
                $query->where('name', '!=', 'tidak ada');
            })
            ->get();
        return view('Admin.dashboard', ['allApply' => $allApply]);
    }
}
