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
        Kelompok::create([
            'name' => 'tidak ada'
        ]);
        Lowongan::create([
            'name' => 'kosong',
            'desc' => 'tidak ada job',
            'kualifikasi' => 'tidak ada',
            'gambar' => 'tidak ada',
            'benefit' => 'tidak ada',
        ]);
    }
}
