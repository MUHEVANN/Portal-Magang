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

    public function filter(string $type)
    {
        $carrer = Carrer::latest()->first();

        $query = Lowongan::where('carrer_id', $carrer->id)->whereNotIn('name', ['kosong']);
        // if ($request->has('terbaru')) {
        // }
        // if ($request->has('terlama')) {
        // }

        if ($type == 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $lowongan = $query->get();
        return response()->json($lowongan);
    }

    public function lowonganDetail($id)
    {
        $lowongan = Lowongan::find($id);
        return view('Home.detail', compact('lowongan'));
    }
}
