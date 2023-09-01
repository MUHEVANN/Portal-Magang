<?php

namespace Database\Seeders;

use App\Models\ApplyJob;
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
        $user = User::create([
            'name' => "user",
            'email' => "user@gmail.com",
            'password' => Hash::make("password"),
            'is_active' => "1"
        ]);
        $user->addRole('client');
        $user2 = User::create([
            'name' => "evan",
            'email' => "evan@gmail.com",
            'password' => Hash::make("password"),
            'is_active' => "1"
        ]);
        $user2->addRole('client');
        $job = Lowongan::create([
            'name' => 'Font End',
            'desc' => 'Lowongan mangang untuk bagaian fe atau ui aplikasi',
            'benefit' => 'mendapatkan sertifikat, mendapatkan ilmu',
            'kualifikasi' => 'Sehat Jasmani dan rohano, bersedia melakukan magang onsite, mengerti Html ,css, js, bisa menconsume Api',
            'gambar' => '01293.jpg',
            'max_applay' => '01-02-24',
        ]);

        ApplyJob::create([
            'user_id' => $user->id,
            'lowongan_id' => $job->id,
            'cv' => '21213.pdf',
            'start' => '01-02-24',
            'end' => '01-05-24',
            'alamat' => 'klaten',
            'pendidikan' => 'kuliah',
            'sekolah' => 'Universitas Amikom Yogyakarta',
            'portofolio_url' => 'www.google.com',
            'ig_url' => 'www.google.com',
            'linkedin_url' => 'www.google.com',
            'gender' => 'L',
            'alasan' => 'menambah wawasan dibisang fe',
        ]);
        ApplyJob::create([
            'user_id' => $user2->id,
            'lowongan_id' => $job->id,
            'cv' => '21213.pdf',
            'start' => '01-02-24',
            'end' => '01-05-24',
            'alamat' => 'klaten',
            'pendidikan' => 'kuliah',
            'sekolah' => 'Universitas Amikom Yogyakarta',
            'portofolio_url' => 'www.google.com',
            'ig_url' => 'www.google.com',
            'linkedin_url' => 'www.google.com',
            'gender' => 'L',
            'alasan' => 'menambah wawasan dibisang fe',
            'konfirmasi' => 'lulus',
        ]);
    }
}
