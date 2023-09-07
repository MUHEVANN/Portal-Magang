<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Jobs\EmailUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\CodeChangePassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserAuth extends Controller
{
    public function register()
    {
        if (Auth::check()) {
            return redirect()->back();
        }
        return view('Auth.register');
    }
    public function proccess_register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => "required",
            'email' => "required|email",
            'password' => "required",
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "verif_code" => Str::random(60),
        ]);
        $user->addRole('client');
        Auth::login($user);
        return redirect()->to('home')->with('success', 'Akun berhasil dibuat');
    }

    public function login()
    {
        if (!Auth::check()) {
            return view('Auth.login');
        }

        return redirect()->back();
    }
    public function proccess_login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => "required|email",
            'password' => "required",
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Session::put('user', $user);
                Auth::login($user);
                if ($user->hasRole('admin')) {
                    return redirect()->to('dashboard');
                } else {
                    return redirect()->to('home');
                }
            } else {
                return redirect()->back()->withErrors(['password' => "password salah"]);
            }
        } else {
            return redirect()->back()->withErrors(['email' => "email tidak ada"]);
        }
    }

    public function logout()
    {
        Session::forget('user');
        Auth::logout();
        return redirect()->to('login');
    }


    public function verif_email_changePassword()
    {
        return view('Auth.verifEmailChangePassword');
    }
    public function code_changePassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages());
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with(['error' => "Email tidak ada"]);
        } elseif ($user && $user->is_active === "0") {
            return redirect()->back()->with(['error' => "Email belum diverifikasi"]);
        } else {
            $user->verif_code = Str::random(60);
            $user->save();
            CodeChangePassword::dispatch($user);
            return redirect()->to('/changePassword')->with(['success' => 'Kode telah dikirimkan periksa email anda']);
        }
    }

    public function changePassword()
    {
        return view('Auth.changePassword');
    }
    public function proccess_changePassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'verif_code' => 'required',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages());
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->with(['error' => 'Email tidak ada']);
        } elseif ($user && $request->verif_code !== $user->verif_code) {
            return redirect()->back()->with(['error' => 'Inputkan Kode dengan benar']);
        } else {
            $user->verif_code = NULL;
            $user->password = $request->password;
            $user->save();
            return redirect('/')->with(['success' => "Password berhasil diganti"]);
        }
    }
}
