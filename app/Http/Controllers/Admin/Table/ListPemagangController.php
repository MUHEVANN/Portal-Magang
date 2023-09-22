<?php

namespace App\Http\Controllers\Admin\Table;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ListPemagangController extends Controller
{
    public function index()
    {
        $data = User::with('apply.carrer', 'lowongan')->whereNotIn('job_magang_id', ['NULL'])->orderBy('created_at', 'asc')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {

                return view('Admin.updel-user')->with('data', $data);
            })
            ->make(true);
    }
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json(['result' => $user]);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'gender' => $request->gender,
            'job_magang_id' => $request->job_magang_id,
        ]);
        return response()->json(['success' => 'Berhasil Mengupdate']);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json(['success' => 'Berhasil Menghapus']);
    }
}
