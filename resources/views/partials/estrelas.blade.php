{{-- Exibe 5 estrelas preenchidas de acordo com a nota (0 a 5). --}}
@php
    $arredondada = (int) round($nota ?? 0);
    $classe = $tamanho ?? 'h-4 w-4';
@endphp
<span class="inline-flex items-center gap-0.5" role="img" aria-label="Nota {{ $arredondada }} de 5">
    @for ($i = 1; $i <= 5; $i++)
        <svg viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
             class="{{ $classe }} {{ $i <= $arredondada ? 'text-amber-400' : 'text-zinc-700' }}">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.367 2.446a1 1 0 00-.364 1.118l1.287 3.957c.3.922-.755 1.688-1.54 1.118l-3.366-2.446a1 1 0 00-1.175 0l-3.366 2.446c-.784.57-1.838-.196-1.539-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.184 9.384c-.783-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.286-3.957z"/>
        </svg>
    @endfor
</span>
