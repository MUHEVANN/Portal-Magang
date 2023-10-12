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



    public function getApply()
    {
        // $data = Apply::with('user.lowongan', 'user.kelompok')->get();
        // $data = User::all();
        // $data = User::with('konfirmed')->find(auth()->user()->id);
        // $konfirmed_ketua = $data->konfirmed->last();
        // $konfirmed_at = $konfirmed_ketua->created_at;
        // $sixtyDaysAgo = $konfirmed_at->addDays(60);
        // $time = $sixtyDaysAgo->diffInDays(now());
        // $konfirm =   Konfirmed::with('user')->where('isSend', 0)->first();
        // $konfirm_at = $konfirm->created_at;
        // $sixtyDays = $konfirm_at->addMinutes(7);
        // $data = now()->diffInMinutes($sixtyDays);
        // $data = $konfirm;
        $data = Apply::with('carrer', 'lowongan', 'kelompok')->where('user_id', auth()->user()->id)->get();
        return $this->successMessage($data, 'success');
    }
}
