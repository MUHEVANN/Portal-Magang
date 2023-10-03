<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileControllerApi extends Controller
{
    public function profile()
    {
        $user_id = Auth::user()->id;
        $user = Cache::remember('user_' . $user_id, 3600, function () use ($user_id) {
            return User::with('lowongan')->find($user_id);
        });
        $profileResource = new ProfileResource($user);
        return $this->successMessage($profileResource, 'Berhasil Get Profile');
    }

    public function update(Request $request)
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
        $id = auth()->user()->id;
        $user = User::find($id);
        $image_file = $request->file('profile_image');
        $image_name = Str::uuid() . '.' . $image_file->getClientOriginalExtension();
        if (!empty($user->profile_image)) {
            Storage::delete('public/profile/' . $user->profile_image);
        }
        $image_file->storeAs('public/profile', $image_name);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'profile_image' => $image_name,
            'gender' => $request->gender,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ];
        $user->update($data);
        $profileResource = new ProfileResource($user);
        return $this->successMessage($profileResource, 'Profile Berhasil Diupdate');
    }
}
