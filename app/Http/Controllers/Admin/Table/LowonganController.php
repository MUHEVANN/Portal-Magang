<?php

namespace App\Http\Controllers\Admin\Table;

use App\Http\Controllers\Controller;
use App\Models\Carrer;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LowonganController extends Controller
{
    public function index(Request $request)
    {
        $batch_id = $request->batch_id;
        $query = Lowongan::where('name', '!=', 'kosong');
        if ($batch_id) {
            $query->where('carrer_id', $batch_id);
        }

        $data = $query->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('Admin.updel-user')->with('data', $data);
            })
            ->addColumn('description', function ($data) {
                return $data->desc;
            })
            ->addColumn('kualifikasi', function ($data) {
                return $data->kualifikasi;
            })
            ->addColumn('benefit', function ($data) {
                return $data->benefit;
            })
            ->rawColumns(['description', 'kualifikasi', 'benefit'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|unique:job_magang',
            'gambar' => 'required|mimes:jpg,png,jpeg,svg',
            'desc' => 'required',
            'kualifikasi' => 'required',
            'benefit' => 'required',
            'deadline' => 'required'
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'desc.required' => 'Descripsi tidak boleh kosong',
            'kualifikasi.required' => 'Kualifikasi tidak boleh kosong',
            'benefit.required' => 'Benefit tidak boleh kosong',
            'deadline.required' => 'deadline tidak boleh kosong',
            'gambar.required' => 'Gambar tidak boleh kosong',
            'gambar.mimes' => 'Gambar harus bertipe jpg/png/jpeg/svg',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->messages()],);
        }
        $gambar = $request->file('gambar');
        $gambar_name = date('ymdhis') . "." . $gambar->getClientOriginalExtension();
        $gambar_path = $gambar->storeAs('public/lowongan', $gambar_name);
        $carrer = Carrer::latest()->first();


        $lowongan = Lowongan::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'benefit' => $request->benefit,
            'kualifikasi' => $request->kualifikasi,
            'deadline' => $request->deadline,
            'gambar' => $gambar_name,
            'carrer_id' => $carrer->id
        ]);
        Cache::forget('batch');
        if ($lowongan) {
            return response()->json(['success' => 'Berhasil menambah lowongan']);
        } else {
            return response()->json(['gagal' => 'Gagal menambahkan Lowongan']);
        }
    }

    public function show($id)
    {
        $lowongan = Lowongan::find($id);
        return view('Admin.Lowongan.show', compact('lowongan'));
    }
    public function edit($id)
    {
        $lowongan = Lowongan::find($id);
        return response()->json($lowongan);
    }


    public function destroy(Request $request, $id)
    {
        $lowongan = Lowongan::find($id);
        $lowongan->delete();
        Cache::forget('batch');
    }
}
