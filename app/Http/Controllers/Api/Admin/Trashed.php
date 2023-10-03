<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Trashed extends Controller
{
    public function index()
    {
        $user = User::with('kelompok', 'apply.carrer', 'lowongan')->onlyTrashed()->get();
        return $this->successMessage($user, 'Berhasil get pengguna yang sudah dihapus');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        if (!$user) {
            return $this->errorMessage('gagal', 'id tidak ditemukan');
        }
        $user->restore();
        return $this->successMessage($user, 'berhasil direstore');
    }
}
