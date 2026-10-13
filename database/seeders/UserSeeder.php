<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun admin dibuat melalui seeder (sesuai proposal)
        User::create([
            'name' => 'Admin Sarpras',
            'email' => 'admin@kampus.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Athaya Layla Athif',
            'email' => 'athaya@kampus.test',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'identity_number' => '202400001', // NIM contoh
            'phone' => '081234567890',
        ]);

        User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'budi@kampus.test',
            'password' => Hash::make('password'),
            'role' => 'dosen_tendik',
            'identity_number' => '0612345678', // NIDN contoh
            'phone' => '081234567891',
        ]);
    }
}
