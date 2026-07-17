<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sekawan Makmur',
            'email' => 'admin@sekawanmakmur.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi@sekawanmakmur.com',
            'password' => Hash::make('password'),
            'role' => 'content',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@sekawanmakmur.com',
            'password' => Hash::make('password'),
            'role' => 'content',
        ]);
    }
}