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
        $data = User::with('kelompok.apply.carrer', 'lowongan')->where('name', '!=', 'Admin')->orderBy('created_at', 'asc')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('type-magang', function ($data) {
                $kelompok = Kelompok::with('user')->where('id', $data->kelompok_id)->first();
                if (count($kelompok->user) > 1) {
                    return 'Kelompok';
                } else {
                    return 'Mandiri';
                }
            })
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
        // $kelompok = Kelompok::with('user')->where('id', 5)->first();
        // if ($kelompok->user->count() === 1) {
        //     $kelompok->delete();
        // } else {
        // }
    }
}