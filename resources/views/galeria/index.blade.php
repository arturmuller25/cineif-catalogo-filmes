@extends('layouts.app')

@section('titulo', 'Galeria')

@section('conteudo')
    <section class="mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
            Explore o <span class="text-amber-400">catálogo</span>
        </h1>
        <p class="mt-2 max-w-2xl text-zinc-400">
            Navegue pelos filmes, filtre por ano ou categoria e clique para ver a sinopse, o trailer e as avaliações.
        </p>
    </section>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('galeria.index') }}"
          class="mb-8 grid grid-cols-1 gap-3 rounded-2xl border border-zinc-800 bg-zinc-900/50 p-4 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <label for="busca" class="mb-1 block text-xs font-medium text-zinc-400">Buscar por título</label>
            <input type="text" id="busca" name="busca" value="{{ $filtros['busca'] ?? '' }}" placeholder="Ex.: Interestelar"
                   class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white placeholder-zinc-500 focus:border-amber-400 focus:outline-none">
        </div>

        <div>
            <label for="categoria" class="mb-1 block text-xs font-medium text-zinc-400">Categoria</label>
            <select id="categoria" name="categoria"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-amber-400 focus:outline-none">
                <option value="">Todas</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected(($filtros['categoria'] ?? null) == $categoria->id)>
                        {{ $categoria->nome }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="ano" class="mb-1 block text-xs font-medium text-zinc-400">Ano</label>
            <select id="ano" name="ano"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-amber-400 focus:outline-none">
                <option value="">Todos</option>
                @foreach ($anos as $ano)
                    <option value="{{ $ano }}" @selected(($filtros['ano'] ?? null) == $ano)>{{ $ano }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit"
                    class="flex-1 rounded-lg bg-amber-400 px-4 py-2 text-sm font-semibold text-zinc-900 transition hover:bg-amber-300">
                Filtrar
            </button>
            <a href="{{ route('galeria.index') }}"
               class="rounded-lg border border-zinc-700 px-4 py-2 text-sm text-zinc-300 transition hover:bg-zinc-800">
                Limpar
            </a>
        </div>
    </form>

    {{-- Grade de filmes --}}
    @if ($filmes->isEmpty())
        <div class="rounded-2xl border border-dashed border-zinc-800 py-16 text-center text-zinc-500">
            Nenhum filme encontrado com os filtros selecionados.
        </div>
    @else
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @foreach ($filmes as $filme)
                @php $capa = $filme->capaUrl(); @endphp
                <a href="{{ route('galeria.show', $filme) }}"
                   class="group overflow-hidden rounded-xl border border-zinc-800 bg-zinc-900 transition hover:-translate-y-1 hover:border-amber-400/50 hover:shadow-lg hover:shadow-amber-400/10">
                    <div class="relative aspect-[2/3] overflow-hidden">
                        @if ($capa)
                            <img src="{{ $capa }}" alt="Capa de {{ $filme->titulo }}"
                                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                        @else
                            <div class="flex h-full w-full items-center justify-center p-4 text-center"
                                 style="background-image: linear-gradient(160deg, {{ $filme->corPlaceholder() }}, #09090b);">
                                <span class="text-base font-bold leading-tight text-white/90 drop-shadow">{{ $filme->titulo }}</span>
                            </div>
                        @endif
                        <span class="absolute right-2 top-2 rounded-md bg-black/60 px-2 py-0.5 text-xs font-medium text-amber-300 backdrop-blur">
                            {{ $filme->ano }}
                        </span>
                    </div>
                    <div class="p-3">
                        <span class="text-xs font-medium text-amber-400">{{ $filme->categoria->nome }}</span>
                        <h3 class="mt-0.5 line-clamp-2 text-sm font-semibold text-zinc-100 group-hover:text-white">
                            {{ $filme->titulo }}
                        </h3>
                        @if ($filme->total_avaliacoes > 0)
                            <div class="mt-1.5 flex items-center gap-1 text-xs text-zinc-400">
                                @include('partials.estrelas', ['nota' => $filme->media_nota, 'tamanho' => 'h-3.5 w-3.5'])
                                <span class="font-semibold text-zinc-300">{{ number_format($filme->media_nota, 1, ',', '') }}</span>
                                <span class="text-zinc-500">({{ $filme->total_avaliacoes }})</span>
                            </div>
                        @else
                            <div class="mt-1.5 text-xs text-zinc-500">Sem avaliações</div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $filmes->links() }}
        </div>
    @endif
@endsection
