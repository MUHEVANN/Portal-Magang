<?php

namespace Database\Seeders;

use App\Models\Kelompok as ModelsKelompok;
use Illuminate\Database\Seeder;

class Kelompok extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsKelompok::factory()->count(100)->create();
    }
}
