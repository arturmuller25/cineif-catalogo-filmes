<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FavoritoController extends Controller
{
    /**
     * Lista os filmes favoritados pelo usuario logado.
     */
    public function index(): View
    {
        $filmes = auth()->user()->favoritos()
            ->with('categoria')
            ->withAvg('avaliacoes as media_nota', 'nota')
            ->withCount('avaliacoes as total_avaliacoes')
            ->orderByDesc('favoritos.created_at')
            ->paginate(12);

        return view('favoritos.index', compact('filmes'));
    }

    /**
     * Adiciona ou remove um filme dos favoritos (toggle da relacao N:N).
     */
    public function toggle(Filme $filme): RedirectResponse
    {
        $resultado = auth()->user()->favoritos()->toggle($filme->id);
        $adicionado = ! empty($resultado['attached']);

        return back()->with(
            'sucesso',
            $adicionado ? 'Filme adicionado aos favoritos.' : 'Filme removido dos favoritos.'
        );
    }
}
