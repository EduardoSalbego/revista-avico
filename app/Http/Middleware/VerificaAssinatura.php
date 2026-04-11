<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VerificaAssinatura
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Você precisa fazer login para acessar a revista.');
        }

        if ($user->perfil === 'admin') {
            return $next($request);
        }

        if (is_null($user->assinante_ate) || Carbon::parse($user->assinante_ate)->isPast()) {
            
            return redirect()->route('assinar')->with('warning', 'Acesso exclusivo para assinantes! Escolha um plano para apoiar a AVICO e continuar lendo.');
        }

        return $next($request);
    }
}