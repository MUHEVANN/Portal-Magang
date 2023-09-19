<?php

namespace App\Http\Controllers\Admin\Table;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TrashController extends Controller
{
    public function trash()
    {
        $data = User::onlyTrashed()->with('apply.carrer', 'lowongan')->where('name', '!=', 'Admin')->orderBy('created_at', 'asc')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('Admin.restore')->with('data', $data);
            })
            ->make(true);
    }
    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        if (!$user) {
            return response()->json('id tidak ditemukan');
        }
        $user->restore();

        return response()->json(['success' => $user->name . " berhasil dikembailkan"]);
    }
}
