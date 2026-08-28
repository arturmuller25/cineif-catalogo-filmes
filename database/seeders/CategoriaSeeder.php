<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Ação',
            'Animação',
            'Aventura',
            'Comédia',
            'Documentário',
            'Drama',
            'Ficção Científica',
            'Romance',
            'Suspense',
            'Terror',
        ];

        foreach ($categorias as $nome) {
            Categoria::updateOrCreate(['nome' => $nome]);
        }
    }
}
