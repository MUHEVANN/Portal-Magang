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
        $user = User::where('email', Auth::user()->email)->first();
        if ($user->is_active !== '1') {
            return redirect()->to('profile')->withErrors(['belum-verif' => "Akun anda belum diverifikasi, cek email anda"]);
        }
        $validate = Validator::make($request->all(), [
            'job_magang' => 'required',
            'cv' => 'required|mimes:pdf',
            'name' => 'required',
            'email' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }
        // $existingApply = Apply::where('kelompok_id', Auth::user()->kelompok_id)
        //     ->whereIn('status', ['mengunggu', 'lulus'])
        //     ->get();
        // if ($existingApply) {
        //     return redirect()->back()->withErrors(['sudah-Apply' => 'Anda sudah melakukan Apply, silahkan tunggu konfirmasi dari kami']);
        // }
        $email = $request->email;
        $kelompok = Kelompok::create([
            'name' => Str::random(5)
        ]);

        $carrer = new Apply();
        $carr = Carrer::latest()->get();

        for ($i = 0; $i < count($email); $i++) {
            $user_acc = User::where('email', $email[$i])->first();
            if (!$user_acc) {
                $new_user = new User();
                $new_user->name = $request->name[$i];
                $new_user->email = $request->email[$i];
                $new_user->job_magang_id = $request->job_magang[$i];
                $new_user->password = Str::random(60);
                $new_user->kelompok_id = $kelompok->id;
                $new_user->save();
                CreateUserFromApply::dispatch($new_user);
            } else {
                $user_acc->kelompok_id = $kelompok->id;
                $user_acc->job_magang_id = $request->job_magang[$i];
                $user_acc->save();
                AfterApply::dispatch($user_acc);
            }
        }
        $ketua = User::where('email', Auth::user()->email)->first();
        $ketua->jabatan = 1;
        $ketua->save();

        $carrer->kelompok_id = $kelompok->id;
        $carrer->carrer_id = $carr->first()->id;
        $cv_file = $request->file('cv');
        $cv_name = date('ymdhis') . '.' . $cv_file->getClientOriginalExtension();
        $cv_path = $cv_file->storeAs('public/cv', $cv_name);
        $carrer->cv_user = $cv_name;
        $carrer->save();
        // dd($carrer->carrer_id);


        return redirect()->to('home');
    }

    public function formApply()
    {
        // dd(Auth::user()->kelompok_id);
        $lowongan = Lowongan::whereNotIn('name', ['kosong', 'admin'])->get();
        return view('Admin.Apply.form', compact('lowongan'));
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
        return redirect()->to('dashboard')->with(['success' => 'Apply job berhasil dikonfirmasi']);
    }
    public function destroy(string $id)
    {
    }
}
