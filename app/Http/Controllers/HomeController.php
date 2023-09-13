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

        $lowongan = Lowongan::where('carrer_id', $carrer->id)->whereNotIn('name', ['kosong'])->get();
        return view('Home.index', compact('lowongan'));
    }
    public function lowonganDetail($id)
    {
        $lowongan = Lowongan::find($id);
        return view('Home.detail', compact('lowongan'));
    }
}
