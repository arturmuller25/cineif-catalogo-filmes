<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Disponibiliza para as telas com cards a lista de ids dos filmes
        // favoritados pelo usuario logado (para marcar o botao de favorito).
        View::composer(
            ['galeria.index', 'galeria.show', 'favoritos.index', 'perfil.index'],
            function ($view) {
                $ids = Auth::check()
                    ? Auth::user()->favoritos()->pluck('filmes.id')->all()
                    : [];

                $view->with('favoritados', $ids);
            }
        );
    }
}
