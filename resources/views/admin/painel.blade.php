@extends('layouts.app')

@section('titulo', 'Painel')

@section('conteudo')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">Painel</h1>
            <p class="mt-1 text-zinc-400">Olá, {{ auth()->user()->name }}. Gerencie o catálogo por aqui.</p>
        </div>
        <a href="{{ route('admin.filmes.create') }}"
           class="rounded-lg bg-brand-400 px-4 py-2 text-sm font-semibold text-zinc-900 transition hover:bg-brand-300">
            + Cadastrar filme
        </a>
    </div>

    {{-- Estatisticas --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/50 p-5">
            <p class="text-sm text-zinc-400">Total de filmes</p>
            <p class="mt-1 text-3xl font-extrabold text-brand-400">{{ $totalFilmes }}</p>
        </div>
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/50 p-5">
            <p class="text-sm text-zinc-400">Categorias</p>
            <p class="mt-1 text-3xl font-extrabold text-brand-400">{{ $totalCategorias }}</p>
        </div>
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/50 p-5">
            <p class="text-sm text-zinc-400">Cadastrados por você</p>
            <p class="mt-1 text-3xl font-extrabold text-brand-400">{{ $meusFilmes }}</p>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Ultimo filme (relacao hasOne) --}}
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/50 p-5">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-400">Seu último cadastro</h2>
            @if ($ultimoFilme)
                <a href="{{ route('galeria.show', $ultimoFilme) }}" class="mt-3 flex items-center gap-4 group">
                    @php $capa = $ultimoFilme->capaUrl(); @endphp
                    <div class="h-24 w-16 shrink-0 overflow-hidden rounded-lg border border-zinc-800">
                        @if ($capa)
                            <img src="{{ $capa }}" alt="" class="h-full w-full object-cover">
                        @else
                            <div class="h-full w-full" style="background-color: {{ $ultimoFilme->corPlaceholder() }};"></div>
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold text-zinc-100 group-hover:text-brand-400">{{ $ultimoFilme->titulo }}</p>
                        <p class="text-sm text-zinc-500">{{ $ultimoFilme->categoria->nome ?? '-' }} · {{ $ultimoFilme->ano }}</p>
                        <p class="mt-1 text-xs text-zinc-500">{{ $ultimoFilme->created_at->diffForHumans() }}</p>
                    </div>
                </a>
            @else
                <p class="mt-3 text-sm text-zinc-500">Você ainda não cadastrou nenhum filme.</p>
            @endif
        </div>

        {{-- Recentes --}}
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/50 p-5">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-zinc-400">Adicionados recentemente</h2>
            @if ($recentes->isEmpty())
                <p class="mt-3 text-sm text-zinc-500">Nenhum filme cadastrado ainda.</p>
            @else
                <ul class="mt-3 divide-y divide-zinc-800">
                    @foreach ($recentes as $filme)
                        <li class="flex items-center justify-between gap-3 py-2 text-sm">
                            <a href="{{ route('galeria.show', $filme) }}" class="truncate text-zinc-200 hover:text-brand-400">
                                {{ $filme->titulo }}
                            </a>
                            <span class="shrink-0 text-xs text-zinc-500">{{ $filme->categoria->nome ?? '-' }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
            <a href="{{ route('admin.filmes.index') }}" class="mt-4 inline-block text-sm font-semibold text-brand-400 hover:underline">
                Ver todos
            </a>
        </div>
    </div>
@endsection
