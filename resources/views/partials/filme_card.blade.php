@php $capa = $filme->capaUrl(); @endphp
<div class="group relative overflow-hidden rounded-xl border border-zinc-800 bg-zinc-900 transition hover:-translate-y-1 hover:border-brand-400/60 hover:shadow-xl hover:shadow-black/40">
    <a href="{{ route('galeria.show', $filme) }}" class="absolute inset-0 z-10" aria-label="{{ $filme->titulo }}"></a>

    <div class="relative aspect-[2/3] overflow-hidden bg-zinc-800">
        @if ($capa)
            <img src="{{ $capa }}" alt="Pôster de {{ $filme->titulo }}" loading="lazy"
                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center p-4 text-center" style="background-color: {{ $filme->corPlaceholder() }};">
                <span class="text-base font-bold uppercase leading-tight tracking-wide text-white/90">{{ $filme->titulo }}</span>
            </div>
        @endif

        <span class="absolute right-2 top-2 z-20 rounded-md bg-black/70 px-2 py-0.5 text-xs font-semibold text-brand-300">{{ $filme->ano }}</span>

        <div class="absolute left-2 top-2 z-20">
            @include('partials.botao_favorito')
        </div>
    </div>

    <div class="p-3">
        <span class="text-xs font-semibold uppercase tracking-wide text-brand-400">{{ $filme->categoria->nome ?? '' }}</span>
        <h3 class="mt-0.5 line-clamp-1 text-sm font-bold text-zinc-100">{{ $filme->titulo }}</h3>
        <div class="mt-1.5 flex items-center gap-1 text-xs text-zinc-400">
            @if (($filme->total_avaliacoes ?? 0) > 0)
                @include('partials.estrelas', ['nota' => $filme->media_nota, 'tamanho' => 'h-3.5 w-3.5'])
                <span class="font-semibold text-zinc-300">{{ number_format($filme->media_nota, 1, ',', '') }}</span>
                <span class="text-zinc-500">({{ $filme->total_avaliacoes }})</span>
            @else
                <span class="text-zinc-500">Sem avaliações</span>
            @endif
        </div>
    </div>
</div>
