<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tema;
use App\Models\Autor;
use App\Models\Revisor;
use App\Models\Leitor;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return View
     */
    public function showRegistrationForm()
    {
        $temas = Tema::ativo()->orderBy('nome')->get();

        return view('auth.register', compact('temas'));

    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            // Dados da conta
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // Perfil de domínio
            'perfil' => ['required', 'in:autor,revisor,leitor'],

            // Dados opcionais (validados condicionalmente abaixo)
            'lattes_url' => ['nullable', 'url', 'max:255'],
            'orcid' => ['nullable', 'string', 'max:50'],
            'instituicao' => ['nullable', 'string', 'max:255'],
            'titulacao' => ['nullable', 'string', 'in:Especialista,Mestre,Doutor,Pós-Doutor'],

            // Temas de interesse
            'temas' => ['nullable', 'array'],
            'temas.*' => ['integer', 'exists:temas,id'],
        ]);

        // Cria usuário + perfil em uma única transação.
        // Se qualquer parte falhar, nada é salvo no banco.
        $user = DB::transaction(function () use ($validated) {

            // 1. Cria o User
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'status' => 'ativo',
            ]);

            // 2. Cria o perfil de domínio correto
            $perfilModel = match ($validated['perfil']) {

                'autor' => Autor::create([
                    'user_id' => $user->id,
                    'lattes_url' => $validated['lattes_url'] ?? null,
                    'orcid' => $validated['orcid'] ?? null,
                    'instituicao' => $validated['instituicao'] ?? null,
                ]),

                'revisor' => Revisor::create([
                    'user_id' => $user->id,
                    'lattes_url' => $validated['lattes_url'] ?? null,
                    'orcid' => $validated['orcid'] ?? null,
                    'titulacao' => $validated['titulacao'] ?? null,
                    'instituicao' => $validated['instituicao'] ?? null,
                    // Revisor começa pendente de aprovação
                    'status' => 'pendente',
                ]),

                'leitor' => Leitor::create([
                    'user_id' => $user->id,
                ]),
            };

            // 3. Vincula temas de interesse (se informados)
            if (!empty($validated['temas'])) {
                $perfilModel->temas()->attach($validated['temas']);
            }

            return $user;
        });

        // Dispara evento de registro (envia e-mail de verificação, etc.)
        event(new Registered($user));

        Auth::login($user);

        // Revisor vai para página de "aguardando aprovação"
        if ($validated['perfil'] === 'revisor') {
            return redirect()
                ->route('home')
                ->with('info', 'Cadastro realizado! Seu perfil de revisor está aguardando aprovação do administrador.');
        }

        return redirect()
            ->route('home')
            ->with('success', 'Bem-vindo(a) à Revista AVICO!');
    }
}
