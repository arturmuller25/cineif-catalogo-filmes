<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function mostrarLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credenciais = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credenciais, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.painel'));
        }

        return back()
            ->withErrors(['email' => 'As credenciais informadas não conferem.'])
            ->onlyInput('email');
    }

    public function mostrarCadastro(): View
    {
        return view('auth.register');
    }

    public function cadastrar(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $usuario = User::create([
            'name' => $dados['name'],
            'email' => $dados['email'],
            'password' => Hash::make($dados['password']),
        ]);

        Auth::login($usuario);
        $request->session()->regenerate();

        return redirect()
            ->route('admin.painel')
            ->with('sucesso', 'Bem-vindo(a), ' . $usuario->name . '!');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('galeria.index');
    }
}
