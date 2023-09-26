<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DaftarPengguna extends Controller
{
    public function index()
    {
        $user = Cache::remember('daftar_pengguna', 3000, function () {
            return User::get();
        });

        return $this->successMessage($user, 'Berhasil get semua pengguna');
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return $this->errorMessage('Id tidak ditemukan', [], 400);
            }
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'gender' => $request->gender,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ];
            $user->update($data);

            return $this->successMessage($user, 'Berhasil Update User');
        } catch (QueryException $e) {
            return $this->errorMessage('Terjadi kesalahan server', [], 500);
        }
    }

    public function show($id)
    {
        $user = User::with('kelompok', 'apply', 'lowongan')->find($id);
        if (!$user) {
            return $this->errorMessage('Id tidak ditemukan', [], 400);
        }
        return $this->successMessage($user, 'Berhasil Show User');
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return $this->successMessage('berhasil menghapus', 'Berhasil Delete User');
    }
}
