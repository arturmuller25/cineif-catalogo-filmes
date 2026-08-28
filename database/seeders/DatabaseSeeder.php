<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios de demonstracao (autores dos filmes).
        User::updateOrCreate(
            ['email' => 'admin@cineif.test'],
            ['name' => 'Administrador', 'password' => Hash::make('password')]
        );

        User::updateOrCreate(
            ['email' => 'maria@cineif.test'],
            ['name' => 'Maria Souza', 'password' => Hash::make('password')]
        );

        $this->call([
            CategoriaSeeder::class,
            FilmeSeeder::class,
            AvaliacaoSeeder::class,
        ]);
    }
}
