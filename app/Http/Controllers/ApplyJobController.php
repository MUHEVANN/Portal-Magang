<?php

namespace App\Http\Controllers;

use App\Jobs\AfterApply;
use App\Jobs\CreateUserFromApply;
use App\Jobs\StatusApplyJob;
use App\Mail\StatusApply;
use App\Models\CarrerUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = CarrerUser::where('id', Auth::user()->id)->where('konfirmasi', 'belum')->first();
        $user2 = CarrerUser::where('id', Auth::user()->id)->where('konfirmasi', 'lulus')->first();
        if ($user) {
            return redirect()->back()->withErrors(['sudah-Apply' => 'Anda sudah melakukan Apply, silahkan tunggu konfirmasi dari kami']);
        } elseif ($user2) {
            return redirect()->back()->withErrors(['sudah-lulus' => 'Anda sudah lulus, silahkan cek email anda']);
        }
        $email = $request->email;
        $password = $request->password;
        for ($i = 0; $i < count($email); $i++) {
            $user_acc = User::where('email', $email[$i])->first();
            $carrer = new CarrerUser();
            if (!$user_acc) {
                $new_user = User::create([
                    'name' => $request->name[$i],
                    'email' => $email[$i],
                    'password' => Str::random(60),
                ]);
                $carrer->user_id = $new_user->id;
                $carrer->lowongan_id = $request->lowongan[$i];
                $carrer->cv = $request->cv[$i];
                $carrer->save();
                CreateUserFromApply::dispatch($new_user);
            } else {
                $carrer->user_id = $user_acc->id;
                $carrer->lowongan_id = $request->lowongan[$i];
                $carrer->cv = $request->cv[$i];
                $carrer->save();
                AfterApply::dispatch($user_acc);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $apply =  CarrerUser::find($id);
        return view('Admin.Apply.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function reject($id)
    {
        $apply = CarrerUser::find($id);
        $apply->konfirmasi = 'tidak-lulus';
        $apply->save();
        StatusApplyJob::dispatch($apply);
        return redirect()->back()->with(['success' => 'Apply job berhasil dikonfirmasi']);
    }
    public function konfirm($id)
    {
        $apply = CarrerUser::find($id);
        $apply->konfirmasi = 'lulus';
        $apply->save();
        StatusApplyJob::dispatch($apply);
        return redirect()->back()->with(['success' => 'Apply job berhasil dikonfirmasi']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
