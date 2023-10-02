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
use Illuminate\Support\Facades\Validator;

class JobMagangApi extends Controller
{
    public function index(Request $request)
    {
        $query = Lowongan::with('carrer');
        $batch_id = $request->batch_id;
        $query->when($request->has('batch_id'), function ($query) use ($batch_id) {
            return $query->where('carrer_id', $batch_id);
        });
        $job = Cache::remember('job', 3000, function () use ($query) {
            return $query->get();
        });
        $data = [
            'job' => $job,
            'total job' => $job->count()
        ];

        return $this->successMessage($data, 'Berhasil get job');
    }

    public function getJobUser(Request $request)
    {
        $carrer = Carrer::latest()->first();
        $query = Lowongan::select('id', 'name', 'gambar', 'created_at', 'updated_at', 'carrer_id', 'deadline')->where('carrer_id', $carrer->id);
        $waktu = $request->waktu;

        $query->when($waktu === 'terlama', function ($query) {
            return $query->orderBy('created_at', 'desc');
        });

        $job =  Cache::remember('job' . $waktu, 3000, function () use ($query) {
            return $query->get();
        });

        return $this->successMessage($job, 'success');
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

    public function store(Request $request)
    {
        try {
            $carr_id = Carrer::latest()->first()->id;
            $validate = Validator::make($request->all(), [
                'name' => 'required|unique:job_magang',
                'gambar' => 'required|mimes:jpg,png,jpeg,svg',
                'desc' => 'required',
                'kualifikasi' => 'required',
                'benefit' => 'required',
                'deadline' => 'required'
            ], [
                'name.required' => 'Nama tidak boleh kosong',
                'desc.required' => 'Descripsi tidak boleh kosong',
                'kualifikasi.required' => 'Kualifikasi tidak boleh kosong',
                'benefit.required' => 'Benefit tidak boleh kosong',
                'deadline.required' => 'deadline tidak boleh kosong',
                'gambar.required' => 'Gambar tidak boleh kosong',
                'gambar.mimes' => 'Gambar harus bertipe jpg/png/jpeg/svg',
            ]);

            if ($validate->fails()) {
                return $this->errorMessage('gagal', $validate->messages(), 400);
            }
            $gambar_file = $request->file('gambar');
            $gambar_name = Str::uuid() . "." . $gambar_file->getClientOriginalExtension();
            $gambar_file->storeAs('public/lowongan', $gambar_name);
            $data = Lowongan::create([
                'name' => $request->name,
                'desc' => $request->desc,
                'kualifikasi' => $request->kualifikasi,
                'benefit' => $request->benefit,
                'gambar' => $gambar_name,
                'carrer_id' => $carr_id,
                'deadline' => $request->deadline
            ]);
            Cache::forget('job');
            return $this->successMessage($data, 'Berhasil membuat lowongan');
        } catch (\Throwable $th) {
            throw $th;
        }
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
                'deadline' => $request->deadline,
            ];
            $job->update($data);
            Cache::forget('job');
            Cache::forget('job_terlama');
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
        Cache::forget('job');
        Cache::forget('job_terlama');
        Cache::forget('job_' . $id);
        return $this->successMessage('berhasil menghapus', 'Berhasil menghapus');
    }
}
