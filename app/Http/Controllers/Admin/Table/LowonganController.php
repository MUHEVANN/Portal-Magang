<?php

namespace App\Http\Controllers\Admin\Table;

use App\Http\Controllers\Controller;
use App\Models\Carrer;
use App\Models\Lowongan;
use Illuminate\Http\Request;
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
            'name' => 'required',
            'desc' => 'required',
            'benefit' => 'required',
            'kualifikasi' => 'required',
            'gambar' => 'required|mimes:jpg,jpeg,png',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->messages()]);
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
            'gambar' => $gambar_name,
            'carrer_id' => $carrer->id
        ]);
        if ($lowongan) {
            return response()->json(['success' => 'Berhasil menambah lowongan']);
        } else {
            return response()->json(['gagal' => 'Gagal menambahkan Lowongan']);
        }
    }

    public function show($id)
    {
        $lowongan = Lowongan::find($id);
        return view('Admin.Lowongan.show');
    }
    public function edit($id)
    {
        $lowongan = Lowongan::find($id);
        return response()->json($lowongan);
    }

    // public function update(Request $request, $id)
    // {
    //     $lowongan = Lowongan::find($id);
    //     if ($request->hasFile('gambar')) {
    //         $gambar = $request->file('gambar');
    //         $gambar_name = date('ymhdis') . "." . $gambar->getClientOriginalExtension();
    //         $gambar_path = $gambar->storeAs('public/lowongan', $gambar_name);
    //         Storage::delete('public/lowongan/' . $lowongan->gambar);
    //         $lowongan->gambar = $gambar_name;
    //     }
    //     $lowongan->name = $request->name;
    //     $lowongan->desc = $request->desc;
    //     $lowongan->kualifikasi = $request->kualifikasi;
    //     $lowongan->benefit = $request->benefit;
    //     $lowongan->save();
    // }

    public function destroy($id)
    {
        $lowongan = Lowongan::find($id);
        $lowongan->delete();
    }
}
