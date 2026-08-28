<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Filme;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GaleriaController extends Controller
{
    /**
     * Galeria publica com filtragem por ano, categoria e busca por titulo.
     */
    public function index(Request $request): View
    {
        $filmes = Filme::query()
            ->with(['categoria', 'usuario'])
            ->withAvg('avaliacoes as media_nota', 'nota')
            ->withCount('avaliacoes as total_avaliacoes')
            ->when($request->filled('categoria'), fn ($q) => $q->where('categoria_id', $request->integer('categoria')))
            ->when($request->filled('ano'), fn ($q) => $q->where('ano', $request->integer('ano')))
            ->when($request->filled('busca'), fn ($q) => $q->where('titulo', 'like', '%' . $request->input('busca') . '%'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('galeria.index', [
            'filmes' => $filmes,
            'categorias' => Categoria::orderBy('nome')->get(),
            'anos' => Filme::query()->select('ano')->distinct()->orderByDesc('ano')->pluck('ano'),
            'filtros' => $request->only(['categoria', 'ano', 'busca']),
        ]);
    }

    /**
     * Pagina de detalhes de um filme: trailer incorporado + avaliacoes (estilo IMDb).
     */
    public function show(Filme $filme): View
    {
        $filme->load(['categoria', 'usuario']);

        $avaliacoes = $filme->avaliacoes()->with('usuario')->latest()->get();
        $media = round((float) $avaliacoes->avg('nota'), 1);
        $minhaAvaliacao = auth()->check()
            ? $avaliacoes->firstWhere('usuario_id', auth()->id())
            : null;

        $relacionados = Filme::query()
            ->where('categoria_id', $filme->categoria_id)
            ->where('id', '!=', $filme->id)
            ->latest()
            ->take(4)
            ->get();

        return view('galeria.show', [
            'filme' => $filme,
            'avaliacoes' => $avaliacoes,
            'media' => $media,
            'minhaAvaliacao' => $minhaAvaliacao,
            'relacionados' => $relacionados,
        ]);
    }
}
