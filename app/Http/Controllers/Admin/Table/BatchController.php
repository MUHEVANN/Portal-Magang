<?php

namespace App\Http\Controllers\Admin\Table;

use App\Http\Controllers\Controller;
use App\Models\Carrer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BatchController extends Controller
{
    public function index()
    {
        $data = Cache::remember('batch', 3000, function () {
            return Carrer::select('id', 'batch')->where('batch', '!=', 'tidak ada')->with('lowongan.user')->withCount('lowongan')->get();
        });
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('Admin.updel-user')->with('data', $data);
            })
            ->addColumn('total_user', function ($data) {

                $totalUsers = 0;
                foreach ($data->lowongan as $lowongan) {
                    $totalUsers += $lowongan->user->count();
                }

                return $totalUsers;
            })
            ->make(true);
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'batch' => 'required'
        ], [
            'batch.required' => 'Batch tidak boleh kosong!'
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->messages()]);
        }

        $batch = Carrer::create([
            'batch' => $request->batch
        ]);
        return response()->json(['success' => 'Berhasil menambahkan batch'], 200);
    }
    public function edit($id)
    {
        $data = Carrer::find($id);
        return response()->json($data);
    }
    public function update($id, Request $request)
    {
        $validate = Validator::make($request->all(), [
            'batch' => 'required'
        ], [
            'batch.required' => 'Batch tidak boleh kosong!'
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->messages()], 400);
        }

        $batch = Carrer::find($id);
        $batch->update(['batch' => $request->batch]);
        return response()->json(['success' => 'Berhasil menambahkan batch'], 200);
    }

    public function destroy($id)
    {
        $carrer = Carrer::find($id);
        $carrer->delete();
    }
}
