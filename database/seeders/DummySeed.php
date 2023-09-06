<?php

namespace Database\Seeders;

use App\Models\ApplyJob;
use App\Models\Carrer;
use App\Models\CarrerUser;
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
        $job = Lowongan::create([
            'name' => 'Font End',
            'desc' => 'Lowongan mangang untuk bagaian fe atau ui aplikasi',
            'benefit' => 'mendapatkan sertifikat, mendapatkan ilmu',
            'kualifikasi' => 'Sehat Jasmani dan rohano, bersedia melakukan magang onsite, mengerti Html ,css, js, bisa menconsume Api',
            'gambar' => '01293.jpg',
            'max_applay' => '01-02-24',
        ]);
        $carrer = Carrer::create([
            'batch' => 1
        ]);
        CarrerUser::create([
            'carrer_id' => $carrer->id,
            'user_id' => 1,
            'lowongan_id' => $job->id,
            'cv-user' => '21213.pdf',
            'nama_kelompok' => 'macan'
        ]);
        CarrerUser::create([
            'carrer_id' => $carrer->id,
            'user_id' => 2,
            'lowongan_id' => $job->id,
            'cv-user' => '21213.pdf',
            'nama_kelompok' => 'macan'
        ]);
    }
}
