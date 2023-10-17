<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $cek = Auth::check();
        if (!$cek) {
            return redirect()->to('login')->with(['error' => 'Login terlebih dahulu']);
        }
        $user_id = Auth::user()->id;
        $cekuser = Cache::get('user_' . $user_id);
        // $user = Cache::remember('user_' . $user_id, 3600, function () use ($user_id) {
        //     return User::with('lowongan')->find($user_id);
        // });
        $user = User::find($user_id);
        return view('Home.profile.index', compact('user'));
    }

    public function get_profile()
    {
        $user_id = Auth::user()->id;
        $user = Cache::remember('user_' . $user_id, 3600, function () use ($user_id) {
            return User::find($user_id);
        });

        // $user = User::with('lowongan')->find($user_id);
        $response = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
            'gender' => $user->gender,
            'alamat' => $user->alamat,
            'no_hp' => $user->no_hp,
            // 'job_magang_id' => $user->job_magang_id === null ? 'Tidak Ada Job' : $user->lowongan->name,
            'profile_image' => $user->profile_image,

        ];
        return response()->json($response);
    }

    public function update_profile(Request $request)
    {
        $validate = Validator::make(['name' => $request->name], [
            'name' => 'max:50|string'
        ]);
        if ($validate->fails()) {
            return response()->json(['error' => $validate->messages()]);
        }
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        if ($request->hasFile('profile_image')) {
            $gambar = $request->file('profile_image');
            $gambar_name = date('ymdhis') . $gambar->getClientOriginalExtension();
            $gambar_path = $gambar->storeAs('public/profile', $gambar_name);
            if ($user->gambar !== NULL) {
                Storage::delete('public/profile/', $user->gambar);
            }
            $user->profile_image = $gambar_name;
        }
        $user->name = $request->name;
        // if ($request->has('email')) {
        //     $user->is_active = 0;
        // }
        $user->email = $request->email;
        $user->alamat = $request->alamat;
        $user->gender = $request->gender;
        $user->no_hp = $request->no_hp;
        $user->save();
        Cache::put('user_' . $user->id, $user, 3600);
        $image = asset('storage/profile/' . $user->profile_image);

        return response()->json(['success' => 'update profile berhasil']);
    }

    public function dashboard()
    {
        return view('Home.profile.dashboard');
    }
}
