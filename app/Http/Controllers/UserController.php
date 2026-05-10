<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Autor;
use App\Models\Leitor;
use App\Models\revisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        // Pendentes de aprovação (revisores)
        $pendentes = Revisor::with('user')
            ->where('status', 'pendente')
            ->latest()
            ->get();

        // Usuários + revires ativos paginados
        $usuarios = User::where(function ($query) {
            $query->whereDoesntHave('revisor')
                ->orWhereHas('revisor', function ($q) {
                    $q->where('status', 'ativo');
                });
        })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.usuarios.index', compact('usuarios', 'pendentes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return view('admin.usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request)
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
            return $user;
        });
    }

    /**
     * Approve a pending user account.
     * 
     * @param Revisor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function aprovar(Revisor $revisor)
    {
        $revisor->update([
            'status' => 'ativo'
        ]);

        return back()->with(
            'success',
            "O revisor foi aprovado com sucesso!"
        );
    }

    /**
     * decline a pending user account.
     * 
     * @param Revisor
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejeitar(Revisor $revisor)
    {
        $revisor->update([
            'status' => 'recusado'
        ]);

        return back()->with(
            'success',
            "O revisor foi recusado."
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     */
    public function update(Request $request, User $usuario)
    {
        $validated = $request->validate([
            // USER
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($usuario->id)
            ],
            'password' => ['nullable', 'min:8'],

            // ROLES / PERFIS
            'roles' => ['nullable', 'array'],
            'roles.*' => ['string'],

            // DADOS ACADÊMICOS
            'instituicao' => ['nullable', 'string', 'max:255'],
            'orcid' => ['nullable', 'string', 'max:255'],
            'lattes_url' => ['nullable', 'url', 'max:255'],
            'titulacao' => ['nullable', 'string', 'max:255'],

            // STATUS REVISOR
            'status_revisor' => ['nullable', 'in:pendente,ativo,recusado'],
        ]);

        DB::transaction(function () use ($validated, $usuario) {

            // ROLES
            $roles = $validated['roles'] ?? [];

            // USER
            $usuario->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            if (!empty($validated['password'])) {
                $usuario->update([
                    'password' => Hash::make($validated['password'])
                ]);
            }

            // ROLES SPATIE
            $rolesSpatie = collect($roles)
                ->filter(fn($role) => in_array($role, [
                    'admin',
                    'editor'
                ]))
                ->values()
                ->toArray();

            $usuario->syncRoles($rolesSpatie);

            // DADOS ACADÊMICOS
            $dadosAcademicos = [
                'instituicao' => $validated['instituicao'] ?? null,
                'orcid' => $validated['orcid'] ?? null,
                'lattes_url' => $validated['lattes_url'] ?? null,
            ];

            // AUTOR
            if (in_array('autor', $roles)) {
                Autor::updateOrCreate(
                    ['user_id' => $usuario->id],
                    $dadosAcademicos
                );
            } else {
                if ($usuario->autor) {
                    $usuario->autor()->first()->temas()->detach();
                    $usuario->autor()->delete();
                }
            }

            // REVISOR
            if (in_array('revisor', $roles)) {
                Revisor::updateOrCreate(
                    ['user_id' => $usuario->id],
                    [
                        ...$dadosAcademicos,
                        'titulacao' => $validated['titulacao'] ?? null,
                        'status' => $validated['status_revisor']
                            ?? 'pendente',
                    ]
                );
            } else {
                if ($usuario->revisor) {
                    $usuario->revisor()->first()->temas()->detach();
                    $usuario->revisor()->delete();
                }
            }

            // LEITOR
            if (in_array('leitor', $roles)) {
                Leitor::firstOrCreate([
                    'user_id' => $usuario->id
                ]);
            } else {
                if ($usuario->leitor) {
                    $usuario->leitor()->first()->temas()->detach();
                    $usuario->leitor()->delete();
                }
            }
        });

        return redirect()
            ->route('admin.usuarios.index')
            ->with(
                'success',
                'Usuário atualizado com sucesso!'
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuário excluído!');
    }
}
