<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Filme;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GaleriaController extends Controller
{
    /**
     * Galeria publica: destaque + prateleiras na home, ou grade filtrada.
     */
    public function index(Request $request): View
    {
        $ordenar = $request->input('ordenar', 'recentes');
        $temFiltro = $request->filled('categoria') || $request->filled('ano') || $request->filled('busca');

        $query = Filme::query()
            ->with(['categoria', 'usuario'])
            ->withAvg('avaliacoes as media_nota', 'nota')
            ->withCount('avaliacoes as total_avaliacoes')
            ->when($request->filled('categoria'), fn ($q) => $q->where('categoria_id', $request->integer('categoria')))
            ->when($request->filled('ano'), fn ($q) => $q->where('ano', $request->integer('ano')))
            ->when($request->filled('busca'), fn ($q) => $q->where('titulo', 'like', '%' . $request->input('busca') . '%'));

        match ($ordenar) {
            'avaliados' => $query->orderByDesc('media_nota')->orderByDesc('id'),
            'titulo' => $query->orderBy('titulo'),
            'ano' => $query->orderByDesc('ano'),
            default => $query->latest(),
        };

        $filmes = $query->paginate(12)->withQueryString();

        // Destaque e prateleiras aparecem apenas na home (sem filtros).
        $destaque = null;
        $melhores = collect();
        $recentes = collect();

        if (! $temFiltro) {
            $destaque = Filme::query()
                ->with(['categoria', 'usuario'])
                ->withAvg('avaliacoes as media_nota', 'nota')
                ->withCount('avaliacoes as total_avaliacoes')
                ->orderByDesc('media_nota')
                ->orderByDesc('id')
                ->first();

            $melhores = $this->prateleira()
                ->when($destaque, fn ($q) => $q->where('id', '!=', $destaque->id))
                ->orderByDesc('media_nota')
                ->orderByDesc('id')
                ->take(10)
                ->get();

            $recentes = $this->prateleira()->latest()->take(10)->get();
        }

        return view('galeria.index', [
            'filmes' => $filmes,
            'categorias' => Categoria::orderBy('nome')->get(),
            'anos' => Filme::query()->select('ano')->distinct()->orderByDesc('ano')->pluck('ano'),
            'filtros' => $request->only(['categoria', 'ano', 'busca', 'ordenar']),
            'temFiltro' => $temFiltro,
            'destaque' => $destaque,
            'melhores' => $melhores,
            'recentes' => $recentes,
        ]);
    }

    /**
     * Pagina de detalhes de um filme: trailer incorporado + avaliacoes.
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
            ->with('categoria')
            ->withAvg('avaliacoes as media_nota', 'nota')
            ->withCount('avaliacoes as total_avaliacoes')
            ->where('categoria_id', $filme->categoria_id)
            ->where('id', '!=', $filme->id)
            ->latest()
            ->take(5)
            ->get();

        return view('galeria.show', [
            'filme' => $filme,
            'avaliacoes' => $avaliacoes,
            'media' => $media,
            'minhaAvaliacao' => $minhaAvaliacao,
            'relacionados' => $relacionados,
        ]);
    }

    /**
     * Consulta base reutilizada pelas prateleiras da home.
     */
    private function prateleira()
    {
        return Filme::query()
            ->with('categoria')
            ->withAvg('avaliacoes as media_nota', 'nota')
            ->withCount('avaliacoes as total_avaliacoes');
    }
}
