<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PendaftarMenunggu;
use App\Jobs\StatusApplyJob;
use App\Models\Apply;
use App\Models\Kelompok;
use App\Models\Konfirmed;
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
        $query = Apply::with('lowongan', 'carrer')->where('status', 'menunggu');
        $tipe_magang = $request->tipe_magang;
        $query->when($request->has('tipe_magang'), function ($query) use ($tipe_magang) {
            return  $query->where('tipe_magang', $tipe_magang);;
        });

        $apply = Cache::remember('user_', 300, function () use ($query) {
            return $query->get();
        });
        $data = new PendaftarMenunggu($apply);
        return $this->successMessage($data, 'Berhasil get pendaftar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function reject($id)
    {
        $apply = Apply::find($id);
        $apply->status = 'Ditolak';
        $apply->save();
        $user = User::find($apply->user_id);
        Konfirmed::create([
            'user_id' => $user->id,
            'status' => $apply->status,
            'carrer_id' => $apply->carrer_id
        ]);
        StatusApplyJob::dispatch($apply->user, $apply->status);
        Cache::forget('user_');
        return $this->successMessage("rejected", "user dengan id " . $apply->user->id . " berhasil direject");
    }
    public function konfirm($id)
    {
        $apply = Apply::find($id);
        $apply->status = 'lulus';
        $apply->save();
        $user = User::find($apply->user_id);
        Konfirmed::create([
            'user_id' => $user->id,
            'status' => $apply->status,
            'carrer_id' => $apply->carrer_id
        ]);
        StatusApplyJob::dispatch($apply->user, $apply->status);
        Cache::forget('user_');
        return $this->successMessage("konfirmed", "user dengan id " . $apply->user->id . " berhasil dikonfirm");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $apply = Apply::find($id);
        $kelompok_id = $apply->kelompok_id;
        $kelompok = Kelompok::where('id', $kelompok_id)->first();
        if ($apply->tipe_magang === "kelompok") {
            $apply->delete();
            if ($kelompok->apply->count() < 1) {
                $kelompok->delete();
            }
        } else {
            $apply->delete();
        }

        Cache::forget('all-pemagang');

        return $this->successMessage($apply->id . " berhasil dihapus", 'berhasil menghapus');
    }
}
