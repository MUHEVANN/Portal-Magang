<?php

namespace Database\Seeders;

use App\Models\Kelompok;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::create([
            'name' => "Admin",
            'email' => "Admin@gmail.com",
            'password' => Hash::make("password"),
            'is_active' => "1",
        ]);
        $user->addRole('admin');

        Kelompok::create([
            'name' => 'Mandiri'
        ]);
    }
}
