<?php

namespace App\Http\Controllers;

use App\Models\Carrer;
use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarrerBatchController extends Controller
{
    public function index()
    {

        $carrer = Carrer::where('batch', '!=', 'tidak ada')->with('lowongan.user')->withCount('lowongan')->get();
        // dd($carrer);
        return view('Admin.CarrerBatch.index', compact('carrer'));
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'batch' => 'required'
        ], [
            'batch.required' => 'batch wajib diisi'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages());
        }

        $batch = Carrer::create([
            'batch' => $request->batch
        ]);

        if ($batch) {
            return redirect()->back()->with(['success' => 'sukses menambahkan batch']);
        } else {
            return redirect()->back()->with(['gagal' => 'gagal menambahkan batch']);
        }
    }
}
