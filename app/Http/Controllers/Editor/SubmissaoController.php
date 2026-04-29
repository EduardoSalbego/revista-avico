<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Submissao;
use App\Models\User;
use App\Notifications\SubmissaoDecidida;
use Illuminate\Http\Request;

class SubmissaoController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'todos');

        $query = Submissao::with([
            'autor',
            'revisoresSugeridos',
            'revisoresAtribuidos',
        ])->orderBy('created_at', 'desc');

        if ($status !== 'todos') {
            $query->where('status', $status);
        }

        $submissoes = $query->paginate(10)->appends($request->query());

        // Contagens para os botões de filtro
        $contagens = [
            'todos' => Submissao::count(),
            'submetido' => Submissao::where('status', 'submetido')->count(),
            'em_revisao' => Submissao::where('status', 'em_revisao')->count(),
            'aceito' => Submissao::where('status', 'aceito')->count(),
            'rejeitado' => Submissao::where('status', 'rejeitado')->count(),
        ];

        // Revisores ativos para o select de atribuição
        $revisores = User::where('role', 'revisor')
            ->where('status', 'ativo')
            ->orderBy('name')
            ->get();

        return view('editor.submissoes.index', compact('submissoes', 'contagens', 'revisores'));
    }

    // Atribuir revisores à submissão
    public function atribuir(Request $request, $id)
    {
        $submissao = Submissao::findOrFail($id);

        $request->validate([
            'revisores' => 'nullable|array',
            'revisores.*' => 'exists:users,id',
        ]);

        // Sync substitui os atribuídos anteriores pelos novos
        $submissao->revisoresAtribuidos()->sync($request->revisores ?? []);

        // Se ainda estava como submetido, avança para em_revisao
        if ($submissao->isSubmetido() && !empty($request->revisores)) {
            $submissao->update(['status' => 'em_revisao']);
        }

        return back()->with('success', 'Revisores atribuídos com sucesso!');
    }

    // Aceitar ou rejeitar a submissão
    public function decidir(Request $request, $id)
    {
        $submissao = Submissao::with('autor')->findOrFail($id);

        $request->validate([
            'status' => 'required|in:aceito,rejeitado',
            'observacoes' => 'nullable|string|max:2000',
        ]);

        if ($submissao->isAceito() || $submissao->isRejeitado()) {
            return back()->with('error', 'Esta submissão já teve uma decisão final.');
        }

        $submissao->update([
            'status' => $request->status,
            'observacoes' => $request->observacoes,
        ]);

        // Notifica o autor por email
        // $submissao->autor->notify(new SubmissaoDecidida($submissao));

        $msg = $request->status === 'aceito'
            ? 'Submissão aceita! O autor foi notificado.'
            : 'Submissão rejeitada. O autor foi notificado.';

        return back()->with('success', $msg);
    }
}