<?php

namespace App\Http\Controllers\Admin\Table;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class ApplyController extends Controller
{
    public function index()
    {
        $data = User::with(['apply', 'lowongan', 'kelompok'])->whereHas('apply', function ($query) {
            $query->where('status', 'menunggu');
        })->get();

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

    public function detail_kelompok($id)
    {
        $data = User::with('apply')->where('kelompok_id', $id)->whereHas('apply', function ($query) {
            $query->where('status', 'menunggu');
        })->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($data) {
                return view('Admin.checkbox')->with('data', $data);
            })
            ->addColumn('action', function ($data) {
                return view('Admin.status')->with('data', $data);
            })
            ->addColumn('cv_user', function ($data) {
                return  view('Admin.cv')->with('data', $data);
            })
            ->rawColumns(['checkbox'])
            ->make(true);
    }
    public function detail_page($id)
    {
        $kelompok = Kelompok::find($id);
        return view('Admin.detail-kelompok', compact('kelompok'));
    }
}
