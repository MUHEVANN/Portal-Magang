<?php

namespace Database\Factories;

use App\Models\Kelompok;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apply>
 */
class ApplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kelompok = Kelompok::get();
        for ($i = 0; $i < count($kelompok); $i++) {
            return [
                'carrer_id' => 2,
                'kelompok_id' => $i,
                'cv' => 'ssadaw',
                'status' => 'menunggu',
            ];
        }
    }
}