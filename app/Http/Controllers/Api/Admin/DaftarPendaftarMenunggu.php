<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PendaftarMenunggu;
use App\Jobs\StatusApplyJob;
use App\Models\Apply;
use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DaftarPendaftarMenunggu extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::select('name', 'id', 'job_magang_id')->with('apply.carrer', 'lowongan')->whereHas('apply', function ($query) {
            $query->where('status', 'menunggu');
        });
        $tipe_magang = $request->tipe_magang;
        $query->when($request->has('tipe_magang'), function ($query) use ($tipe_magang) {
            return $query->whereHas('apply', function ($query2) use ($tipe_magang) {
                $query2->where('tipe_magang', $tipe_magang);
            });
        });

        $user = Cache::remember('user_', 300, function () use ($query) {
            return $query->get();
        });
        $data = new PendaftarMenunggu($user);
        return $this->successMessage($data, 'Berhasil get pendaftar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function reject($id)
    {
        $apply = Apply::where('user_id', $id)->first();
        $apply->status = 'Ditolak';
        $apply->save();
        StatusApplyJob::dispatch($apply->user, $apply->status);
        Cache::forget('user_');
        return $this->successMessage("rejected", "user dengan id " . $apply->user->id . " berhasil direject");
    }
    public function konfirm($id)
    {
        $apply = Apply::where('user_id', $id)->first();
        $apply->status = 'lulus';
        $apply->save();
        StatusApplyJob::dispatch($apply->user, $apply->status);
        Cache::forget('user_');
        return $this->successMessage("konfirmed", "user dengan id " . $apply->user->id . " berhasil dikonfirm");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $apply = Apply::where('user_id', $id)->first();
        $user = User::find($id);
        $kolompok_id = $user->kelompok_id;
        $user->kelompok_id = NULL;
        $user->job_magang_id = NULL;
        $user->jabatan = 0;
        $user->save();

        if ($apply->tipe_magang === "kelompok") {
            $kelompok = Kelompok::with('user')->where('id', $kolompok_id)->first();
            if ($kelompok->user->count() === 0) {
                $kelompok->delete();
            }
        }
        $apply->delete();

        return $this->successMessage($user->name . " apply berhasil dihapus", 'berhasil menghapus');
    }
}
