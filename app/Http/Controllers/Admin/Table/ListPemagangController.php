<?php

namespace App\Http\Controllers\Admin\Table;

use App\Http\Controllers\Controller;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class ListPemagangController extends Controller
{
    public function index()
    {

        $data = Cache::remember('all-pemagang', 3000, function () {
            return User::select('name', 'created_at', 'kelompok_id', 'job_magang_id', 'id')->with('apply.carrer', 'lowongan', 'kelompok')->whereHas('apply', function ($query) {
                return $query->select('tipe_magang', 'user_id', 'carrer_id');
            })->whereHas('kelompok', function ($query) {
                return $query->select('id', 'name');
            })->whereNotNull('job_magang_id')->orderBy('created_at', 'asc')->get();
        });
        // view('Admin.checkbox')->with('data', $data);
        // view('Admin.updel-user')->with('data', $data);
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($data) {
                return "<input type='checkbox' class='child-cb' value='$data->id'/>";
            })
            ->addColumn('action', function ($data) {
                return "<a href='#' data-id=' $data->id ' class='edit menu-icon tf-icons me-2'><i class='bx bx-edit-alt'></i></a><a href='#' data-id='$data->id' class='hapus' style='color:red;'><i class='bx bx-trash'></i></a>";
            })
            ->rawColumns(['checkbox', 'action'])
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->alamat = $request->alamat;
        $user->no_hp = $request->no_hp;
        $user->gender = $request->gender;
        $user->job_magang_id = $request->job_magang_id;
        $user->save();

        Cache::put(
            'all-pemagang',
            User::select('name', 'created_at', 'kelompok_id', 'job_magang_id', 'id')->with('apply.carrer', 'lowongan', 'kelompok')->whereHas('apply', function ($query) {
                return $query->select('tipe_magang', 'user_id', 'carrer_id');
            })->whereHas('kelompok', function ($query) {
                return $query->select('id', 'name');
            })->whereNotNull('job_magang_id')->orderBy('created_at', 'asc')->get(),
            300
        );
        return response()->json(['success' => 'Berhasil Mengupdate']);
    }
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json(['result' => $user]);
    }
    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
        Cache::put(
            'all-pemagang',
            User::select('name', 'created_at', 'kelompok_id', 'job_magang_id', 'id')->with('apply.carrer', 'lowongan', 'kelompok')->whereHas('apply', function ($query) {
                return $query->select('tipe_magang', 'user_id', 'carrer_id');
            })->whereHas('kelompok', function ($query) {
                return $query->select('id', 'name');
            })->whereNotNull('job_magang_id')->orderBy('created_at', 'asc')->get(),
            300
        );
        return response()->json(['success' => 'Berhasil Menghapus']);
    }
}