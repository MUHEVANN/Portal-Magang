<?php

namespace App\Http\Controllers;

use App\Models\Carrer;
use Illuminate\Http\Request;

class CarrerBatchController extends Controller
{
    public function index()
    {
        $carrer = Carrer::with('lowongan')->get();
        dd($carrer);
        return view('Admin.CarrerBatch.index');
    }
}
