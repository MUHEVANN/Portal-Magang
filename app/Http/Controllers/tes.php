<?php

namespace App\Http\Controllers;

use App\Models\Apply;
use App\Models\Carrer;
use App\Models\Konfirmed;
use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class tes extends Controller
{
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
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
        ]);

        if ($validate->fails()) {
            return response()->json(['error', $validate->messages()]);
        }
        $job = Lowongan::find($id);
        $carr = Carrer::latest()->first()->id;
        $data = [
            'name' => $request->name,
            'desc' => $request->desc,
            'benefit' => $request->benefit,
            'kualifikasi' => $request->kualifikasi,
            'carrer_id' => $carr,
            'deadline' => $request->deadline,
        ];
        if ($request->hasFile('gambar')) {
            $gambar_file = $request->file('gambar');
            $gambar_name = Str::uuid() . "." . $gambar_file->getClientOriginalExtension();
            $gambar_file->storeAs('public/lowongan', $gambar_name);
            Storage::delete('public/lowongan/' . $job->gambar);
            $data['gambar'] = $gambar_name;
        }
        $job->update($data);
        Cache::forget('job');
        return response()->json(['success' => 'Perubahan Disimpan']);
    }



    public function getApply(Request $request)
    {
        $allMonths = [];
        for ($i = 1; $i <= 12; $i++) {
            $allMonths[] = $i;
        }
        $filterYear = 2023;
        if ($request->has('filter_year')) {
            $filterYear = $request->query('filter_year');
        }
        // Query untuk mengambil data pendaftaran pengguna
        $userRegistrations = User::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $filterYear)
            ->groupBy('year', 'month')
            ->get();

        // Buat kumpulan data lengkap dengan semua bulan
        $data = [];
        $months = [];
        foreach ($allMonths as $month) {
            $matchingData = $userRegistrations->where('month', $month)->first();
            $count = $matchingData ? $matchingData->count : 0;
            $year = $matchingData ? $matchingData->year : date('Y');
            $months[] = [
                'month' => $month,
                'count' => $count,
            ];
        }
        $data[] = [
            'months' => $months,
        ];


        array_push($data, $year);
        // $user = User::count();
        // $apply = Apply::where('status', 'menunggu')->count();
        // $lulus = Apply::where('status', 'lulus')->count();
        // $ditolak = Apply::where('status', 'Ditolak')->count();
        // $batch = Carrer::count();
        // $lowongan = Lowongan::count();
        // $result = [
        //     'total user' => $user,
        //     'total pendaftar' => $apply,
        //     'total apply lulus' => $lulus,
        //     'total ditolak' => $ditolak,
        //     'total batch' => $batch,
        //     'total lowongan' => $lowongan,
        // ];
        return $this->successMessage($data, 'success');
    }
    public function get_year()
    {
        $years = User::selectRaw('YEAR(created_at) as year')->get();
        $data = [];

        foreach ($years as $year) {
            if (!in_array($year, $data)) {
                $data[] = $year;
            }
        }

        return $this->successMessage($data, 'berhasil');
    }
}
