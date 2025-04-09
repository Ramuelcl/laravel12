<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Esto eliminaría todos los usuarios antes de crear nuevos
        // User::truncate(); // <-- Si existe esta línea, coméntala o elimínala
        
        // Crea un usuario específico
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // Crea 50 usuarios adicionales
        User::factory()->count(50)->create();
    }
}
