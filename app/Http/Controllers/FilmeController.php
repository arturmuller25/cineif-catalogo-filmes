<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Filme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FilmeController extends Controller
{
    /**
     * Listagem de filmes com opcoes de editar e excluir.
     */
    public function index(): View
    {
        $filmes = Filme::with(['categoria', 'usuario'])->latest()->paginate(10);

        return view('admin.filmes.index', compact('filmes'));
    }

    /**
     * Formulario de insercao de filme.
     */
    public function create(): View
    {
        return view('admin.filmes.create', [
            'filme' => new Filme(),
            'categorias' => Categoria::orderBy('nome')->get(),
        ]);
    }

    /**
     * Grava um novo filme, associando o usuario logado (chave estrangeira).
     */
    public function store(Request $request): RedirectResponse
    {
        $dados = $this->validar($request);
        $dados['usuario_id'] = auth()->id();

        if ($request->hasFile('imagem_capa')) {
            $dados['imagem_capa'] = $request->file('imagem_capa')->store('capas', 'public');
        }

        Filme::create($dados);

        return redirect()->route('admin.filmes.index')->with('sucesso', 'Filme cadastrado com sucesso.');
    }

    /**
     * Formulario de edicao.
     */
    public function edit(Filme $filme): View
    {
        return view('admin.filmes.edit', [
            'filme' => $filme,
            'categorias' => Categoria::orderBy('nome')->get(),
        ]);
    }

    /**
     * Atualiza um filme existente.
     */
    public function update(Request $request, Filme $filme): RedirectResponse
    {
        $dados = $this->validar($request);

        // Nao sobrescreve a capa existente quando nenhum arquivo novo e enviado.
        unset($dados['imagem_capa']);

        if ($request->hasFile('imagem_capa')) {
            $this->apagarCapa($filme);
            $dados['imagem_capa'] = $request->file('imagem_capa')->store('capas', 'public');
        }

        $filme->update($dados);

        return redirect()->route('admin.filmes.index')->with('sucesso', 'Filme atualizado com sucesso.');
    }

    /**
     * Move o filme para a lixeira (soft delete).
     */
    public function destroy(Filme $filme): RedirectResponse
    {
        $filme->delete();

        return redirect()->route('admin.filmes.index')->with('sucesso', 'Filme movido para a lixeira.');
    }

    /**
     * Lista os filmes na lixeira.
     */
    public function lixeira(): View
    {
        $filmes = Filme::onlyTrashed()
            ->with(['categoria', 'usuario'])
            ->orderByDesc('deleted_at')
            ->paginate(10);

        return view('admin.lixeira', compact('filmes'));
    }

    /**
     * Restaura um filme da lixeira.
     */
    public function restaurar(Filme $filme): RedirectResponse
    {
        $filme->restore();

        return redirect()->route('admin.filmes.lixeira')->with('sucesso', 'Filme restaurado com sucesso.');
    }

    /**
     * Exclui um filme definitivamente (e remove a capa do storage).
     */
    public function forcarExclusao(Filme $filme): RedirectResponse
    {
        $this->apagarCapa($filme);
        $filme->forceDelete();

        return redirect()->route('admin.filmes.lixeira')->with('sucesso', 'Filme excluído definitivamente.');
    }

    /**
     * Regras de validacao compartilhadas entre insercao e edicao.
     */
    private function validar(Request $request): array
    {
        return $request->validate([
            'categoria_id' => ['required', 'exists:categorias,id'],
            'titulo' => ['required', 'string', 'max:255'],
            'sinopse' => ['required', 'string'],
            'ano' => ['required', 'integer', 'min:1888', 'max:' . (date('Y') + 5)],
            'imagem_capa' => ['nullable', 'image', 'max:4096'],
            'trailer_url' => ['nullable', 'url', 'max:255'],
        ]);
    }

    /**
     * Remove a capa do storage caso seja um arquivo local.
     */
    private function apagarCapa(Filme $filme): void
    {
        if ($filme->imagem_capa && ! str_starts_with($filme->imagem_capa, 'http')) {
            Storage::disk('public')->delete($filme->imagem_capa);
        }
    }
}
