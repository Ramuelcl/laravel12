<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\backend\Category::factory()->create([
            'name' => 'Diseño Web',
            'slug' => Str::slug('Diseño Web'),
        ]);
        \App\Models\backend\Category::factory()->create([
            'name' => 'Desarrollo Web',
            'slug' => Str::slug('Desarrollo Web'),
        ]);
        \App\Models\backend\Category::factory()->create([
            'name' => 'Programación',
            'slug' => Str::slug('Programación'),
        ]);
    }
}
