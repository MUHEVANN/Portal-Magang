<?php

namespace App\Http\Controllers\Lowongan;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LowonganController extends Controller
{
    public function index()
    {
        $lowongan = Lowongan::get();
        return view('Admin.Lowongan.index', ['lowongan' => $lowongan]);
    }

    public function create()
    {
        return view('Admin.Lowongan.create');
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'desc' => 'required',
            'benefit' => 'required',
            'kualifikasi' => 'required',
            'gambar' => 'required|mimes:JPEG,JPG,PNG',
            'max_applay' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }
        $gambar = $request->file('gambar');
        $gambar_name = date('ymdhis') . "." . $gambar->getClientOriginalExtension();
        $gambar_path = $gambar->storeAs('public/lowongan', $gambar_name);
        $lowongan = Lowongan::create([
            'name' => $request->name,
            'desc' => $request->desc,
            'benefit' => $request->benefit,
            'kualifikasi' => $request->kualifikasi,
            'gambar' => $gambar_name,
            'max_applay' => $request->max_applay,
        ]);

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

    public function edit($id)
    {
        $lowongan = Lowongan::find($id);
        return view('Admin.Lowongan.edit', ['lowongan' => $lowongan]);
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
            'max_applay' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }
        $lowongan = Lowongan::find($id);
        $lowongan->name = $request->name;
        $lowongan->desc = $request->desc;
        $lowongan->benefit = $request->benefit;
        $lowongan->kualifikasi = $request->kualifikasi;
        $lowongan->max_applay = $request->max_applay;
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
