<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Autor;
use App\Models\Leitor;
use App\Models\Revisor;
use App\Models\Tema;


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $temas = Tema::all();
        return view('perfil.index', compact('user', 'temas'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            // Dados acadêmicos
            'instituicao' => 'nullable|string|max:255',
            'orcid' => 'nullable|string|max:255',
            'lattes_url' => 'nullable|url|max:255',
            'titulacao' => 'nullable|string|max:255',
        ]);

        // USER
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // DADOS ACADÊMICOS
        $dadosAcademicos = [
            'instituicao' => $request->instituicao,
            'orcid' => $request->orcid,
            'lattes_url' => $request->lattes_url,
        ];

        // Autor
        if ($user->autor) {
            $user->autor->update($dadosAcademicos);
        }

        // Revisor
        if ($user->revisor) {

            $dadosRevisor = array_merge($dadosAcademicos, [
                'titulacao' => $request->titulacao,
            ]);

            $user->revisor->update($dadosRevisor);
        }

        return redirect()
            ->route('perfil.index')
            ->with('success', 'Seu perfil foi atualizado com sucesso!');
    }
    
    /**
     * Cria o perfil de domínio escolhido pelo usuário.
     * Um usuário pode ter mais de um perfil — basta submeter novamente.
     */
    public function salvarPerfil(Request $request)
    {
        $validated = $request->validate([
            'perfil' => ['required', 'in:autor,revisor,leitor'],
            'temas' => ['nullable', 'array'],
            'temas.*' => ['exists:temas,id'],
            // Campos opcionais por perfil
            'lattes_url' => ['nullable', 'url'],
            'orcid' => ['nullable', 'string', 'max:50'],
            'instituicao' => ['nullable', 'string', 'max:255'],
            'titulacao' => ['nullable', 'string', 'max:100'],
        ]);

        $user = Auth::user();
        $perfil = $validated['perfil'];
        $temas = $validated['temas'] ?? [];

        $perfilModel = match ($perfil) {
            'autor' => Autor::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'lattes_url' => $validated['lattes_url'] ?? null,
                    'orcid' => $validated['orcid'] ?? null,
                    'instituicao' => $validated['instituicao'] ?? null,
                ]
            ),
            'revisor' => Revisor::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'lattes_url' => $validated['lattes_url'] ?? null,
                    'orcid' => $validated['orcid'] ?? null,
                    'titulacao' => $validated['titulacao'] ?? null,
                    'instituicao' => $validated['instituicao'] ?? null,
                ]
            ),
            'leitor' => Leitor::firstOrCreate(['user_id' => $user->id]),
        };

        // Sincroniza temas de interesse (não remove os outros perfis do usuário)
        if (!empty($temas)) {
            $perfilModel->sincronizarTemas($temas);
        }

        return redirect()
            ->route('home')
            ->with('success', "Perfil de {$perfil} criado com sucesso!");
    }

    public function updateTemas(Request $request, string $tipo)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'temas' => ['nullable', 'array'],
            'temas.*' => ['integer', 'exists:temas,id'],
        ]);

        $perfil = match ($tipo) {
            'autor' => $user->autor,
            'revisor' => $user->revisor,
            'leitor' => $user->leitor,
            default => abort(404),
        };

        if (!$perfil) {
            abort(403, 'Perfil não encontrado.');
        }

        $perfil->temas()->sync(
            $validated['temas'] ?? []
        );

        return redirect()
            ->route('perfil.index')
            ->with(
                'success',
                'Temas atualizados com sucesso!'
            );
    }
}