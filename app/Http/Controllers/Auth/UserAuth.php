<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Jobs\EmailUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\CodeChangePassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
            'email' => "required|email|unique:users",
            'password' => "required",
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "verif_code" => Str::uuid(60),
        ]);
        $user->addRole('client');
        Session::put('user', $user);
        Auth::login($user);
        return redirect()->to('home')->with('success', 'Akun berhasil dibuat');
    }

    public function login()
    {
        if (!Auth::check()) {
            return view('Auth.login');
        }
        // $cekuser = Cache::get('user');
        // if ($cekuser) {
        //     return $cekuser;
        // }
        // $user = Cache::put($cekuser, auth()->user(), 360000);

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
        $remember = $request->has('remember');
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Session::put('user', $user);
                Auth::login($user, $remember);
                if ($user->hasRole('admin')) {
                    return redirect()->to('all-pemagang');
                } else {
                    Session::put('user', $user);
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
        }

        CodeChangePassword::dispatch($user);
        return redirect()->to('/verif-email-changePassword')->with(['success' => 'Kode telah dikirimkan periksa email anda']);
    }

    public function changePassword()
    {
        return view('Auth.changePassword');
    }
    public function proccess_changePassword(Request $request)
    {
        $validate = Validator::make($request->all(), [

            'verif_code' => 'required',
            'password' => 'required',
            'repeat_password' => 'required|same:password'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate->messages())->withInput();
        }

        $user = User::where('verif_code', $request->verif_code)->first();

        if (!$user) {
            return redirect()->back()->with(['error' => 'Inputkan Kode dengan benar']);
        } else {
            $user->password = $request->password;
            $user->save();
            return redirect('/login')->with(['success' => "Password berhasil diganti"]);
        }
    }

    public function ganti_password(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password_lama' => 'required',
            'password_baru' => 'required',
            'confirm_password' => 'required|same:password_baru',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->messages()]);
        }
        $password = $request->password_lama;
        $new_password = $request->password_baru;

        $id = auth()->user()->id;
        $user = User::find($id);
        if (Hash::check($password, $user->password)) {
            $user->password = $new_password;
            $user->save();
            return response()->json(['success' => 'password berhasil diganti']);
        } else {
            return response()->json(['error' => 'Password tidak sama']);
        }
    }
}
