<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\backend\Tag::factory()->create([
            'name' => 'Laravel',
            'slug' => Str::slug('Laravel'),
        ]);
        \App\Models\backend\Tag::factory()->create([
            'name' => 'PHP',
            'slug' => Str::slug('PHP'),
        ]);
        \App\Models\backend\Tag::factory()->create([
            'name' => 'JavaScript',
            'slug' => Str::slug('JavaScript'),
        ]);
        \App\Models\backend\Tag::factory()->create([
            'name' => 'HTML',
            'slug' => Str::slug('HTML'),
        ]);
        \App\Models\backend\Tag::factory()->create([
            'name' => 'Tailwind CSS',
            'slug' => Str::slug('Tailwind CSS'),
        ]);
    }
}
