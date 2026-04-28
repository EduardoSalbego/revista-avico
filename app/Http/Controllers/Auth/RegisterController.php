<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:leitor,autor,revisor,editor',
        ]);

        $requerAprovacao = in_array($request->role, ['revisor', 'editor']);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $requerAprovacao ? 'pendente' : 'ativo',
        ]);

        if ($requerAprovacao) {
            // Não loga — redireciona com aviso
            return redirect()->route('login')->with(
                'info',
                'Cadastro realizado! Sua conta está aguardando aprovação de um administrador.'
            );
        }

        event(new Registered($user));
        Auth::login($user);
        return redirect('/')->with('success', 'Conta criada com sucesso!');
    }
}
