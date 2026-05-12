<?php

namespace App\Http\Controllers;

use App\Models\Revisor;
use Illuminate\Http\Request;

class RevisorBuscaController extends Controller
{
    public function buscar(Request $request)
    {
        $q = $request->query('q', '');
        // Busca na model Revisor, filtrando pelo status e pelo nome do Usuário
        $revisores = Revisor::with('user:id,name,email')
            ->where('status', 'ativo')
            ->whereHas('user', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->limit(8)
            ->get();

        // Formata a resposta para o frontend
        $dadosFormatados = $revisores->map(function ($revisor) {
            return [
                'id' => $revisor->id,
                'name' => $revisor->user->name,
                'email' => $revisor->user->email,
            ];
        });

        return response()->json($dadosFormatados);
    }
}
