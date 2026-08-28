<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Filme;
use App\Models\User;
use Illuminate\Database\Seeder;

class FilmeSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = Categoria::pluck('id', 'nome');
        $usuarios = User::pluck('id', 'email');

        $admin = $usuarios['admin@cineif.test'] ?? User::query()->value('id');
        $maria = $usuarios['maria@cineif.test'] ?? $admin;

        $filmes = [
            [
                'titulo' => 'Interestelar',
                'categoria' => 'Ficção Científica',
                'ano' => 2014,
                'usuario_id' => $admin,
                'capa' => 'posters/interstellar.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=Lm8p5rlrSkY',
                'sinopse' => 'Com a Terra à beira do colapso, um grupo de exploradores atravessa um buraco de minhoca em busca de um novo lar para a humanidade.',
            ],
            [
                'titulo' => 'A Origem',
                'categoria' => 'Ficção Científica',
                'ano' => 2010,
                'usuario_id' => $admin,
                'capa' => 'posters/inception.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=8hP9D6kZseM',
                'sinopse' => 'Um ladrão especializado em roubar segredos do subconsciente recebe a missão inversa: implantar uma ideia na mente de um alvo.',
            ],
            [
                'titulo' => 'Blade Runner 2049',
                'categoria' => 'Ficção Científica',
                'ano' => 2017,
                'usuario_id' => $maria,
                'capa' => 'posters/bladerunner2049.png',
                'trailer_url' => 'https://www.youtube.com/watch?v=gCcx85zbxz4',
                'sinopse' => 'Um jovem blade runner descobre um segredo enterrado que pode mergulhar o que restou da sociedade no caos.',
            ],
            [
                'titulo' => 'Mad Max: Estrada da Fúria',
                'categoria' => 'Ação',
                'ano' => 2015,
                'usuario_id' => $admin,
                'capa' => 'posters/madmax.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=hEJnMQG9ev8',
                'sinopse' => 'Em um deserto pós-apocalíptico, Max une forças com Furiosa para fugir de um tirano em uma perseguição implacável.',
            ],
            [
                'titulo' => 'Batman: O Cavaleiro das Trevas',
                'categoria' => 'Ação',
                'ano' => 2008,
                'usuario_id' => $maria,
                'capa' => 'posters/darkknight.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=EXeTwQWrcwY',
                'sinopse' => 'Batman enfrenta o Coringa, um criminoso caótico decidido a mergulhar Gotham City na anarquia.',
            ],
            [
                'titulo' => 'O Senhor dos Anéis: A Sociedade do Anel',
                'categoria' => 'Aventura',
                'ano' => 2001,
                'usuario_id' => $admin,
                'capa' => 'posters/lotr.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=V75dMMIW2B4',
                'sinopse' => 'Um jovem hobbit herda um anel poderoso e parte em uma jornada para destruí-lo antes que caia nas mãos do mal.',
            ],
            [
                'titulo' => 'O Grande Hotel Budapeste',
                'categoria' => 'Comédia',
                'ano' => 2014,
                'usuario_id' => $maria,
                'capa' => 'posters/budapest.png',
                'trailer_url' => 'https://www.youtube.com/watch?v=GHJ7SMvfxoY',
                'sinopse' => 'As aventuras de um lendário concierge e seu jovem protegido em um famoso hotel europeu entre as guerras.',
            ],
            [
                'titulo' => 'Um Sonho de Liberdade',
                'categoria' => 'Drama',
                'ano' => 1994,
                'usuario_id' => $admin,
                'capa' => 'posters/shawshank.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=NmzuHjWmXOc',
                'sinopse' => 'Condenado injustamente, um bancário mantém a esperança e a amizade ao longo de anos na prisão de Shawshank.',
            ],
            [
                'titulo' => 'Parasita',
                'categoria' => 'Suspense',
                'ano' => 2019,
                'usuario_id' => $maria,
                'capa' => 'posters/parasite.png',
                'trailer_url' => 'https://www.youtube.com/watch?v=5xH0HfJHsaY',
                'sinopse' => 'Uma família pobre se infiltra aos poucos na rotina de uma família rica, até que um segredo ameaça desfazer tudo.',
            ],
            [
                'titulo' => 'Corra!',
                'categoria' => 'Terror',
                'ano' => 2017,
                'usuario_id' => $admin,
                'capa' => 'posters/getout.png',
                'trailer_url' => 'https://www.youtube.com/watch?v=DzfpyUB60YY',
                'sinopse' => 'Um rapaz visita a família da namorada e descobre uma verdade perturbadora por trás da hospitalidade excessiva.',
            ],
            [
                'titulo' => 'Homem-Aranha no Aranhaverso',
                'categoria' => 'Animação',
                'ano' => 2018,
                'usuario_id' => $maria,
                'capa' => 'posters/spiderverse.png',
                'trailer_url' => 'https://www.youtube.com/watch?v=g4Hbz2jLxvQ',
                'sinopse' => 'O adolescente Miles Morales assume o manto do Homem-Aranha e cruza caminhos com heróis de outras dimensões.',
            ],
            [
                'titulo' => 'Viva: A Vida é uma Festa',
                'categoria' => 'Animação',
                'ano' => 2017,
                'usuario_id' => $admin,
                'capa' => 'posters/coco.jpg',
                'trailer_url' => 'https://www.youtube.com/watch?v=xlnPHQ3TLX8',
                'sinopse' => 'Apaixonado por música, o menino Miguel embarca em uma jornada mágica pela Terra dos Mortos em busca de suas raízes.',
            ],
        ];

        foreach ($filmes as $filme) {
            Filme::updateOrCreate(
                ['titulo' => $filme['titulo']],
                [
                    'usuario_id' => $filme['usuario_id'],
                    'categoria_id' => $categorias[$filme['categoria']],
                    'sinopse' => $filme['sinopse'],
                    'ano' => $filme['ano'],
                    'trailer_url' => $filme['trailer_url'],
                    'imagem_capa' => $filme['capa'],
                ]
            );
        }
    }
}
