<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Filme;
use Illuminate\View\View;

class PainelController extends Controller
{
    /**
     * Painel do administrador com estatisticas e o ultimo filme cadastrado
     * pelo usuario (demonstra a relacao hasOne).
     */
    public function index(): View
    {
        $usuario = auth()->user();

        return view('admin.painel', [
            'totalFilmes' => Filme::count(),
            'totalCategorias' => Categoria::count(),
            'meusFilmes' => Filme::where('usuario_id', $usuario->id)->count(),
            'ultimoFilme' => $usuario->ultimoFilme, // relacao hasOne (latestOfMany)
            'recentes' => Filme::with('categoria')->latest()->take(5)->get(),
        ]);
    }
}
