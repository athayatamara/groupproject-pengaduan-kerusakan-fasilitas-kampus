<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Gedung A', 'Gedung B', 'Lab Komputer 1', 'Perpustakaan', 'Kantin', 'Masjid Kampus'] as $name) {
            Location::create(['name' => $name]);
        }
    }
}
