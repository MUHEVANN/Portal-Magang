<?php

namespace Database\Seeders;

use App\Models\Apply;
use App\Models\Carrer;
use App\Models\CarrerUser;
use App\Models\Kelompok;
use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ApplyUser extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelompok = Kelompok::create([
            'name' => 'singa'
        ]);
        $kelompok2 = Kelompok::create([
            'name' => Str::random(4)
        ]);
        $user = User::create([
            'name' => 'saifullah',
            'email' => 'saiful@gmail.com',
            'password' => Hash::make('saiful'),
            'is_active' => '1',
            'jabatan' => 1
        ]);
        $user->addRole('client');
        $user2 = User::create([
            'name' => 'jamila',
            'email' => 'jamila@gmail.com',
            'password' => Hash::make('jamil'),
            'is_active' => '1',
            'kelompok_id' => $kelompok->id,
            'jabatan' => 0
        ]);
        $user2->addRole('client');
        $user3 = User::create([
            'name' => 'sri',
            'email' => 'sri@gmail.com',
            'password' => Hash::make('sri'),
            'is_active' => '1',
            'kelompok_id' => $kelompok->id,
            'jabatan' => 0
        ]);
        $user3->addRole('client');

        $carrer = Carrer::create([
            'batch' => "magang ke 12"
        ]);

        $job = Lowongan::create([
            'name' => 'Fron End Dev',
            'desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro eaque architecto accusamus facere maxime at magnam, unde incidunt, eum illum a fuga? Cum soluta ipsum velit laboriosam, illum fugit enim?',
            'benefit' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro eaque architecto accusamus facere maxime at magnam, unde incidunt, eum illum a fuga? Cum soluta ipsum velit laboriosam, illum fugit enim?',
            'kualifikasi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro eaque architecto accusamus facere maxime at magnam, unde incidunt, eum illum a fuga? Cum soluta ipsum velit laboriosam, illum fugit enim?',
            'gambar' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro eaque architecto accusamus facere maxime at magnam, unde incidunt, eum illum a fuga? Cum soluta ipsum velit laboriosam, illum fugit enim?',
            'max_applay' => now(),
        ]);
        $job = Lowongan::create([
            'name' => 'Fron End Dev',
            'desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro eaque architecto accusamus facere maxime at magnam, unde incidunt, eum illum a fuga? Cum soluta ipsum velit laboriosam, illum fugit enim?',
            'benefit' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro eaque architecto accusamus facere maxime at magnam, unde incidunt, eum illum a fuga? Cum soluta ipsum velit laboriosam, illum fugit enim?',
            'kualifikasi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro eaque architecto accusamus facere maxime at magnam, unde incidunt, eum illum a fuga? Cum soluta ipsum velit laboriosam, illum fugit enim?',
            'gambar' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro eaque architecto accusamus facere maxime at magnam, unde incidunt, eum illum a fuga? Cum soluta ipsum velit laboriosam, illum fugit enim?',
            'max_applay' => now(),
        ]);

        $carrer_user = Apply::create([
            'carrer_id' => $carrer->id,
            'lowongan_id' => $job->id,
            'kelompok_id' => $kelompok->id,
            'cv_user' => 'ini cv user',
            'status' => 'menunggu',
        ]);
        $carrer_user = Apply::create([
            'carrer_id' => $carrer->id,
            'lowongan_id' => $job->id,
            'kelompok_id' => $kelompok2->id,
            'cv_user' => 'ini cv user',
            'status' => 'menunggu',
        ]);
    }
}
