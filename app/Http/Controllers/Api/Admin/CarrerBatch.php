<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarrerResource;
use App\Models\Carrer;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class CarrerBatch extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Cache::remember('batch', 3000, function () {
            return Carrer::where('batch', '!=', 'tidak ada')->withCount(['apply as apply_lulus' => function ($query) {
                $query->where('status', 'lulus');
            }])->withCount('lowongan')->get();
        });
        return $this->successMessage($data, 'Success get carrer');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'batch' => "required|unique:carrers"
            ], [
                'batch.required' => 'batch tidak boleh kosong',
                'batch.unique' => 'batch sudah ada',

            ]);

            if ($validate->fails()) {
                return $this->errorMessage('Gagal', $validate->messages(), 400);
            }

            $carrer = Carrer::create([
                'batch' => $request->batch
            ]);
            $carrerResource = new CarrerResource($carrer);
            Cache::forget('carrer');
            Cache::put('carrer_' . $carrer->id, $carrer);
            return $this->successMessage($carrerResource, 'berhasil menambah batch');
        } catch (QueryException $e) {
            return $this->errorMessage('ada masalah dengan server', $e, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $carrer = Carrer::find($id);
        if (!$carrer) {
            return $this->errorMessage('error', 'ID tidak ditemukan');
        }
        Cache::put('carrer_' . $carrer->id, $carrer);
        return $this->successMessage($carrer, 'berhasil show carrer');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'batch' => "required|unique:carrers"
            ], [
                'batch.required' => 'batch tidak boleh kosong',
                'batch.unique' => 'batch sudah ada',

            ]);

            if ($validate->fails()) {
                return $this->errorMessage('Gagal', $validate->messages(), 400);
            }


            $data = [
                'batch' => $request->batch
            ];
            $carrer = Carrer::find($id);
            $carrer->update($data);
            $carrerResource = new CarrerResource($carrer);
            Cache::forget('carrer_' . $id);
            Cache::forget('carrer');
            return $this->successMessage($carrerResource, 'success update');
        } catch (QueryException $e) {
            return $this->errorMessage('gagal terhubung dengan server', [], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $carrer = Carrer::find($id);
        if (!$carrer) {
            return $this->errorMessage('gagal', 'id tidak ditemukan', 400);
        }
        $carrer->delete();
        Cache::forget('carrer_' . $id);
        Cache::forget('carrer');
        return $this->successMessage($carrer->batch . " berhasil dihapus", 'berhasil dihapus');
    }
}
