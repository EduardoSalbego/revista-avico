<?php

// app/Http/Middleware/VerificaAssinatura.php

namespace App\Http\Middleware;

use App\Models\Edicao;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerificaAssinatura
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isEditor())) {
            return $next($request);
        }
        // Pega o id da edição pela rota (/edicoes/{id})
        $edicaoId = $request->route('id');

        if ($edicaoId) {
            $edicao = Edicao::findOrFail($edicaoId);

            if ($edicao->tipo_acesso === 'publica') {
                return $next($request);
            }
        }

        // Edição exclusiva (ou id não resolvido): exige assinatura ativa
        $user = $request->user();

        $assinanteAtivo = $user
            && $user->assinante_ate
            && \Carbon\Carbon::parse($user->assinante_ate)->isFuture();

        if (!$assinanteAtivo) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Esta edição é exclusiva para assinantes.'
                ], 403);
            }

            return redirect()
                ->route('assinar')
                ->with('info', 'Esta edição é exclusiva para assinantes. Assine para ter acesso completo.');
        }

        return $next($request);
    }
}