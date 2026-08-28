<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('titulo', 'Catálogo de Filmes') · CineIF</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-zinc-950 text-zinc-100 antialiased">
    <header class="sticky top-0 z-40 border-b border-zinc-800/80 bg-zinc-950/80 backdrop-blur">
        <nav class="mx-auto flex max-w-6xl flex-wrap items-center gap-x-4 gap-y-2 px-4 py-3">
            <a href="{{ route('galeria.index') }}" class="flex items-center gap-2 text-lg font-extrabold tracking-tight">
                <svg class="h-6 w-6 text-brand-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M4 3h16a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1zm2 2v2h2V5H6zm0 4v2h2V9H6zm0 4v2h2v-2H6zm0 4v2h2v-2H6zm10-12v2h2V5h-2zm0 4v2h2V9h-2zm0 4v2h2v-2h-2zm0 4v2h2v-2h-2zM10 5v14h4V5h-4z"/>
                </svg>
                <span>Cine<span class="text-brand-400">IF</span></span>
            </a>

            <div class="ml-auto flex flex-wrap items-center gap-1 text-sm">
                <a href="{{ route('galeria.index') }}"
                   class="rounded-lg px-3 py-2 text-zinc-300 transition hover:bg-zinc-800 hover:text-white {{ request()->routeIs('galeria.*') ? 'text-white' : '' }}">
                    Galeria
                </a>

                @auth
                    <a href="{{ route('favoritos.index') }}"
                       class="rounded-lg px-3 py-2 text-zinc-300 transition hover:bg-zinc-800 hover:text-white {{ request()->routeIs('favoritos.*') ? 'text-white' : '' }}">
                        Favoritos
                    </a>
                    <a href="{{ route('admin.painel') }}"
                       class="rounded-lg px-3 py-2 text-zinc-300 transition hover:bg-zinc-800 hover:text-white {{ request()->routeIs('admin.painel') ? 'text-white' : '' }}">
                        Painel
                    </a>
                    <a href="{{ route('admin.filmes.index') }}"
                       class="rounded-lg px-3 py-2 text-zinc-300 transition hover:bg-zinc-800 hover:text-white {{ request()->routeIs('admin.filmes.*') ? 'text-white' : '' }}">
                        Gerenciar
                    </a>
                    <a href="{{ route('admin.filmes.create') }}"
                       class="rounded-lg bg-brand-400 px-3 py-2 font-semibold text-zinc-900 transition hover:bg-brand-300">
                        + Novo filme
                    </a>
                    <span class="mx-1 hidden text-zinc-600 sm:inline">|</span>
                    <a href="{{ route('perfil') }}"
                       class="hidden rounded-lg px-2 py-2 text-xs text-zinc-300 transition hover:text-white sm:inline {{ request()->routeIs('perfil') ? 'text-white' : '' }}">
                        {{ auth()->user()->name }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="rounded-lg px-3 py-2 text-zinc-400 transition hover:bg-zinc-800 hover:text-white">
                            Sair
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="rounded-lg px-3 py-2 text-zinc-300 transition hover:bg-zinc-800 hover:text-white">
                        Entrar
                    </a>
                    <a href="{{ route('register') }}"
                       class="rounded-lg bg-brand-400 px-3 py-2 font-semibold text-zinc-900 transition hover:bg-brand-300">
                        Cadastrar
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 px-4 py-8">
        @if (session('sucesso'))
            <div class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
                {{ session('sucesso') }}
            </div>
        @endif

        @if (session('erro'))
            <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                {{ session('erro') }}
            </div>
        @endif

        @yield('conteudo')
    </main>

    <footer class="border-t border-zinc-800/80 py-6 text-center text-xs text-zinc-500">
        <span class="font-semibold text-zinc-400">CineIF</span> · Catálogo de Filmes ·
        Projeto de Programação Web · Laravel {{ app()->version() }}
    </footer>
</body>
</html>
