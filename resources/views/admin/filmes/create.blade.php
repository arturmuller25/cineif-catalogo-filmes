@extends('layouts.app')

@section('titulo', 'Novo filme')

@section('conteudo')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('admin.filmes.index') }}" class="mb-4 inline-block text-sm text-zinc-400 hover:text-amber-400">Voltar</a>
        <h1 class="mb-6 text-2xl font-extrabold tracking-tight">Cadastrar filme</h1>

        <form method="POST" action="{{ route('admin.filmes.store') }}" enctype="multipart/form-data"
              class="rounded-2xl border border-zinc-800 bg-zinc-900/50 p-6">
            @csrf
            @include('admin.filmes._campos')

            <div class="mt-6 flex justify-end gap-2">
                <a href="{{ route('admin.filmes.index') }}"
                   class="rounded-lg border border-zinc-700 px-4 py-2 text-sm text-zinc-300 transition hover:bg-zinc-800">
                    Cancelar
                </a>
                <button type="submit"
                        class="rounded-lg bg-amber-400 px-5 py-2 text-sm font-semibold text-zinc-900 transition hover:bg-amber-300">
                    Cadastrar filme
                </button>
            </div>
        </form>
    </div>
@endsection
