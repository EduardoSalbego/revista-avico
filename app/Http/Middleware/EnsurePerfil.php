<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePerfil
{
    /**
     * Perfis mapeados para o método de verificação no User.
     * Adicione novos perfis aqui conforme o sistema crescer.
     */
    private array $perfilMap = [
        'autor' => 'isAutor',
        'revisor' => 'isRevisor',
        'leitor' => 'isLeitor',
    ];

    public function handle(Request $request, Closure $next, string ...$perfis): Response
    {
        $user = $request->user();

        // ADMIN bypassa qualquer perfil
        if ($user->hasRole('admin')) {
            return $next($request);
        }

        foreach ($perfis as $perfil) {
            $metodo = $this->perfilMap[$perfil] ?? null;

            if (!$metodo) {
                abort(500, "Perfil '{$perfil}' não reconhecido no middleware EnsurePerfil.");
            }

            if ($user->{$metodo}()) {
                return $next($request); // tem pelo menos um dos perfis exigidos
            }
        }

        // Nenhum perfil satisfeito
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Perfil não autorizado.'], 403);
        }

        return redirect()
            ->route('perfil.completar')
            ->with('warning', 'Complete seu cadastro para acessar esta área.');
    }
}