<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! $request->user()) {
            abort(403, 'Acesso negado. Faça login para continuar.');
        }
        if ($request->user()->role === 'admin') {
            return $next($request);
        }
        if (! in_array($request->user()->role, $roles)) {
            abort(403, 'Acesso negado. Você não tem permissão para realizar esta ação.');
        }

        return $next($request);
    }
}
