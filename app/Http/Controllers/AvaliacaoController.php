<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Filme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AvaliacaoController extends Controller
{
    /**
     * Registra (ou atualiza) a avaliacao do usuario logado para um filme.
     */
    public function store(Request $request, Filme $filme): RedirectResponse
    {
        $dados = $request->validate([
            'nota' => ['required', 'integer', 'min:1', 'max:5'],
            'comentario' => ['nullable', 'string', 'max:1000'],
        ]);

        Avaliacao::updateOrCreate(
            ['filme_id' => $filme->id, 'usuario_id' => auth()->id()],
            ['nota' => $dados['nota'], 'comentario' => $dados['comentario'] ?? null]
        );

        return redirect()
            ->route('galeria.show', $filme)
            ->with('sucesso', 'Sua avaliação foi registrada. Obrigado!');
    }
}
