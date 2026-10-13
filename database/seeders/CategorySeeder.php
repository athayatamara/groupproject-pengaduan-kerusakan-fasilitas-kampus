<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Ruang kelas', 'Proyektor', 'AC', 'Toilet', 'Internet', 'Listrik', 'Lainnya'] as $name) {
            Category::create(['name' => $name]);
        }
    }
}
