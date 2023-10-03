<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'job_magang_id' => $this->job_magang_id === null ? 'Tidak ada Job' : $this->lowongan->name,
            'gender' => $this->gender,
            'alamat' => $this->alamat,
            'no_hp' => $this->no_hp,
            'profile_image' => $this->profile_image,
        ];
    }
}
