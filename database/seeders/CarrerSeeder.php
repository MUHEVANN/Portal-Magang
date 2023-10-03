<?php

namespace Database\Seeders;

use App\Models\Carrer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarrerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Carrer::factory()->count(100)->create();
    }
}
