<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\StatusApplyJob;
use App\Models\Apply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DaftarPendaftar extends Controller
{
    public function index()
    {
        $user = User::with('apply.carrer')->whereHas('apply', function ($query) {
            $query->where('status', 'menunggu');
        })->get();

        return $this->successMessage($user, 'Berhasil get pendaftar');
    }

    public function pendaftar_konfirmasi()
    {
        $apply = Apply::whereNotIn('status', ['menunggu'])->get();
        return $this->successMessage($apply, 'berhasil get pendaftar yang belum dikonfirmasi');
    }

    public function reject($id)
    {
        $apply = Apply::where('user_id', $id)->first();
        $apply->status = 'Ditolak';
        $apply->save();
        StatusApplyJob::dispatch($apply->user, $apply->status);
        Cache::forget('pendaftar');
        return $this->successMessage("rejected", "user dengan id " . $apply->user->id . " berhasil direject");
    }
    public function konfirm($id)
    {
        $apply = Apply::where('user_id', $id)->first();
        $apply->status = 'lulus';
        $apply->save();
        StatusApplyJob::dispatch($apply->user, $apply->status);
        Cache::forget('pendaftar');
        return $this->successMessage("konfirmed", "user dengan id " . $apply->user->id . " berhasil dikonfirm");
    }
}
