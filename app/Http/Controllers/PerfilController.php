<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PerfilController extends Controller
{
    /**
     * Perfil do usuario: filmes que cadastrou e avaliacoes que fez.
     */
    public function index(): View
    {
        $usuario = auth()->user();

        $meusFilmes = $usuario->filmes()
            ->with('categoria')
            ->withAvg('avaliacoes as media_nota', 'nota')
            ->withCount('avaliacoes as total_avaliacoes')
            ->latest()
            ->get();

        $minhasAvaliacoes = $usuario->avaliacoes()
            ->with('filme')
            ->latest()
            ->get();

        return view('perfil.index', [
            'usuario' => $usuario,
            'meusFilmes' => $meusFilmes,
            'minhasAvaliacoes' => $minhasAvaliacoes,
            'totalFavoritos' => $usuario->favoritos()->count(),
        ]);
    }
}
