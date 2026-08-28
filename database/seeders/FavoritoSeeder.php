<?php

namespace Database\Seeders;

use App\Models\Filme;
use App\Models\User;
use Illuminate\Database\Seeder;

class FavoritoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@cineif.test')->first();
        $maria = User::where('email', 'maria@cineif.test')->first();

        if ($admin) {
            $admin->favoritos()->syncWithoutDetaching(
                Filme::whereIn('titulo', ['Interestelar', 'Parasita', 'Corra!'])->pluck('id')
            );
        }

        if ($maria) {
            $maria->favoritos()->syncWithoutDetaching(
                Filme::whereIn('titulo', ['A Origem', 'Blade Runner 2049'])->pluck('id')
            );
        }
    }
}
