<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder {

    public function run(): void {
        // for ($i = 0; $i < 50; $i++) {
        //     $titulo = fake()->sentence;
        //     \App\Models\post\Post::factory()->create([
        //         'titulo' => $titulo,
        //         'slug' => Str::slug($titulo),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
        // Crear 50 posts con el factory
        \App\Models\post\Post::factory(50)->withCustomTitle()->create();
    }
}