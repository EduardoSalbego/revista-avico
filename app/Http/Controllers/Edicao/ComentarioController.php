<?php

namespace App\Http\Controllers\Edicao;

use App\Models\Comentario;
use App\Models\Edicao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'edicao_id' => 'required|exists:edicoes,id',
            'comentario' => 'required|string|max:1000',
        ]);

        $edicao = Edicao::findOrFail($request->edicao_id);

        if (!$edicao->permitir_comentarios) {
            return redirect()->back()->with('error', 'Os comentários estão desativados para esta edição.');
        }

        Comentario::create([
            'user_id' => Auth::id(),
            'edicao_id' => $request->edicao_id,
            'conteudo' => $request->comentario,
        ]);

        return redirect()->back()->with('success', 'Comentário enviado com sucesso!');
    }

    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);

        if (Auth::id() !== $comentario->user_id && !Auth::user()->isAdmin()) {
            return redirect()->back()->with('error', 'Você não tem permissão para excluir este comentário.');
        }

        $comentario->delete();

        return redirect()->back()->with('success', 'Comentário apagado com sucesso!');
    }
}
