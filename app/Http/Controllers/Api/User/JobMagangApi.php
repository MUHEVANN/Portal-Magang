<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Carrer;
use App\Models\Lowongan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class JobMagangApi extends Controller
{
    public function index()
    {
        $job = Cache::remember('job', 3000, function () {
            return Lowongan::select('id', 'name', 'gambar', 'created_at', 'updated_at', 'carrer_id')->with('carrer')->get();
        });

        return $this->successMessage($job, 'Berhasil get job');
    }

    public function show($id)
    {
        $job = Cache::remember('job_' . $id, 3000, function () use ($id) {
            return Lowongan::with('carrer')->find($id);
        });
        if (!$job) {
            return $this->errorMessage('Id tidak ditemukan', 'gagal', 400);
        }
        return $this->successMessage($job, 'Berhasil get job');
    }

    public function update(Request $request, $id)
    {
        try {
            $job = Lowongan::find($id);
            $carr = Carrer::latest()->first()->id;
            $gambar_file = $request->file('gambar');
            $gambar_name = Str::uuid() . "." . $gambar_file->getClientOriginalExtension();
            $gambar_file->storeAs('public/lowongan', $gambar_name);
            Storage::delete('public/lowongan/' . $job->gambar);
            $data = [
                'name' => $request->name,
                'gambar' => $request->gambar,
                'desc' => $request->desc,
                'benefit' => $request->benefit,
                'kualifikasi' => $request->kualifikasi,
                'carrer_id' => $carr,
                'gambar' => $gambar_name,
            ];
            $job->update($data);
            Cache::forget('job_' . $id);
            return $this->successMessage($job, 'Berhasil mengupdate lowongan');
        } catch (QueryException $e) {
            return $this->errorMessage('gagal', $e, 500);
        }
    }
    public function delete($id)
    {
        $job = Lowongan::find($id);
        $job->delete();
        Cache::forget('job_' . $id);
        return $this->successMessage('berhasil menghapus', 'Berhasil menghapus');
    }

    public function filter(Request $request)
    {
        $carrer = Carrer::latest()->first();
        $query = Lowongan::where('carrer_id', $carrer->id);
        $waktu = $request->waktu;
        // dd($waktu);
        $query->when($waktu === 'terlama', function ($query) {
            return $query->orderBy('created_at', 'desc');
        }, function ($query) {
            return $query->orderBy('created_at', 'asc');
        });
        $data = $query->get();

        return $this->successMessage($data, 'success');
    }
}
