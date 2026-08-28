@extends('layouts.app')

@section('titulo', 'Favoritos')

@section('conteudo')
    <div class="mb-6">
        <h1 class="text-2xl font-extrabold uppercase tracking-tight sm:text-3xl">Meus favoritos</h1>
        <p class="mt-1 text-sm text-zinc-400">Os filmes que você marcou para ver depois.</p>
    </div>

    @if ($filmes->isEmpty())
        <div class="rounded-2xl border border-dashed border-zinc-800 py-16 text-center text-zinc-500">
            Você ainda não favoritou nenhum filme.
            <a href="{{ route('galeria.index') }}" class="text-brand-400 hover:underline">Explorar a galeria</a>.
        </div>
    @else
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @foreach ($filmes as $filme)
                @include('partials.filme_card')
            @endforeach
        </div>
        <div class="mt-8">{{ $filmes->links() }}</div>
    @endif
@endsection
