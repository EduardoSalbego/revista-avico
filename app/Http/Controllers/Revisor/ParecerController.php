<?php

namespace App\Http\Controllers\Revisor;

use App\Http\Controllers\Controller;
use App\Models\Parecer;
use App\Models\Submissao;
use App\Notifications\RevisorDeclinouTarefa;
use App\Notifications\SubmissaoMajorReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParecerController extends Controller
{
    public function index()
    {
        $pareceres = Parecer::with(['submissao.autor', 'submissao.pareceres'])
            ->where('revisor_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('revisor.parecer', compact('pareceres'));
    }

    // Revisor aceita ou declina a tarefa
    public function responderTarefa(Request $request, $id)
    {
        $parecer = Parecer::where('revisor_id', Auth::id())->findOrFail($id);

        $request->validate([
            'aceito_tarefa' => 'required|boolean',
        ]);

        $parecer->update(['aceito_tarefa' => $request->boolean('aceito_tarefa')]);

        if (!$request->boolean('aceito_tarefa')) {
            // Notifica o editor que o revisor declinou
            // (notifica todos os editores/admins do sistema)
            //\App\Models\User::whereIn('role', ['editor', 'admin'])
            //    ->where('status', 'ativo')
            //    ->each(fn($editor) => $editor->notify(
            //        new RevisorDeclinouTarefa($submissao, Auth::user())
            //    ));

            return back()->with('success', 'Tarefa declinada. O editor foi notificado.');
        }

        return back()->with('success', 'Tarefa aceita! Baixe o PDF e emita seu parecer.');
    }

    // Revisor emite o parecer
    public function emitir(Request $request, $id)
    {
        $parecer = Parecer::where('revisor_id', Auth::id())->findOrFail($id);

        if (!$parecer->aceito_tarefa) {
            return back()->with('error', 'Você não pode emitir parecer em uma tarefa declinada.');
        }

        $request->validate([
            'decisao' => 'required|in:aceito,rejeitado,major_review,revisao_pontual',
            'comentario' => 'required_if:decisao,rejeitado,major_review,revisao_pontual|nullable|string|max:5000',
        ]);

        $parecer->update([
            'decisao' => $request->decisao,
            'comentario' => $request->comentario,
        ]);

        $submissao = $parecer->submissao->load('pareceres');

        // Se todos responderam, verifica se há major_review
        if ($submissao->todosRevisoresResponderam()) {
            if ($submissao->temMajorReview()) {
                // Volta para o autor corrigir
                $submissao->update(['status' => 'major_review']);
                //$submissao->autor->notify(new SubmissaoMajorReview($submissao));
            }
            // Se não há major_review, o editor verá os pareceres e tomará a decisão final
        }

        return back()->with('success', 'Parecer registrado com sucesso!');
    }
}
