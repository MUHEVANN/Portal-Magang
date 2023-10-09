<?php

namespace App\Http\Controllers;

use App\Models\Carrer;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function home(Request $request)
    {

        // $carrer = Cache::remember('carrer', 3000, function () {
        //     return Carrer::latest()->first();
        // });
        // dd(date('y-m-d'));

        $carrer = Carrer::latest()->first();
        $lowongan = Lowongan::select('name', 'created_at', 'gambar', 'carrer_id', 'deadline')->where('deadline', '>=', date('y-m-d'))->where('carrer_id', $carrer->id);
        if ($request->search) {
            $lowongan->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $lowongan = $lowongan->paginate(10);
        // dd($lowongan);
        return view('Home.index', compact('lowongan'));
    }

    public function filter(string $type = '')
    {
        $carrer = Carrer::latest()->first();

        $query = Lowongan::where('deadline', '>', date("Y-m-d"))->where('carrer_id', $carrer->id);

        if ($type == 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else if ($type == 'terbaru') {
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
