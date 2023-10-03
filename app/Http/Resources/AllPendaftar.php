<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllPendaftar extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->resource as $apply) {
            $data[] = [
                'id' => $apply->id,
                'name' => $apply->user->name,
                'job' => $apply->user->lowongan->name,
                'tipe_magang' => $apply->tipe_magang,
                'batch' => $apply->carrer->batch,
                'status' => $apply->status
            ];
        }
        return $data;
    }
}
