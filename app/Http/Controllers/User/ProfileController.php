<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $user = User::with('lowongan')->find($user_id);
        return view('Home.profile.index', compact('user'));
    }
    public function update_profile(Request $request)
    {
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        if ($request->hasFile('profile_image')) {
            $gambar = $request->file('profile_image');
            $gambar_name = date('ymdhis') . $gambar->getClientOriginalExtension();
            $gambar_path = $gambar->storeAs('public/profile', $gambar_name);
            if (!$user->gambar === NULL) {
                Storage::delete('public/profile/', $user->gambar);
            }
            $user->profile_image = $gambar_name;
        }
        $user->name = $request->name;
        if ($request->has('email')) {
            $user->email = $request->email;
            $user->is_active = 0;
        }
        $user->alamat = $request->alamat;
        $user->gender = $request->gender;
        $user->no_hp = $request->no_hp;
        $user->save();


        return response()->json('update profile berhasil');
    }
}
