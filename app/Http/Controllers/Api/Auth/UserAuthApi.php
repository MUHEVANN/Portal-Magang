<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserAuth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserAuthApi extends Controller
{
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => "required|email",
            'password' => "required",
        ]);

        if ($validate->fails()) {
            return $this->errorMessage('lengkapi data dengan benar', $validate->messages(), 400);
        }

        $user = User::where('email', $request->email)->first();
        $remember = $request->has('remember');
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Session::put('user', $user);
                Auth::login($user, $remember);
                $userToken = $user->createToken('authToken')->plainTextToken;
                $userResource  = new UserAuth($user);
                $data = [
                    'access_token' => $userToken,
                    'token_type' => 'Bearer',
                    'user' => $userResource
                ];
                return $this->successMessage($data, 'Berhasil Melakukan Login');
            } else {
                return $this->errorMessage('lengkapi data dengan benar', 'Password salah', 400);
            }
        } else {
            return $this->errorMessage('Data tidak ada', 'Email tidak ditemukan', 400);
        }
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => "required",
            'email' => "required|email|unique:users",
            'password' => "required",
        ]);

        if ($validate->fails()) {
            return $this->errorMessage('Gagal Register', $validate->messages(), 400);
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "verif_code" => Str::uuid(),
        ]);
        $user->addRole('client');
        Session::put('user', $user);
        Auth::login($user);
        $userToken = $user->createToken('authToken')->plainTextToken;
        $userResource = new UserAuth($user);
        $data = [
            'access_token' => $userToken,
            'token_type' => 'Bearer',
            'user' => $userResource
        ];
        return $this->successMessage($data, 'Register Berhasil');
    }
}
