<?php

namespace App\Http\Controllers\User;

use App\Models\Apply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\AfterApply;
use App\Jobs\CreateUserFromApply;
use App\Jobs\StatusApplyJob;
use App\Models\Carrer;
use App\Models\Kelompok;
use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApplyJobController extends Controller
{
    public function index()
    {
        Apply::with('user', 'lowongan')->get();
        return view('Admin.Apply.index');
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $user = User::where('email', Auth::user()->email)->first();
        if ($user->is_active !== '1') {
            return redirect()->to('profile')->withErrors(['belum-verif' => "Akun anda belum diverifikasi, cek email anda"]);
        }
        $existingApply = Apply::where('user_id', Auth::user()->id)
            ->whereIn('status', ['menunggu'])
            ->first();
        if ($existingApply) {
            return redirect()->back()->withErrors(['sudah-Apply' => 'Anda sudah melakukan Apply, silahkan tunggu konfirmasi dari kami']);
        }
        $kelompok = Kelompok::create([
            'name' => Str::random(5)
        ]);

        // untuk carrer ketua dan mandiri
        $carr = Carrer::latest()->first();
        $carrer = new Apply();
        $carrer->user_id = auth()->user()->id;
        $carrer->tgl_mulai = $request->tgl_mulai;
        $carrer->tgl_selesai = $request->tgl_selesai;
        $carrer->carrer_id = $carr->id;
        $carrer->tipe_magang = $request->tipe_magang;
        $cv_file = $request->file('cv_pendaftar');
        $cv_name = date('ymdhis') . '.' . $cv_file->getClientOriginalExtension();
        $cv_path = $cv_file->storeAs('public/cv', $cv_name);
        $carrer->cv_user = $cv_name;
        $carrer->save();

        // akun ketua dan mandiri
        $pendaftar = User::where('email', Auth::user()->email)->first();
        $pendaftar->job_magang_id = $request->job_magang_ketua;
        $pendaftar->jabatan = 1;
        // kelompok
        if ($request->tipe_magang === 'kelompok') {
            $pendaftar->kelompok_id = $kelompok->id;

            $validate = Validator::make($request->all(), [
                'job_magang' => 'required',
                'cv' => 'required|mimes:pdf',
                'name' => 'required',
                'email' => 'required|unique:users',
            ]);

            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate->messages())->withInput();
            }


            $email = $request->email;
            for ($i = 0; $i < count($email); $i++) {
                $user_acc = User::where('email', $email[$i])->first();
                $cv_file = $request->file('cv_pendaftar')[$i];
                $cv_name = date('ymdhis') . '.' . $cv_file->getClientOriginalExtension();
                $cv_path = $cv_file->storeAs('public/cv', $cv_name);
                if (!$user_acc) {
                    $password = Str::random(10);
                    // user baru
                    $new_user = User::create([
                        'name' => $request->name[$i],
                        'email' => $request->email[$i],
                        'job_magang_id' => $request->job_magang[$i],
                        'password' => $password,
                        'kelompok_id' => $kelompok->id,
                    ]);
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
                    $user_acc->kelompok_id = $kelompok->id;
                    $user_acc->job_magang_id = $request->job_magang[$i];
                    $user_acc->save();
                    AfterApply::dispatch($user_acc);
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
        }
        $pendaftar->save();
        AfterApply::dispatch($pendaftar);

        return redirect()->to('home');
    }

    public function formApply()
    {
        $index = 0;
        $carrer_id = Carrer::latest()->first()->id;
        $lowongan = Lowongan::whereNotIn('name', ['kosong', 'admin'])->where('carrer_id', $carrer_id)->get();
        return view('Admin.Apply.form', ['lowongan' => $lowongan, 'index' => $index]);
    }
    public function detail_lowongan()
    {
        // dd(Auth::user()->kelompok_id);
        $lowongan = Lowongan::get();
        return view('Admin.Apply.form', compact('lowongan'));
    }
    /** 
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $apply =  Apply::find($id);
        return view('Admin.Apply.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function reject($id)
    {
        $apply = Apply::find($id);
        $apply->status = 'Ditolak';
        $apply->save();
        foreach ($apply->kelompok->user as $user) {
            // dd($apply->status);
            StatusApplyJob::dispatch($user, $apply->status);
        }
        return redirect()->to('dashboard')->with(['success' => 'Apply job berhasil dikonfirmasi']);
    }
    public function konfirm($id)
    {
        $apply = Apply::find($id);
        $apply->status = 'lulus';
        $apply->save();
        foreach ($apply->kelompok->user as $user) {
            StatusApplyJob::dispatch($user, $apply->status);
        }
        return redirect()->to('all-pemagang')->with(['success' => 'Apply job berhasil dikonfirmasi']);
    }
    public function destroy(string $id)
    {
    }
}
