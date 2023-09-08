<?php

namespace App\Http\Controllers\Lowongan;

use App\Http\Controllers\Controller;
use App\Models\Carrer;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LowonganController extends Controller
{
    public function index()
    {
        $lowongan = Lowongan::where('name', '!=', 'kosong')->get();
        return view('Admin.Lowongan.index', ['lowongan' => $lowongan]);
    }
    public function store(Request $request)
    {
        // dd($request->file('gambar'));
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'desc' => 'required',
            'benefit' => 'required',
            'kualifikasi' => 'required',
            'gambar' => 'required|mimes:jpg,jpeg,png',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput();
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
        // if($lowongan){

        //     return response()->json(['success' => 'lowongan berhasil dibuat']);
        // }else{
        //     return response()->json(['gagal' => 'gagal menambahkan data'])
        // }

        if ($lowongan) {
            return redirect()->to('lowongan')->with(['success' => 'Berhasil menambah lowongan']);
        } else {
            return redirect()->back()->withErrors(['gagal' => 'Gagal menambahkan Lowongan']);
        }
    }

    public function show($id)
    {
        $lowongan = Lowongan::find($id);
        return view('Admin.Lowongan.show');
    }

    public function update(Request $request, $id)
    {
        // dd($request->hasFile('gambar'));
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'desc' => 'required',
            'benefit' => 'required',
            'kualifikasi' => 'required',
            'gambar' => 'mimes:jpeg,jpg,png',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }
        $lowongan = Lowongan::find($id);
        $lowongan->name = $request->name;
        $lowongan->desc = $request->desc;
        $lowongan->benefit = $request->benefit;
        $lowongan->kualifikasi = $request->kualifikasi;
        $carrer = Carrer::latest()->first();
        $lowongan->carrer_id = $carrer->id;
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambar_name = date('ymhdis') . "." . $gambar->getClientOriginalExtension();
            $gambar_path = $gambar->storeAs('public/lowongan', $gambar_name);
            Storage::delete('public/lowongan/' . $lowongan->gambar);
            $lowongan->gambar = $gambar_name;
        }
        $lowongan->save();
        return redirect()->to('lowongan')->with(['success' => 'Berhasil diupdate']);
    }

    public function destroy($id)
    {
        $lowongan = Lowongan::find($id);
        $lowongan->delete();
        return redirect()->back()->with(['success' => 'Berhasil diupdate']);
    }
}
