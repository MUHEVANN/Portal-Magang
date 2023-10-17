<?php

namespace App\Http\Controllers\Admin\Table;

use App\Http\Controllers\Controller;
use App\Models\Apply;
use App\Models\Carrer;
use App\Models\Kelompok;
use App\Models\Konfirmed;
use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ListPemagangController extends Controller
{
    public function index()
    {

        // $data = Cache::remember('all-pemagang', 3000, function () {
        //     return User::select('name', 'created_at', 'kelompok_id', 'job_magang_id', 'id')->with('apply.carrer', 'lowongan', 'kelompok')->whereHas('apply', function ($query) {
        //         return $query->select('tipe_magang', 'user_id', 'carrer_id');
        //     })->whereHas('kelompok', function ($query) {
        //         return $query->select('id', 'name');
        //     })->whereNotNull('job_magang_id')->orderBy('created_at', 'asc')->get();
        // });
        // $data = User::with('apply.carrer', 'kelompok', 'lowongan')->whereNotNull('job_magang_id')->get();
        $data = Apply::with('lowongan', 'user', 'kelompok', 'carrer')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($data) {
                return "<input type='checkbox' class='child-cb' value='$data->id'/>";
            })
            ->addColumn('action', function ($data) {
                return "<a href='#' data-id='$data->id' class='edit menu-icon tf-icons me-2'><i class='bx bx-edit-alt'></i></a><a href='#' data-id='$data->id' class='hapus' style='color:red;'><i class='bx bx-trash'></i></a>";
            })

            ->rawColumns(['checkbox', 'action'])
            ->make(true);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
        ], [
            'name.required' => 'nama wajib diisi',
            'email.required' => 'email wajib diisi',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }
        $apply = Apply::find($id);

        $apply->carrer_id = $request->carrer_id;
        if ($request->has('carrer_id') && $apply->status !== 'menunggu') {
            $konfirmed = Konfirmed::where('apply_id', $apply->id)->latest()->first();
            $konfirmed->carrer_id = $request->carrer_id;
            $konfirmed->save();
        }
        $apply->tgl_mulai = $request->tgl_mulai;
        $apply->tgl_selesai = $request->tgl_selesai;
        $apply->job_magang_id = $request->job_magang_id;
        $apply->save();


        $user = User::find($apply->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->alamat = $request->alamat;
        $user->no_hp = $request->no_hp;
        $user->gender = $request->gender;
        // $user->job_magang_id = $request->job_magang_id;
        $user->save();
        Cache::forget('all-pemagang');
        return response()->json(['success' => 'Berhasil Mengupdate']);
    }
    public function edit($id)
    {

        $apply = Apply::with('carrer')->find($id);
        $user = User::find($apply->user_id);

        $result = [
            'user' => $user,
            'apply' => $apply,

        ];
        return response()->json(['result' => $result]);
    }

    public function byBatch($batchId)
    {
        $batch = Lowongan::where('carrer_id', $batchId)->get();
        return response()->json(['data' => $batch]);
    }

    public function delete($id)
    {
        $apply = Apply::find($id);
        $kelompok_id = $apply->kelompok_id;
        $kelompok = Kelompok::where('id', $kelompok_id)->first();
        if ($apply->status !== 'menunggu') {
            $konfirmed = Konfirmed::where('apply_id', $apply->id)->first();
            $konfirmed->delete();
        }
        if ($apply->tipe_magang === "kelompok") {
            $apply->delete();
            if ($kelompok->apply->count() < 1) {
                $kelompok->delete();
            }
        } else {
            $apply->delete();
        }
        Cache::forget('all-pemagang');
        return response()->json(['success' => 'Berhasil Menghapus']);
    }
}
