<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserApply extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $data = [];
        // foreach ($this->collection as $item) {
        //     $data[] = [
        //         'id' => $item->id,
        //         'name' => $item->name,
        //         'email' => $item->email,
        //     ];
        // }
        return [
            'data' => [
                'name' => $this->resource->name,
                'email' => $this->resource->email,
                'tipe_magang' => $this->resource->tipe_magang,
            ]
        ];
    }
}
