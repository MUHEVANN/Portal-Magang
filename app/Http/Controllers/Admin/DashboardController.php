<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apply;
use App\Models\Carrer;
use App\Models\Kelompok;
use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DashboardController extends Controller
{
    public function index()
    {

        return view('Admin.dashboard');
    }
    public function list_pemagang_page()
    {
        $apply = Apply::select('status');
        $job = Lowongan::whereNotIn('name', ['admin', 'kosong'])->get();
        $carrer = Carrer::whereNotIn('batch', ['tidak ada'])->get();
        return view('Admin.pemagang.page', compact('carrer', 'job', 'apply'));
    }

    public function trash_page()
    {
        return view('Admin.trash.page');
    }
    public function batch_page()
    {

        return view('Admin.CarrerBatch.index');
    }
    public function lowongan_page()
    {
        $carrer = Carrer::whereNotIn('batch', ['tidak ada'])->with('lowongan')->get();

        return view('Admin.lowongan.index', compact('carrer'));
    }
}
