<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PendaftarMenunggu extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->resource as $user) {
            $data[] =  [
                'id' => $user->id,
                'name' => $user->name,
                'job' => $user->lowongan->name,
                'tipe_magang' => $user->apply->tipe_magang,
                'cv' => $user->apply->cv,
                'status' => $user->apply->status,
                'tgl_mulai' => $user->apply->tgl_mulai,
                'tgl_selesai' => $user->apply->tgl_selesai,

            ];
        }
        return $data;
    }
}
