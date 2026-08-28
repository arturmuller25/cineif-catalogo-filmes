@auth
    @php $ehFavorito = in_array($filme->id, $favoritados ?? []); @endphp
    <form method="POST" action="{{ route('favoritos.toggle', $filme) }}">
        @csrf
        <button type="submit"
                aria-label="{{ $ehFavorito ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}"
                title="{{ $ehFavorito ? 'Remover dos favoritos' : 'Adicionar aos favoritos' }}"
                class="grid h-9 w-9 place-items-center rounded-full border backdrop-blur transition {{ $ehFavorito ? 'border-brand-400 bg-brand-400 text-zinc-900' : 'border-white/20 bg-black/50 text-white hover:border-brand-400 hover:text-brand-300' }}">
            <svg viewBox="0 0 24 24" class="h-4 w-4" fill="{{ $ehFavorito ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
        </button>
    </form>
@endauth
