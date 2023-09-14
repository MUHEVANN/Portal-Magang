<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class tes extends Controller
{
    public function update(Request $request, $id)
    {
        $lowongan = Lowongan::find($id);
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambar_name = date('ymhdis') . "." . $gambar->getClientOriginalExtension();
            $gambar_path = $gambar->storeAs('public/lowongan', $gambar_name);
            Storage::delete('public/lowongan/' . $lowongan->gambar);
            $lowongan->gambar = $gambar_name;
        }
        $lowongan->name = $request->name;
        $lowongan->desc = $request->desc;
        $lowongan->kualifikasi = $request->kualifikasi;
        $lowongan->benefit = $request->benefit;
        $lowongan->save();
    }
}
