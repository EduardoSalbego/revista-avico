<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Revisor;
use App\Models\Submissao;
use App\Models\Parecer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        $revisores = Revisor::where('status', 'ativo')->orderBy('created_at', 'desc')->get();

        $estadoSubmissoes = $submissoes->mapWithKeys(fn($s) => [
            $s->id => [
                'atribuidos' => $s->revisoresAtribuidos->pluck('id')->toArray(),
                'recusados' => $s->pareceres
                    ->filter(fn($p) => $p->aceito_tarefa === false)
                    ->pluck('revisor_id')
                    ->toArray(),
            ]
        ]);

        $todosRevisores = $revisores->map(fn($r) => [
            'id' => $r->id,
            'nome' => $r->user->name,
            'instituicao' => $r->instituicao ?? '',
        ]);

        return view('editor.submissoes.index', compact('submissoes', 'contagens', 'revisores', 'estadoSubmissoes', 'todosRevisores'));
    }

    // Atribuir revisores à submissão
    public function atribuir(Request $request, int $id): RedirectResponse
    {
        $submissao = Submissao::with(['pareceres', 'revisoresAtribuidos'])->findOrFail($id);

        // IDs de revisores que já concluíram parecer — não podem ser alterados
        $bloqueados = $submissao->pareceres
            ->filter(fn($p) => !is_null($p->decisao))
            ->pluck('revisor_id')
            ->toArray();

        $request->validate([
            'revisores' => ['required', 'array', 'min:3', 'max:4'],
            'revisores.*' => ['integer', 'exists:revisores,id'],
        ]);

        $novaEquipe = collect($request->revisores)->map(fn($i) => (int) $i);

        // Garante que os bloqueados estão sempre presentes
        foreach ($bloqueados as $bid) {
            if (!$novaEquipe->contains($bid)) {
                return back()->withErrors([
                    'revisores' => "O revisor #$bid já concluiu o parecer e não pode ser removido.",
                ]);
            }
        }

        DB::transaction(function () use ($submissao, $novaEquipe, $bloqueados) {

            $equipeAtual = $submissao->revisoresAtribuidos->pluck('id');

            // Revisores a adicionar (não estavam antes)
            $adicionar = $novaEquipe->diff($equipeAtual);

            // Revisores a remover (estavam antes, não estão mais e NÃO são bloqueados)
            $remover = $equipeAtual
                ->diff($novaEquipe)
                ->reject(fn($rid) => in_array($rid, $bloqueados));

            // Remove pareceres pendentes dos removidos (que ainda não responderam)
            if ($remover->isNotEmpty()) {
                $submissao->pareceres()
                    ->whereIn('revisor_id', $remover)
                    ->whereNull('decisao') // só pendentes
                    ->delete();

                // Desvincula da tabela pivot
                $submissao->revisoresAtribuidos()->detach($remover->toArray());
            }

            // Adiciona novos revisores e cria parecer inicial
            foreach ($adicionar as $revisorId) {
                $submissao->revisoresAtribuidos()->attach($revisorId);

                Parecer::firstOrCreate(
                    [
                        'submissao_id' => $submissao->id,
                        'revisor_id' => $revisorId,
                    ],
                    [
                        'aceito_tarefa' => null,
                        'decisao' => null,
                    ]
                );
            }

            // Se a submissão ainda estava em 'submetido', avança o status
            if ($submissao->status === 'submetido') {
                $submissao->update(['status' => 'em_revisao']);
            }
        });

        return back()->with('success', 'Equipe de revisão atribuída com sucesso.');
    }

    public function substituirRevisor(Request $request, Submissao $submissao)
    {
        // Pega os IDs de todos que já estão ligados a esse artigo
        $idsJaAlocados = $submissao->revisoresAtribuidos()->pluck('submissao_revisor.revisor_id')->toArray();

        // Validação
        $request->validate([
            'revisor_antigo_id' => 'required|exists:revisores,id',
            'novo_revisor_id' => [
                'required',
                'exists:revisores,id',
                'different:revisor_antigo_id', // Não pode ser o mesmo revisor
                Rule::notIn($idsJaAlocados)    // Não pode ser alguém que já está no artigo
            ]
        ], [
            'novo_revisor_id.not_in' => 'O novo revisor escolhido já faz parte da equipe deste artigo.',
            'novo_revisor_id.different' => 'Você precisa escolher um revisor diferente do atual.',
            'novo_revisor_id.required' => 'Por favor, selecione um revisor substituto.'
        ]);

        // 2. Adiciona o Novo Revisor
        // Faz o UPDATE direto na tabela pivot, substituindo o usuário antigo pelo novo
        // 1. Remove o revisor que recusou da tabela pivot
        $submissao->revisoresAtribuidos()->detach($request->revisor_antigo_id);

        // 2. Adiciona o novo revisor na tabela pivot
        $submissao->revisoresAtribuidos()->attach($request->novo_revisor_id, [
            'status' => 'pendente',
            'atribuido_em' => now(),
        ]);

        return redirect()->back()->with('success', 'Revisor substituído com sucesso! O novo revisor foi notificado.');
    }

    // Aceitar ou rejeitar a submissão
    public function decidir(Request $request, $id)
    {
        $submissao = Submissao::with('autor')->findOrFail($id);

        $request->validate([
            'status' => 'required|in:aceito,rejeitado,major_review,revisao_pontual',
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

        return back()->with('success', 'Status salvo. O autor foi notificado.');
    }
}