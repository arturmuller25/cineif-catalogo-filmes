@extends('layouts.app')

@section('titulo', 'Lixeira')

@section('conteudo')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight">Lixeira</h1>
            <p class="mt-1 text-sm text-zinc-400">Filmes excluídos podem ser restaurados ou apagados definitivamente.</p>
        </div>
        <a href="{{ route('admin.filmes.index') }}"
           class="rounded-lg border border-zinc-700 px-4 py-2 text-sm text-zinc-300 transition hover:bg-zinc-800">
            Voltar aos filmes
        </a>
    </div>

    @if ($filmes->isEmpty())
        <div class="rounded-2xl border border-dashed border-zinc-800 py-16 text-center text-zinc-500">
            A lixeira está vazia.
        </div>
    @else
        <div class="overflow-x-auto rounded-2xl border border-zinc-800">
            <table class="w-full min-w-[560px] text-left text-sm">
                <thead class="border-b border-zinc-800 bg-zinc-900/60 text-xs uppercase tracking-wide text-zinc-400">
                    <tr>
                        <th class="px-4 py-3">Filme</th>
                        <th class="px-4 py-3">Categoria</th>
                        <th class="px-4 py-3">Excluído</th>
                        <th class="px-4 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">
                    @foreach ($filmes as $filme)
                        @php $confirmApagar = 'Apagar o filme "' . $filme->titulo . '" DEFINITIVAMENTE? Esta ação não pode ser desfeita.'; @endphp
                        <tr class="hover:bg-zinc-900/40">
                            <td class="px-4 py-3 font-medium text-zinc-100">{{ $filme->titulo }}</td>
                            <td class="px-4 py-3 text-zinc-300">{{ $filme->categoria->nome ?? '-' }}</td>
                            <td class="px-4 py-3 text-zinc-400">{{ $filme->deleted_at?->diffForHumans() }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <form method="POST" action="{{ route('admin.filmes.restaurar', $filme) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                                class="rounded-lg border border-emerald-500/40 px-3 py-1.5 text-xs text-emerald-300 transition hover:bg-emerald-500/10">
                                            Restaurar
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.filmes.forcar', $filme) }}"
                                          onsubmit="return confirm(@js($confirmApagar));">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="rounded-lg border border-red-500/40 px-3 py-1.5 text-xs text-red-300 transition hover:bg-red-500/10">
                                            Apagar de vez
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
