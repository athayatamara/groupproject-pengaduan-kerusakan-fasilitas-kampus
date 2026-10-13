<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan penting: data master dulu, baru laporan
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            LocationSeeder::class,
            ReportSeeder::class,
        ]);
    }
}
