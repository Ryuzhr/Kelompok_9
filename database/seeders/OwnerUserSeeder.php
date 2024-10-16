<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class OwnerUserSeeder extends Seeder
{
    public function run()
    {
        // Buat user owner
        User::create([
            'name' => 'Owner Name',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('password123'), // Gantilah password sesuai keinginan
            'role' => 'owner', // Set peran sebagai owner
        ]);
    }
}