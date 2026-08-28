@extends('layouts.app')

@section('titulo', 'Cadastrar')

@section('conteudo')
    <div class="mx-auto max-w-md">
        <div class="rounded-2xl border border-zinc-800 bg-zinc-900/50 p-6 sm:p-8">
            <h1 class="text-2xl font-bold">Criar conta</h1>
            <p class="mt-1 text-sm text-zinc-400">Cadastre-se para gerenciar o catálogo de filmes.</p>

            <form method="POST" action="{{ route('register.submit') }}" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label for="name" class="mb-1 block text-sm font-medium text-zinc-300">Nome</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-amber-400 focus:outline-none">
                    @error('name')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-zinc-300">E-mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-amber-400 focus:outline-none">
                    @error('email')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-zinc-300">Senha</label>
                    <input id="password" type="password" name="password" required
                           class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-amber-400 focus:outline-none">
                    @error('password')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="mb-1 block text-sm font-medium text-zinc-300">Confirmar senha</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full rounded-lg border border-zinc-700 bg-zinc-950 px-3 py-2 text-sm text-white focus:border-amber-400 focus:outline-none">
                </div>

                <button type="submit"
                        class="w-full rounded-lg bg-amber-400 px-4 py-2.5 text-sm font-semibold text-zinc-900 transition hover:bg-amber-300">
                    Cadastrar
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-zinc-400">
                Já tem conta?
                <a href="{{ route('login') }}" class="font-semibold text-amber-400 hover:underline">Entrar</a>
            </p>
        </div>
    </div>
@endsection
