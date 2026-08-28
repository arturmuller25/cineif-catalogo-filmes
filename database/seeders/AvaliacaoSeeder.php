<?php

namespace Database\Seeders;

use App\Models\Avaliacao;
use App\Models\Filme;
use App\Models\User;
use Illuminate\Database\Seeder;

class AvaliacaoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@cineif.test')->value('id');
        $maria = User::where('email', 'maria@cineif.test')->value('id');

        if (! $admin || ! $maria) {
            return;
        }

        $comentarios = [
            'Excelente do começo ao fim, recomendo demais.',
            'Roteiro muito bem amarrado e trilha marcante.',
            'Um clássico que envelhece muito bem.',
            'Fotografia impecável, vale cada minuto.',
            'Gostei bastante, assistiria de novo.',
        ];

        foreach (Filme::all()->values() as $i => $filme) {
            Avaliacao::updateOrCreate(
                ['filme_id' => $filme->id, 'usuario_id' => $admin],
                ['nota' => 4 + ($i % 2), 'comentario' => $comentarios[$i % count($comentarios)]]
            );

            Avaliacao::updateOrCreate(
                ['filme_id' => $filme->id, 'usuario_id' => $maria],
                ['nota' => 3 + ($i % 3), 'comentario' => ($i % 2 === 0) ? 'Muito bom.' : null]
            );
        }
    }
}
