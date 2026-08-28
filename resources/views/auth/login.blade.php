@extends('layouts.app')

@section('titulo', 'Entrar')

@section('conteudo')
    <div class="mx-auto max-w-md">
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/50 p-6 sm:p-8">
            <h1 class="text-2xl font-bold">Entrar</h1>
            <p class="mt-1 text-sm text-zinc-400">Acesse a área de administração dos filmes.</p>

            <form method="POST" action="{{ route('login.submit') }}" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-zinc-300">E-mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-brand-400 focus:outline-none">
                    @error('email')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-zinc-300">Senha</label>
                    <input id="password" type="password" name="password" required
                           class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-brand-400 focus:outline-none">
                    @error('password')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-2 text-sm text-zinc-400">
                    <input type="checkbox" name="remember" class="rounded border-zinc-600 bg-zinc-950 text-brand-400 focus:ring-brand-400">
                    Manter-me conectado
                </label>

                <button type="submit"
                        class="w-full rounded-lg bg-brand-400 px-4 py-2.5 text-sm font-semibold text-zinc-900 transition hover:bg-brand-300">
                    Entrar
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-zinc-400">
                Não tem conta?
                <a href="{{ route('register') }}" class="font-semibold text-brand-400 hover:underline">Cadastre-se</a>
            </p>
        </div>

        <div class="mt-4 rounded-xl border border-zinc-800 bg-zinc-900/30 px-4 py-3 text-center text-xs text-zinc-500">
            Conta de demonstração: <span class="text-zinc-300">admin@cineif.test</span> / <span class="text-zinc-300">password</span>
        </div>
    </div>
@endsection
