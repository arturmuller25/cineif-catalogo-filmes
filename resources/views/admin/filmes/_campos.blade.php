@if ($errors->any())
    <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
        <p class="font-semibold">Corrija os itens abaixo:</p>
        <ul class="mt-1 list-inside list-disc">
            @foreach ($errors->all() as $erro)
                <li>{{ $erro }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="titulo" class="mb-1 block text-sm font-medium text-zinc-300">Nome do filme *</label>
        <input id="titulo" type="text" name="titulo" value="{{ old('titulo', $filme->titulo) }}" required
               class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-brand-400 focus:outline-none">
    </div>

    <div>
        <label for="categoria_id" class="mb-1 block text-sm font-medium text-zinc-300">Categoria *</label>
        <select id="categoria_id" name="categoria_id" required
                class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-brand-400 focus:outline-none">
            <option value="">Selecione...</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}" @selected(old('categoria_id', $filme->categoria_id) == $categoria->id)>
                    {{ $categoria->nome }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="ano" class="mb-1 block text-sm font-medium text-zinc-300">Ano *</label>
        <input id="ano" type="number" name="ano" value="{{ old('ano', $filme->ano) }}" min="1888" max="{{ date('Y') + 5 }}" required
               class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-brand-400 focus:outline-none">
    </div>

    <div class="sm:col-span-2">
        <label for="trailer_url" class="mb-1 block text-sm font-medium text-zinc-300">Link do trailer no YouTube</label>
        <input id="trailer_url" type="url" name="trailer_url" value="{{ old('trailer_url', $filme->trailer_url) }}"
               placeholder="https://www.youtube.com/watch?v=..."
               class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white placeholder-zinc-500 focus:border-brand-400 focus:outline-none">
        <p class="mt-1 text-xs text-zinc-500">O trailer será incorporado automaticamente na página do filme.</p>
    </div>

    <div class="sm:col-span-2">
        <label for="sinopse" class="mb-1 block text-sm font-medium text-zinc-300">Sinopse *</label>
        <textarea id="sinopse" name="sinopse" rows="5" required
                  class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-brand-400 focus:outline-none">{{ old('sinopse', $filme->sinopse) }}</textarea>
    </div>

    <div class="sm:col-span-2">
        <label for="imagem_capa" class="mb-1 block text-sm font-medium text-zinc-300">Imagem da capa</label>
        <div class="flex items-center gap-4">
            @php $capaAtual = $filme->capaUrl(); @endphp
            @if ($capaAtual)
                <div class="h-24 w-16 shrink-0 overflow-hidden rounded-lg border border-zinc-800">
                    <img src="{{ $capaAtual }}" alt="Capa atual" class="h-full w-full object-cover">
                </div>
            @endif
            <input id="imagem_capa" type="file" name="imagem_capa" accept="image/*"
                   class="block w-full text-sm text-zinc-400 file:mr-4 file:rounded-lg file:border-0 file:bg-brand-400 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-zinc-900 hover:file:bg-brand-300">
        </div>
        <p class="mt-1 text-xs text-zinc-500">Formatos de imagem, até 4 MB. @if ($capaAtual) Envie uma nova imagem para substituir a atual. @endif</p>
    </div>
</div>
