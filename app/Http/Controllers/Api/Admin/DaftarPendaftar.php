<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllPendaftar;
use App\Jobs\StatusApplyJob;
use App\Models\Apply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DaftarPendaftar extends Controller
{
    // semua pendaftar
    public function index(Request $request)
    {
        // initial
        $carrer_id = $request->carrer_id;
        $job_id = $request->job_id;
        $status = $request->status;
        $tipe_magang = $request->tipe_magang;
        // 
        $query = Apply::with('user.lowongan', 'carrer');
        $query->when($request->has('carrer_id'), function ($query) use ($carrer_id) {
            return $query->where('carrer_id', $carrer_id);
        });

        $query->when($request->has('job_id'), function ($query) use ($job_id) {
            return $query->whereHas('user', function ($query) use ($job_id) {
                $query->where('job_magang_id', $job_id);
            });
        });

        $query->when($request->has('status'), function ($query) use ($status) {
            return $query->where('status', $status);
        });

        $query->when($request->has('tipe_magang'), function ($query) use ($tipe_magang) {
            return $query->where('tipe_magang', $tipe_magang);
        });
        $apply = $query->get();
        $data = new AllPendaftar($apply);
        return $this->successMessage($data, 'berhasil get semua pendaftar');
    }

    // yang sudah dikonfirmasi
    public function pendaftar_konfirmasi(Request $request)
    {
        // initial
        $carrer_id = $request->carrer_id;
        $job_id = $request->job_id;
        $status = $request->status;
        $tipe_magang = $request->tipe_magang;
        // 
        $query = Apply::with('user.lowongan', 'carrer')->whereNotIn('status', ['menunggu']);
        $query->when($request->has('carrer_id'), function ($query) use ($carrer_id) {
            return $query->where('carrer_id', $carrer_id);
        });

        $query->when($request->has('job_id'), function ($query) use ($job_id) {
            return $query->whereHas('user', function ($query) use ($job_id) {
                $query->where('job_magang_id', $job_id);
            });
        });

        $query->when($request->has('status'), function ($query) use ($status) {
            return $query->where('status', $status);
        });

        $query->when($request->has('tipe_magang'), function ($query) use ($tipe_magang) {
            return $query->where('tipe_magang', $tipe_magang);
        });
        $apply = $query->get();
        return $this->successMessage($apply, 'berhasil get pendaftar yang sudah dikonfirmasi');
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:50|string',
            'email' => 'required|email',
            'profile_image' => 'mimes:jpeg,png,jpg',
            'no_hp' => 'integer'
        ], [
            'name.required' => 'Nama Harus diisi',
            'name.max' => 'Max 50 Karakter ',
            'email.required' => 'Email harus diisi',
            'profile_image.mimes' => 'Gambar harus jpg,jpg,png',
            'no_hp.integer' => 'No Hp wajib angka'
        ]);
        if ($validate->fails()) {
            return $this->errorMessage('Gagal Update Profile', $validate->messages(), 400);
        }

        $user = User::find($id);
        $image_file = $request->file('profile_image');
        $image_name = Str::uuid() . '.' . $image_file->getClientOriginalExtension();
        if (!empty($user->profile_image)) {
            Storage::delete('public/profile/' . $user->profile_image);
        }
        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => $request->password,
            "gender" => $request->gender,
            "alamat" => $request->alamat,
            "no_hp" => $request->no_hp,
            "profile_image" => $image_name,
        ];
        $user->update($data);

        return $this->successMessage($user, 'success update pendaftar');
    }
    public function search(Request $request)
    {
        $term = $request->query('search');
        $apply = Apply::with('user.lowongan', 'carrer')->whereHas("user", function ($query) use ($term) {
            $query->where('name', 'LIKE', "%" . $term . "%");
        })->get();
        $data = new AllPendaftar($apply);
        return $this->successMessage($data, 'success pencarian data apply');
    }
}
