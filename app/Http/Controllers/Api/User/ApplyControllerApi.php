<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserApply;
use App\Jobs\AfterApply;
use App\Jobs\CreateUserFromApply;
use App\Models\Apply;
use App\Models\Carrer;
use App\Models\Kelompok;
use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApplyControllerApi extends Controller
{
    public function apply(Request $request)
    {
        // dd($request->all());
        $user = User::where('email', Auth::user()->email)->first();
        if ($user->is_active !== '1') {
            return $this->errorMessage('Gagal total', "Akun anda belum diverifikasi, cek email anda", 400);
        }
        $existingApply = Apply::where('user_id', Auth::user()->id)
            ->whereIn('status', ['menunggu'])
            ->first();
        if ($existingApply) {
            return $this->errorMessage('Gagal total', 'Anda sudah melakukan Apply, silahkan tunggu konfirmasi dari kami', 400);
        }
        $validate = Validator::make($request->all(), [
            'job_magang_ketua' => 'required',
            'cv_pendaftar' => 'required|mimes:pdf',
        ]);

        if ($validate->fails()) {
            return $this->errorMessage('Gagal total', $validate->messages(), 400);
        }

        // untuk carrer ketua dan mandiri

        $carr = Carrer::latest()->first();


        // akun ketua dan mandiri
        $pendaftar = User::where('email', Auth::user()->email)->first();
        $pendaftar->job_magang_id = $request->job_magang_ketua;
        $pendaftar->jabatan = 1;
        // kelompok
        $semua_pendaftar = [];
        if ($request->tipe_magang === 'kelompok') {
            $kelompok = Kelompok::create([
                'name' => Str::random(5)
            ]);
            $pendaftar->kelompok_id = $kelompok->id;
            $pendaftar->save();
            $validate_anggota = Validator::make($request->all(), [
                'job_magang' => 'required',
                'name' => 'required',
                'email' => 'required|unique:users',
            ]);

            if ($validate_anggota->fails()) {
                return $this->errorMessage('Gagal', $validate_anggota->messages(), 400);
            }

            $files = $request->file('cv_anggota');
            foreach ($files as $file) {
                $validateCV = Validator::make(['cv_anggota' => $file], [
                    'cv_anggota' => 'required|mimes:pdf'
                ]);
                if ($validateCV->fails()) {
                    return $this->errorMessage('Gagal', $validate->messages(), 400);
                }
            }
            $email = $request->email;
            if (count($email) > 5) {
                return $this->errorMessage('Gagal', 'max 5 anggota', 400);
            }

            for ($i = 0; $i < count($email); $i++) {
                $user_acc = User::where('email', $email[$i])->first();
                $cv_file = $request->file('cv_anggota')[$i];
                $cv_name = Str::random(10) . '.' . $cv_file->getClientOriginalExtension();
                $cv_path = $cv_file->storeAs('public/cv', $cv_name);
                if (!$user_acc) {
                    $password = Str::random(10);
                    // user baru
                    $new_user = User::create([
                        'name' => $request->name[$i],
                        'email' => $request->email[$i],
                        'job_magang_id' => $request->job_magang[$i],
                        'password' => Hash::make($password),
                        'kelompok_id' => $kelompok->id,
                    ]);
                    array_push($semua_pendaftar, $new_user);
                    CreateUserFromApply::dispatch($new_user, $password);
                    // carrer
                    $carrer = Apply::create([
                        'user_id' => $new_user->id,
                        'tgl_mulai' => $request->tgl_mulai,
                        'tgl_selesai' => $request->tgl_selesai,
                        'carrer_id' => $carr->id,
                        'tipe_magang' => $request->tipe_magang,
                        'cv_user' => $cv_name
                    ]);
                } else {
                    $cek_anggota_sudah_apply = Apply::where('user_id', $user_acc->id)->first();
                    if ($cek_anggota_sudah_apply) {
                        return $this->errorMessage('Gagal', 'Salah satu anggotamu sudah pernah apply', 400);
                    }
                    $user_acc->kelompok_id = $kelompok->id;
                    $user_acc->job_magang_id = $request->job_magang[$i];
                    $user_acc->save();
                    AfterApply::dispatch($user_acc);
                    array_push($semua_pendaftar, $user_acc);
                    // carrer
                    $carrer = Apply::create([
                        'user_id' => $user_acc->id,
                        'tgl_mulai' => $request->tgl_mulai,
                        'tgl_selesai' => $request->tgl_selesai,
                        'carrer_id' => $carr->id,
                        'tipe_magang' => $request->tipe_magang,
                        'cv_user' => $cv_name
                    ]);
                }
            }
        } else {
            $pendaftar->kelompok_id = 1;
        }
        $pendaftar->save();
        $carrer = new Apply();
        $carrer->user_id = auth()->user()->id;
        $carrer->tgl_mulai = $request->tgl_mulai;
        $carrer->tgl_selesai = $request->tgl_selesai;
        $carrer->carrer_id = $carr->id;
        $carrer->tipe_magang = $request->tipe_magang;
        $cv_file = $request->file('cv_pendaftar');
        $cv_name = Str::random(10) . '.' . $cv_file->getClientOriginalExtension();
        $cv_path = $cv_file->storeAs('public/cv', $cv_name);
        $carrer->cv_user = $cv_name;
        $carrer->save();
        array_push($semua_pendaftar, $pendaftar);
        Cache::forget('all-pemagang');
        AfterApply::dispatch($pendaftar);
        return $this->successMessage($semua_pendaftar, 'Berhasil Apply');
    }
}
