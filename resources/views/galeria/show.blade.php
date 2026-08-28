@extends('layouts.app')

@section('titulo', $filme->titulo)

@section('conteudo')
    <a href="{{ route('galeria.index') }}"
       class="mb-6 inline-flex items-center gap-1 text-sm text-zinc-400 transition hover:text-brand-400">
        Voltar para a galeria
    </a>

    <article class="grid grid-cols-1 gap-8 md:grid-cols-[280px_1fr]">
        {{-- Poster --}}
        <div>
            @php $capa = $filme->capaUrl(); @endphp
            <div class="overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-800">
                @if ($capa)
                    <img src="{{ $capa }}" alt="Pôster de {{ $filme->titulo }}" class="aspect-[2/3] w-full object-cover">
                @else
                    <div class="flex aspect-[2/3] w-full items-center justify-center p-6 text-center" style="background-color: {{ $filme->corPlaceholder() }};">
                        <span class="text-2xl font-bold uppercase leading-tight text-white/90">{{ $filme->titulo }}</span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Informacoes --}}
        <div>
            <div class="flex items-start justify-between gap-3">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="rounded-full bg-brand-400/10 px-3 py-1 text-xs font-semibold text-brand-400">{{ $filme->categoria->nome }}</span>
                    <span class="rounded-full border border-zinc-700 px-3 py-1 text-xs text-zinc-300">{{ $filme->ano }}</span>
                </div>
                @include('partials.botao_favorito')
            </div>

            <h1 class="mt-3 text-3xl font-extrabold uppercase leading-none tracking-tight sm:text-5xl">{{ $filme->titulo }}</h1>

            <div class="mt-3 flex items-center gap-2">
                @include('partials.estrelas', ['nota' => $media, 'tamanho' => 'h-5 w-5'])
                @if ($avaliacoes->isNotEmpty())
                    <span class="text-lg font-bold text-white">{{ number_format($media, 1, ',', '') }}</span>
                    <span class="text-sm text-zinc-500">de 5 · {{ $avaliacoes->count() }} avaliação(ões)</span>
                @else
                    <span class="text-sm text-zinc-500">Ainda sem avaliações</span>
                @endif
            </div>

            <p class="mt-2 text-sm text-zinc-500">Cadastrado por {{ $filme->usuario->name ?? 'Desconhecido' }}</p>

            <h2 class="mt-6 text-sm font-semibold uppercase tracking-wide text-zinc-400">Sinopse</h2>
            <p class="mt-2 leading-relaxed text-zinc-200">{{ $filme->sinopse }}</p>

            {{-- Trailer --}}
            <h2 class="mt-8 text-sm font-semibold uppercase tracking-wide text-zinc-400">Trailer</h2>
            @php $embed = $filme->embedUrl(); @endphp
            <div class="mt-2">
                @if ($embed)
                    <div class="aspect-video w-full overflow-hidden rounded-2xl border border-zinc-800">
                        <iframe class="h-full w-full" src="{{ $embed }}" title="Trailer de {{ $filme->titulo }}"
                                frameborder="0" loading="lazy"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                    </div>
                @elseif ($filme->trailer_url)
                    <a href="{{ $filme->trailer_url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-500">
                        Assistir ao trailer no YouTube
                    </a>
                @else
                    <p class="text-sm text-zinc-500">Trailer não disponível.</p>
                @endif
            </div>
        </div>
    </article>

    {{-- Avaliacoes --}}
    <section class="mt-14">
        <h2 class="mb-4 text-lg font-bold">Avaliações</h2>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[320px_1fr]">
            <div class="rounded-2xl border border-zinc-800 bg-zinc-900/50 p-5">
                @auth
                    <p class="text-sm font-semibold text-zinc-200">{{ $minhaAvaliacao ? 'Atualize sua avaliação' : 'Avalie este filme' }}</p>
                    <form method="POST" action="{{ route('avaliacoes.store', $filme) }}" class="mt-3">
                        @csrf
                        <div class="rating-stars" role="radiogroup" aria-label="Nota de 1 a 5">
                            @for ($i = 5; $i >= 1; $i--)
                                <input type="radio" id="nota{{ $i }}" name="nota" value="{{ $i }}"
                                       @checked((int) old('nota', $minhaAvaliacao->nota ?? 0) === $i) required>
                                <label for="nota{{ $i }}" title="{{ $i }} estrela(s)" aria-label="{{ $i }} estrela(s)">
                                    <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.364 1.118l1.287 3.957c.3.922-.755 1.688-1.54 1.118l-3.366-2.446a1 1 0 00-1.175 0l-3.366 2.446c-.784.57-1.838-.196-1.539-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.184 9.384c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.957z"/>
                                    </svg>
                                </label>
                            @endfor
                        </div>
                        @error('nota')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror

                        <textarea name="comentario" rows="3" placeholder="Comentário (opcional)"
                                  class="mt-3 w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white placeholder-zinc-500 focus:border-brand-400 focus:outline-none">{{ old('comentario', $minhaAvaliacao->comentario ?? '') }}</textarea>
                        @error('comentario')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror

                        <button type="submit" class="mt-3 w-full rounded-lg bg-brand-400 px-4 py-2 text-sm font-semibold text-zinc-900 transition hover:bg-brand-300">
                            {{ $minhaAvaliacao ? 'Salvar avaliação' : 'Enviar avaliação' }}
                        </button>
                    </form>
                @else
                    <p class="text-sm text-zinc-300">Quer avaliar este filme?</p>
                    <p class="mt-1 text-sm text-zinc-500">
                        <a href="{{ route('login') }}" class="font-semibold text-brand-400 hover:underline">Entre</a>
                        ou
                        <a href="{{ route('register') }}" class="font-semibold text-brand-400 hover:underline">cadastre-se</a>
                        para deixar sua nota.
                    </p>
                @endauth
            </div>

            <div>
                @forelse ($avaliacoes as $avaliacao)
                    <div class="mb-3 rounded-xl border border-zinc-800 bg-zinc-900/30 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <span class="text-sm font-semibold text-zinc-100">{{ $avaliacao->usuario->name ?? 'Usuário' }}</span>
                            @include('partials.estrelas', ['nota' => $avaliacao->nota, 'tamanho' => 'h-4 w-4'])
                        </div>
                        @if ($avaliacao->comentario)
                            <p class="mt-2 text-sm text-zinc-300">{{ $avaliacao->comentario }}</p>
                        @endif
                        <p class="mt-2 text-xs text-zinc-500">{{ $avaliacao->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-zinc-800 p-8 text-center text-sm text-zinc-500">
                        Nenhuma avaliação ainda. Seja o primeiro a avaliar.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Relacionados --}}
    @if ($relacionados->isNotEmpty())
        <section class="mt-14">
            <h2 class="mb-4 text-lg font-bold">Mais em {{ $filme->categoria->nome }}</h2>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                @foreach ($relacionados as $rel)
                    @include('partials.filme_card', ['filme' => $rel])
                @endforeach
            </div>
        </section>
    @endif
@endsection
