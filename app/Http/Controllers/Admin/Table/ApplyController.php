<?php

namespace App\Http\Controllers\Admin\Table;

use App\Http\Controllers\Controller;
use App\Models\Apply;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class ApplyController extends Controller
{
    public function index()
    {

        // $data = User::with('apply', 'lowongan', 'kelompok')->whereHas('apply', function ($query) {
        //     $query->where('status', 'menunggu');
        // })->get();

        $data = $data = Apply::with('lowongan', 'kelompok', 'user')->where('status', 'menunggu')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('Admin.status')->with('data', $data);
            })
            ->addColumn('checkbox', function ($data) {
                return view('Admin.checkbox')->with('data', $data);
            })
            ->make(true);
    }


    public function detail_page($id)
    {
        $kelompok = Kelompok::find($id);
        return view('Admin.detail-kelompok', compact('kelompok'));
    }
}
