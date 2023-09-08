<?php

namespace App\Http\Controllers;

use App\Models\Carrer;
use App\Models\Lowongan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $carrer = Carrer::latest()->first();

        $lowongan = Lowongan::where('carrer_id', $carrer->id)->get();
        return view('Home.index', compact('lowongan'));
    }
    public function lowonganDetail($id)
    {
        $lowongan = Lowongan::find($id);
        return view('Home.index', compact('lowongan'));
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'require',
            'desc' => 'require',
            'gambar' => 'require',
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
    }

    public function show($id)
    {
        $lowongan = Lowongan::find($id);
        return view('Home.index.show');
    }
}