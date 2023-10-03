<?php

namespace Database\Factories;

use App\Models\Lowongan;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Carrer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lowongan>
 */
class LowonganFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Lowongan::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'carrer_id' => fake()->numberBetween(1, 100),
            'desc' => fake()->realTextBetween(50, 100),
            'benefit' => fake()->realTextBetween(30, 70),
            'kualifikasi' => fake()->realTextBetween(25, 40),
            'gambar' => fake()->imageUrl,
            // 'max_applay' => fake()->dateTime('now')
        ];
    }
}
