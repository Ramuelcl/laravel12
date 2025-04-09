<?php

namespace Database\Factories\post;

use App\Models\post\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory {

    public function definition(): array {

        return [
            // 'titulo' => $this->faker->words(3, true), // Genera un título de 3 palabras
            'titulo' => Str::limit($this->faker->sentence, 97),
            'slug' => fn(array $attributes) => Str::slug($attributes['titulo']), // Usa una función anónima
            'content' => $this->faker->paragraph,
            'user_id' => \App\Models\User::take(10)->pluck('id')->random(),
            'category_id' => \App\Models\backend\Category::take(3)->pluck('id')->random(),
            'image_path' => $this->faker->imageUrl(640, 480, 'cats'),
            'is_active' => $this->faker->boolean(80),
            'state' => $this->faker->randomElement(['draft', 'published']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function withCustomTitle() {
        return $this->state(function () {
            $titulo = ucwords(Str::limit($this->faker->words(3, true), 97));
            dump($titulo);
            return [
                'titulo' => $titulo,
                'slug' => Str::slug($titulo)
            ];
        });
    }
}