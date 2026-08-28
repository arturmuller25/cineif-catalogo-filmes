@extends('layouts.app')

@section('titulo', 'Meu perfil')

@section('conteudo')
    <div class="mb-8 flex flex-wrap items-center gap-4">
        <div class="grid h-16 w-16 place-items-center rounded-full bg-brand-400 text-2xl font-extrabold text-zinc-900">
            {{ mb_strtoupper(mb_substr($usuario->name, 0, 1)) }}
        </div>
        <div>
            <h1 class="text-2xl font-extrabold uppercase tracking-tight">{{ $usuario->name }}</h1>
            <p class="text-sm text-zinc-400">{{ $usuario->email }}</p>
        </div>
    </div>

    <div class="mb-10 grid grid-cols-3 gap-4">
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/50 p-5">
            <p class="text-sm text-zinc-400">Filmes cadastrados</p>
            <p class="mt-1 text-3xl font-extrabold text-brand-400">{{ $meusFilmes->count() }}</p>
        </div>
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/50 p-5">
            <p class="text-sm text-zinc-400">Avaliações feitas</p>
            <p class="mt-1 text-3xl font-extrabold text-brand-400">{{ $minhasAvaliacoes->count() }}</p>
        </div>
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/50 p-5">
            <p class="text-sm text-zinc-400">Favoritos</p>
            <p class="mt-1 text-3xl font-extrabold text-brand-400">{{ $totalFavoritos }}</p>
        </div>
    </div>

    {{-- Filmes cadastrados --}}
    <section class="mb-12">
        <h2 class="mb-4 text-lg font-bold">Filmes que cadastrei</h2>
        @if ($meusFilmes->isEmpty())
            <div class="rounded-2xl border border-dashed border-zinc-800 py-12 text-center text-sm text-zinc-500">
                Você ainda não cadastrou filmes.
                <a href="{{ route('admin.filmes.create') }}" class="text-brand-400 hover:underline">Cadastrar agora</a>.
            </div>
        @else
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($meusFilmes as $filme)
                    @include('partials.filme_card')
                @endforeach
            </div>
        @endif
    </section>

    {{-- Minhas avaliacoes --}}
    <section>
        <h2 class="mb-4 text-lg font-bold">Minhas avaliações</h2>
        @if ($minhasAvaliacoes->isEmpty())
            <div class="rounded-2xl border border-dashed border-zinc-800 py-12 text-center text-sm text-zinc-500">
                Você ainda não avaliou nenhum filme.
            </div>
        @else
            <div class="space-y-3">
                @foreach ($minhasAvaliacoes as $avaliacao)
                    <div class="rounded-xl border border-zinc-800 bg-zinc-900/30 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <a href="{{ route('galeria.show', $avaliacao->filme) }}" class="font-semibold text-zinc-100 hover:text-brand-400">
                                {{ $avaliacao->filme->titulo ?? 'Filme removido' }}
                            </a>
                            @include('partials.estrelas', ['nota' => $avaliacao->nota, 'tamanho' => 'h-4 w-4'])
                        </div>
                        @if ($avaliacao->comentario)
                            <p class="mt-2 text-sm text-zinc-300">{{ $avaliacao->comentario }}</p>
                        @endif
                        <p class="mt-2 text-xs text-zinc-500">{{ $avaliacao->created_at->diffForHumans() }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
