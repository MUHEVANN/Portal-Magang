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
        $carrer = Carrer::select('batch', 'id')->whereNotIn('batch', ['tidak ada'])->get();
        $job = Lowongan::select('name', 'id')->get();
        return view('Admin.user.page', compact('carrer', 'job', 'apply'));
    }
    public function list_user_page()
    {
        $job = Lowongan::select('name', 'id')->get();
        return view('Admin.user.list_user', compact('job'));
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

    public function dashboard()
    {
        return view('Admin.Dashboard.dashboard');
    }
    public function data_dashboard()
    {
        $user = User::count();
        $apply = Apply::where('status', 'menunggu')->count();
        $pemagang = Apply::count();
        $lulus = Apply::where('status', 'lulus')->count();
        $ditolak = Apply::where('status', 'Ditolak')->count();
        $batch = Carrer::count();
        $lowongan = Lowongan::count();
        $result = [
            'total_user' => $user,
            'total_pemagang' => $pemagang,
            'total_pendaftar' => $apply,
            'total_lulus' => $lulus,
            'total_ditolak' => $ditolak,
            'total_batch' => $batch,
            'total_lowongan' => $lowongan,
        ];
        return response()->json(['result' => $result]);
    }
}
