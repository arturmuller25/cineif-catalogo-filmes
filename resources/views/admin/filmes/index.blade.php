@extends('layouts.app')

@section('titulo', 'Gerenciar filmes')

@section('conteudo')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight">Gerenciar filmes</h1>
            <p class="mt-1 text-sm text-zinc-400">{{ $filmes->total() }} filme(s) no catálogo.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.filmes.lixeira') }}"
               class="rounded-lg border border-zinc-700 px-4 py-2 text-sm text-zinc-300 transition hover:bg-zinc-800">
                Lixeira
            </a>
            <a href="{{ route('admin.filmes.create') }}"
               class="rounded-lg bg-amber-400 px-4 py-2 text-sm font-semibold text-zinc-900 transition hover:bg-amber-300">
                + Novo filme
            </a>
        </div>
    </div>

    @if ($filmes->isEmpty())
        <div class="rounded-2xl border border-dashed border-zinc-800 py-16 text-center text-zinc-500">
            Nenhum filme cadastrado. <a href="{{ route('admin.filmes.create') }}" class="text-amber-400 hover:underline">Cadastre o primeiro</a>.
        </div>
    @else
        <div class="overflow-x-auto rounded-2xl border border-zinc-800">
            <table class="w-full min-w-[640px] text-left text-sm">
                <thead class="border-b border-zinc-800 bg-zinc-900/60 text-xs uppercase tracking-wide text-zinc-400">
                    <tr>
                        <th class="px-4 py-3">Filme</th>
                        <th class="px-4 py-3">Categoria</th>
                        <th class="px-4 py-3">Ano</th>
                        <th class="px-4 py-3">Autor</th>
                        <th class="px-4 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach ($filmes as $filme)
                        @php
                            $capa = $filme->capaUrl();
                            $confirmExcluir = 'Mover o filme "' . $filme->titulo . '" para a lixeira?';
                        @endphp
                        <tr class="hover:bg-zinc-900/40">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-14 w-10 shrink-0 overflow-hidden rounded border border-zinc-800">
                                        @if ($capa)
                                            <img src="{{ $capa }}" alt="" class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full" style="background-image: linear-gradient(160deg, {{ $filme->corPlaceholder() }}, #09090b);"></div>
                                        @endif
                                    </div>
                                    <a href="{{ route('galeria.show', $filme) }}" class="font-medium text-zinc-100 hover:text-amber-400">
                                        {{ $filme->titulo }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-zinc-300">{{ $filme->categoria->nome ?? '-' }}</td>
                            <td class="px-4 py-3 text-zinc-300">{{ $filme->ano }}</td>
                            <td class="px-4 py-3 text-zinc-400">{{ $filme->usuario->name ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.filmes.edit', $filme) }}"
                                       class="rounded-lg border border-zinc-700 px-3 py-1.5 text-xs text-zinc-200 transition hover:bg-zinc-800">
                                        Editar
                                    </a>
                                    <form method="POST" action="{{ route('admin.filmes.destroy', $filme) }}"
                                          onsubmit="return confirm(@js($confirmExcluir));">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-lg border border-red-500/40 px-3 py-1.5 text-xs text-red-300 transition hover:bg-red-500/10">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $filmes->links() }}
        </div>
    @endif
@endsection
