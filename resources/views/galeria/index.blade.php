@extends('layouts.app')

@section('titulo', 'Galeria')

@section('conteudo')
    {{-- Destaque (melhor avaliado) na home --}}
    @if (! $temFiltro && $destaque)
        @php $capaDestaque = $destaque->capaUrl(); @endphp
        <section class="mb-10 overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900">
            <div class="grid grid-cols-1 md:grid-cols-[230px_1fr]">
                <div class="relative aspect-[2/3] bg-zinc-800 md:aspect-auto">
                    @if ($capaDestaque)
                        <img src="{{ $capaDestaque }}" alt="Pôster de {{ $destaque->titulo }}" class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center p-6 text-center" style="background-color: {{ $destaque->corPlaceholder() }};">
                            <span class="text-2xl font-bold uppercase text-white/90">{{ $destaque->titulo }}</span>
                        </div>
                    @endif
                </div>

                <div class="flex flex-col justify-center gap-3 p-6 md:p-8">
                    <span class="w-fit rounded-full bg-brand-400/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand-400">
                        Destaque · {{ $destaque->categoria->nome }}
                    </span>
                    <h1 class="text-3xl font-extrabold uppercase leading-none tracking-tight sm:text-5xl">{{ $destaque->titulo }}</h1>

                    <div class="flex flex-wrap items-center gap-2 text-sm">
                        @include('partials.estrelas', ['nota' => $destaque->media_nota, 'tamanho' => 'h-5 w-5'])
                        @if ($destaque->total_avaliacoes > 0)
                            <span class="font-bold text-white">{{ number_format($destaque->media_nota, 1, ',', '') }}</span>
                            <span class="text-zinc-500">de 5</span>
                        @endif
                        <span class="text-zinc-600">·</span>
                        <span class="text-zinc-400">{{ $destaque->ano }}</span>
                    </div>

                    <p class="max-w-2xl leading-relaxed text-zinc-300 line-clamp-3">{{ $destaque->sinopse }}</p>

                    <div class="flex flex-wrap items-center gap-2 pt-1">
                        <a href="{{ route('galeria.show', $destaque) }}"
                           class="rounded-lg bg-brand-400 px-5 py-2.5 text-sm font-semibold text-zinc-900 transition hover:bg-brand-300">
                            Ver detalhes
                        </a>
                        @include('partials.botao_favorito', ['filme' => $destaque])
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Prateleiras (home) --}}
    @if (! $temFiltro)
        @if ($melhores->isNotEmpty())
            <section class="mb-10">
                <h2 class="mb-3 text-lg font-bold">Melhores avaliados</h2>
                <div class="row-scroll flex gap-4 overflow-x-auto pb-3">
                    @foreach ($melhores as $filme)
                        <div class="w-40 shrink-0 sm:w-44">@include('partials.filme_card')</div>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($recentes->isNotEmpty())
            <section class="mb-10">
                <h2 class="mb-3 text-lg font-bold">Adicionados recentemente</h2>
                <div class="row-scroll flex gap-4 overflow-x-auto pb-3">
                    @foreach ($recentes as $filme)
                        <div class="w-40 shrink-0 sm:w-44">@include('partials.filme_card')</div>
                    @endforeach
                </div>
            </section>
        @endif
    @endif

    {{-- Filtros e ordenacao --}}
    <form method="GET" action="{{ route('galeria.index') }}"
          class="mb-6 grid grid-cols-1 gap-3 rounded-2xl border border-zinc-800 bg-zinc-900/50 p-4 sm:grid-cols-2 lg:grid-cols-5">
        <div>
            <label for="busca" class="mb-1 block text-xs font-medium text-zinc-400">Buscar por título</label>
            <input type="text" id="busca" name="busca" value="{{ $filtros['busca'] ?? '' }}" placeholder="Ex.: Interestelar"
                   class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white placeholder-zinc-500 focus:border-brand-400 focus:outline-none">
        </div>
        <div>
            <label for="categoria" class="mb-1 block text-xs font-medium text-zinc-400">Categoria</label>
            <select id="categoria" name="categoria"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-brand-400 focus:outline-none">
                <option value="">Todas</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected(($filtros['categoria'] ?? null) == $categoria->id)>{{ $categoria->nome }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="ano" class="mb-1 block text-xs font-medium text-zinc-400">Ano</label>
            <select id="ano" name="ano"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-brand-400 focus:outline-none">
                <option value="">Todos</option>
                @foreach ($anos as $ano)
                    <option value="{{ $ano }}" @selected(($filtros['ano'] ?? null) == $ano)>{{ $ano }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="ordenar" class="mb-1 block text-xs font-medium text-zinc-400">Ordenar por</label>
            <select id="ordenar" name="ordenar"
                    class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-brand-400 focus:outline-none">
                @php $ord = $filtros['ordenar'] ?? 'recentes'; @endphp
                <option value="recentes" @selected($ord === 'recentes')>Mais recentes</option>
                <option value="avaliados" @selected($ord === 'avaliados')>Melhor avaliados</option>
                <option value="titulo" @selected($ord === 'titulo')>Título (A-Z)</option>
                <option value="ano" @selected($ord === 'ano')>Ano</option>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 rounded-lg bg-brand-400 px-4 py-2 text-sm font-semibold text-zinc-900 transition hover:bg-brand-300">
                Aplicar
            </button>
            <a href="{{ route('galeria.index') }}" class="rounded-lg border border-zinc-700 px-4 py-2 text-sm text-zinc-300 transition hover:bg-zinc-800">
                Limpar
            </a>
        </div>
    </form>

    {{-- Grade --}}
    <section>
        <div class="mb-4 flex items-center justify-between">
            <h2 class="text-lg font-bold">{{ $temFiltro ? 'Resultados' : 'Todo o catálogo' }}</h2>
            <span class="text-sm text-zinc-500">{{ $filmes->total() }} filme(s)</span>
        </div>

        @if ($filmes->isEmpty())
            <div class="rounded-2xl border border-dashed border-zinc-800 py-16 text-center text-zinc-500">
                Nenhum filme encontrado com os filtros selecionados.
            </div>
        @else
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($filmes as $filme)
                    @include('partials.filme_card')
                @endforeach
            </div>
            <div class="mt-8">{{ $filmes->links() }}</div>
        @endif
    </section>
@endsection
