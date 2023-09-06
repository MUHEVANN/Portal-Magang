<?php

namespace App\Http\Controllers;

use App\Jobs\AfterApply;
use App\Jobs\CreateUserFromApply;
use App\Jobs\StatusApplyJob;
use App\Mail\StatusApply;
use App\Models\Apply;
use App\Models\Carrer;
use App\Models\CarrerUser;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApplyJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        CarrerUser::with('user', 'lowongan')->get();
        return view('Admin.Apply.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Create.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::where('email', Auth::user()->email)->first();
        if ($user->is_active !== '1') {
            return redirect()->to('profile')->withErrors(['belum-verif' => "Akun anda belum diverifikasi, cek email anda"]);
        }
        $validate = Validator::make($request->all(), [
            'user_id' => 'required',
            'lowongan_id' => 'required',
            'cv' => 'required|mimes:pdf',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }
        $user = Apply::where('kelompok_id', Auth::user()->kelompok_id)->where('konfirmasi', 'belum')->first();
        $user2 = Apply::where('kelompok_id', Auth::user()->kelompok_id)->where('konfirmasi', 'lulus')->first();
        if ($user) {
            return redirect()->back()->withErrors(['sudah-Apply' => 'Anda sudah melakukan Apply, silahkan tunggu konfirmasi dari kami']);
        } elseif ($user2) {
            return redirect()->back()->withErrors(['sudah-lulus' => 'Anda sudah lulus, silahkan cek email anda']);
        }
        $email = $request->email;
        if ($request->has('kelompok')) {
            $kelompok = Kelompok::create([
                'name' => Str::random(5)
            ]);
        }
        $carrer = new Apply();
        $carr = Carrer::latest()->get();
        for ($i = 0; $i < count($email); $i++) {
            $user_acc = User::where('email', $email[$i])->first();
            if (!$user_acc) {
                $new_user = new User();
                $new_user->name = $request->name;
                $new_user->email = $request->email;
                $new_user->password = Hash::make($request->password);
                if ($request->has('jabatan')) {
                    $new_user->jabatan = 1;
                }
                if ($request->has('kelompok')) {
                    $new_user->kelompok_id = $kelompok->id;
                }
                CreateUserFromApply::dispatch($new_user);
            } else {
                if ($request->has('kelompok')) {
                    $user_acc->kelompok_id = $kelompok->id;
                }
                if ($request->has('jabatan')) {
                    $user_acc->jabatan = 1;
                }
                AfterApply::dispatch($user_acc);
            }
        }
        if ($request->has('kelompok')) {
            $carrer->kelompok_id = $kelompok->id;
        }
        $carrer->carrer_id = $carr->id;
        $carrer->user_id = $user_acc->id;
        $carrer->lowongan_id = $request->lowongan;
        $carrer->cv = $request->cv;
        $carrer->save();

        if ($carrer) {
            return redirect()->back();
        }
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
        return redirect()->back()->with(['success' => 'Apply job berhasil dikonfirmasi']);
    }
    public function konfirm($id)
    {
        $apply = Apply::find($id);
        $apply->status = 'lulus';
        $apply->save();
        foreach ($apply->kelompok->user as $user) {
            // dd($apply->status);
            StatusApplyJob::dispatch($user, $apply->status);
        }
        return redirect()->back()->with(['success' => 'Apply job berhasil dikonfirmasi']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
