<?php

namespace Database\Seeders;

use App\Models\ApplyJob;
use App\Models\Carrer;
use App\Models\CarrerUser;
use App\Models\Kelompok;
use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $batch = Carrer::create([
            'batch' => 'tidak ada'
        ]);
        User::factory()->count(1000)->create();
    }
}