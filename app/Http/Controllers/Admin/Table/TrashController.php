<?php

namespace App\Http\Controllers\Admin\Table;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class TrashController extends Controller
{
    public function trash()
    {
        $data = User::onlyTrashed()->where('name', '!=', 'Admin')->orderBy('created_at', 'asc')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('Admin.restore')->with('data', $data);
            })->addColumn('checkbox', function ($data) {
                return "<input type='checkbox' class='child-cb' value='$data->id'/>";
            })
            ->rawColumns(['checkbox'])
            ->make(true);
    }

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        if (!$user) {
            return response()->json('id tidak ditemukan');
        }
        $user->restore();
        Cache::forget('pendaftar');
        return response()->json(['success' => $user->name . " berhasil dikembailkan"]);
    }
}
