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
        $data = User::with('kelompok.apply')->where('jabatan', 1)->whereHas('kelompok', function ($query) {
            $query->where('id', '!=', 1);
        })->whereHas('kelompok.apply', function ($query) {
            $query->where('status', 'menunggu');
        })->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('Admin.kelompok-id')->with('data', $data);
            })
            ->make(true);
    }

    public function detail_kelompok($id)
    {
        $data = User::with('kelompok.apply')->where('kelompok_id', $id)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('Admin.status')->with('data', $data);
            })
            ->make(true);
    }
    public function detail_page($id)
    {
        $kelompok = Kelompok::find($id);
        return view('Admin.detail-kelompok', compact('kelompok'));
    }
}
