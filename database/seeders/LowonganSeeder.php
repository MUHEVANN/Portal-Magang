<?php

namespace Database\Seeders;

use App\Models\Lowongan;
use Database\Factories\LowonganFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LowonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lowongan::factory()->count(12)->create();
    }
}
