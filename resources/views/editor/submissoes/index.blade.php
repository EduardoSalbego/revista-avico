<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<style>
.substituto-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    border: 1.5px solid #dee2e6;
    border-radius: 8px;
    cursor: pointer;
    transition: border-color .18s, background .18s;
    background: #fff;
}
.substituto-item:hover { border-color: #0d6efd; background: #f0f4ff; }
.substituto-item.selecionado { border-color: #0d6efd; background: #e8f0fe; }
.substituto-item input[type="radio"] { display: none; }
.sub-check {
    width: 18px; height: 18px;
    border: 2px solid #dee2e6; border-radius: 50%;
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    transition: all .18s;
}
.substituto-item.selecionado .sub-check {
    background: #0d6efd; border-color: #0d6efd;
}
.substituto-item.selecionado .sub-check::after {
    content: ''; width: 8px; height: 8px;
    background: #fff; border-radius: 50%; display: block;
}
.sub-nome { font-size: 14px; font-weight: 500; color: #1a1a2e; }
.sub-inst { font-size: 12px; color: #6c757d; }
</style>

<body id="page-top" class="bg-light">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Mesa do Editor</h2>
                <p class="text-muted mb-0">Triagem e atribuicao de revisores</p>
            </div>
            <div class="d-flex gap-2">
                @foreach(['todos' => 'Todos', 'submetido' => 'Submetidos', 'em_revisao' => 'Em Revisao', 'aceito' => 'Aceitos', 'rejeitado' => 'Rejeitados'] as $valor => $label)
                    <a href="{{ route('editor.submissoes.index', ['status' => $valor]) }}"
                        class="btn btn-sm {{ request('status', 'todos') === $valor ? 'btn-primary' : 'btn-outline-secondary' }}">
                        {{ $label }}
                        @if($contagens[$valor] ?? false)
                            <span class="badge bg-white text-dark ms-1">{{ $contagens[$valor] }}</span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
        @endif

        @if($submissoes->isEmpty())
            <div class="text-center py-5 text-muted bg-white shadow-sm rounded">
                <p class="fs-5 mb-0">Nenhuma submissao encontrada.</p>
            </div>
        @else

            <div class="d-flex flex-column gap-3">
                @foreach($submissoes as $submissao)
                    @php
                        $pareceres = $submissao->pareceres;
                        $bloqueados = $pareceres->filter(fn($p) => !is_null($p->decisao))->pluck('revisor_id')->toArray();
                        $recusados  = $pareceres->filter(fn($p) => $p->aceito_tarefa === false)->pluck('revisor_id')->toArray();
                        $recusas    = $submissao->revisoresAtribuidos->filter(fn($r) => in_array($r->id, $recusados));
                        $todosResponderam = $submissao->todosRevisoresResponderam();
                    @endphp

                    <div class="card p-4 mb-2 shadow-sm border-0">

                        {{-- Cabecalho --}}
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3 border-bottom pb-3">
                            <div>
                                <h5 class="mb-1 text-primary">{{ $submissao->titulo }}</h5>
                                <small class="text-muted">
                                    Por <strong>{{ $submissao->autor->nome }}</strong>
                                    · {{ $submissao->created_at->format('d/m/Y') }}
                                </small>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                {!! $submissao->badgeStatus() !!}
                                <a href="{{ asset('storage/' . $submissao->arquivo_pdf) }}" download
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-download"></i> Baixar PDF
                                </a>
                            </div>
                        </div>

                        {{-- Resumo --}}
                        <p class="text-muted mb-3" style="font-size:.95rem; text-align:justify;">
                            <strong>Resumo: </strong>{{ Str::limit($submissao->resumo, 320) }}
                        </p>

                        @if(!$submissao->isRejeitado())

                            {{-- ── Revisores sugeridos ── --}}
                            @if($submissao->revisoresSugeridos->isNotEmpty())
                                <div class="mb-3">
                                    <small class="fw-semibold text-muted">Revisores sugeridos:</small>
                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                        @foreach($submissao->revisoresSugeridos as $sugerido)
                                            @if($sugerido->revisor)
                                                <span class="badge bg-primary shadow-sm">
                                                    {{ $sugerido->revisor->user->name }}
                                                </span>
                                            @else
                                                <span class="badge bg-warning text-dark shadow-sm">
                                                    {{ $sugerido->nome }}
                                                    @if($sugerido->email) · {{ $sugerido->email }} @endif
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- ── Revisores designados ── --}}
                            @if($submissao->revisoresAtribuidos->isNotEmpty())
                                <div class="mb-3">
                                    <small class="fw-semibold text-muted d-block mb-2">Revisores designados:</small>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($submissao->revisoresAtribuidos as $r)
                                            @php
                                                $p          = $pareceres->firstWhere('revisor_id', $r->id);
                                                $jaRevisou  = $p && !is_null($p->decisao);
                                                $recusou    = $p && $p->aceito_tarefa === false;
                                                $aguardando = !$p || is_null($p->aceito_tarefa);
                                                $revisando  = $p && $p->aceito_tarefa === true && is_null($p->decisao);
                                                $podeSubst  = $submissao->status === 'em_revisao' && !$jaRevisou;
                                            @endphp
                                            <div class="d-inline-flex align-items-center gap-1">

                                                @if($jaRevisou)
                                                    <span class="badge bg-success shadow-sm" title="Revisao concluida">
                                                        <i class="fas fa-check me-1"></i>{{ $r->user->name }}
                                                    </span>
                                                @elseif($recusou)
                                                    <span class="badge bg-danger shadow-sm" title="Recusou a tarefa">
                                                        <i class="fas fa-times me-1"></i>{{ $r->user->name }}
                                                    </span>
                                                @elseif($aguardando)
                                                    <span class="badge bg-warning text-dark shadow-sm" title="Aguardando aceite">
                                                        <i class="fas fa-clock me-1"></i>{{ $r->user->name }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-info text-dark shadow-sm" title="Em revisao">
                                                        <i class="fas fa-pen me-1"></i>{{ $r->user->name }}
                                                    </span>
                                                @endif

                                                @if($podeSubst)
                                                    <button type="button"
                                                        class="btn btn-sm py-0 px-2 {{ $recusou ? 'btn-danger' : 'btn-outline-secondary' }}"
                                                        style="font-size:11px;"
                                                        onclick="abrirModalSubstituicao({{ $submissao->id }}, {{ $r->id }}, '{{ addslashes($r->user->name) }}')">
                                                        <i class="fas fa-user-edit"></i> Substituir
                                                    </button>
                                                @endif

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- ── Alerta de recusas pendentes ── --}}
                            @if($recusas->isNotEmpty() && $submissao->status === 'em_revisao')
                                <div class="alert alert-danger d-flex align-items-center gap-3 mt-2 mb-3 shadow-sm border-0">
                                    <i class="fas fa-user-times fs-4 text-danger flex-shrink-0"></i>
                                    <div>
                                        <strong>
                                            {{ $recusas->count() === 1 ? '1 revisor recusou' : $recusas->count().' revisores recusaram' }} a tarefa.
                                        </strong>
                                        <p class="mb-0 small mt-1">
                                            Clique em <strong>"Substituir"</strong> ao lado do nome para designar um substituto.
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{-- ════════════════════════════
                                 TRIAGEM: primeira atribuicao
                            ════════════════════════════ --}}
                            @if($submissao->status === 'submetido')
                                <div class="card p-3 mt-2 bg-light border-0">
                                    <div class="row g-3">
                                        <div class="col-md-8">
                                            @include('editor.submissoes._painel_atribuicao', [
                                                'submissao'     => $submissao,
                                                'revisores'     => $revisores,
                                                'bloqueados'    => [],
                                                'recusados'     => [],
                                                'rotaForm'      => route('editor.submissoes.atribuir', $submissao->id),
                                                'labelBtn'      => 'Confirmar e Enviar para Revisao',
                                                'preCarregados' => [],
                                            ])
                                        </div>
                                        <div class="col-md-4 border-start">
                                            <label class="form-label fw-bold small text-danger">Rejeitar na Triagem</label>
                                            <form action="{{ route('editor.submissoes.decidir', $submissao->id) }}" method="POST"
                                                onsubmit="return confirm('Rejeitar esta submissao direto da triagem?')">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejeitado">
                                                <textarea name="observacoes" class="form-control form-control-sm mb-3 shadow-sm"
                                                    rows="5" placeholder="Motivo da rejeicao (obrigatorio)..." required></textarea>
                                                <button type="submit" class="btn btn-outline-danger w-100 shadow-sm">
                                                    <i class="fas fa-times me-1"></i> Rejeitar Artigo
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- ════════════════════════════
                                 EM REVISAO
                            ════════════════════════════ --}}
                            @if($submissao->status === 'em_revisao')

                                {{-- Aguardando pareceres --}}
                                @if(!$todosResponderam && $recusas->isEmpty())
                                    <div class="alert alert-info py-3 mt-3 mb-0 shadow-sm border-0 d-flex align-items-center">
                                        <i class="fas fa-lock fs-4 me-3 text-info"></i>
                                        <div>
                                            <strong>Em processo de revisao duplo-cego.</strong><br>
                                            <span class="small">A equipe foi notificada. Aguardando envio dos pareceres.</span>
                                        </div>
                                    </div>
                                @endif

                                {{-- Todos responderam: decisao editorial --}}
                                @if($todosResponderam)
                                    <div class="mt-3 d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clipboard-check fs-4 me-3 text-success"></i>
                                            <div>
                                                <strong>Revisoes concluidas</strong><br>
                                                <span class="small text-muted">Todos os revisores enviaram seus pareceres.</span>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            onclick="togglePareceres({{ $submissao->id }})">
                                            <i class="fas fa-eye me-1"></i>
                                            <span id="btn-label-{{ $submissao->id }}">Ver pareceres e decidir</span>
                                        </button>
                                    </div>

                                    <div id="painel-pareceres-{{ $submissao->id }}"
                                        class="card p-4 mt-3 bg-white shadow-sm border-primary border-top border-3"
                                        style="display:none;">

                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-clipboard-list me-2"></i>Pareceres Recebidos
                                        </h6>

                                        <div class="row g-3 mb-4">
                                            @foreach($submissao->pareceres()->where('aceito_tarefa', true)->whereNotNull('decisao')->with('revisor.user')->get() as $parecer)
                                                <div class="col-md-6">
                                                    <div class="card bg-light border-0 shadow-sm h-100">
                                                        <div class="card-body p-3">
                                                            <h6 class="card-title text-dark mb-1 fs-6">
                                                                <i class="fas fa-user-check text-success me-1"></i>
                                                                {{ $parecer->revisor->user->name }}
                                                            </h6>
                                                            {!! $parecer->badgeDecisao() !!}
                                                            <p class="card-text text-muted mb-0 mt-2"
                                                                style="font-size:.85rem; text-align:justify;">
                                                                <strong>Parecer:</strong>
                                                                {{ $parecer->comentario ?? 'Sem comentario fornecido.' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="p-3 bg-light rounded border">
                                            <h6 class="text-dark mb-3">
                                                <i class="fas fa-gavel me-2"></i>Decisao Final do Editor
                                            </h6>
                                            <form action="{{ route('editor.submissoes.decidir', $submissao->id) }}" method="POST"
                                                onsubmit="return confirm('Confirmar a decisao final? O autor sera notificado.')">
                                                @csrf
                                                @method('PATCH')
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label class="form-label small fw-bold text-muted mb-1">Feedback ao Autor</label>
                                                        <textarea name="observacoes" class="form-control shadow-sm" rows="4"
                                                            placeholder="Sintetize os pareceres e justifique a decisao editorial..."></textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label small fw-bold text-muted mb-1">Veredito</label>
                                                        <select name="status" class="form-select shadow-sm" required>
                                                            <option value="" disabled selected>Selecione...</option>
                                                            <option value="aceito">Aceitar</option>
                                                            <option value="rejeitado">Rejeitar</option>
                                                            <option value="major_review">Major Review</option>
                                                            <option value="minor_review">Revisao Pontual</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-8 d-flex align-items-end justify-content-end">
                                                        <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                                            <i class="fas fa-check-circle me-1"></i> Concluir e Notificar Autor
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                @endif

                            @endif

                            {{-- Observacoes salvas --}}
                            @if($submissao->observacoes)
                                <div class="alert alert-light border py-2 mb-0 mt-3">
                                    <small class="fw-semibold text-danger">
                                        <i class="fas fa-exclamation-circle"></i> Observacao registrada:
                                    </small>
                                    <p class="mb-0 small mt-1">{{ $submissao->observacoes }}</p>
                                </div>
                            @endif

                            {{-- DOCX --}}
                            @if($submissao->isAceito() && $submissao->arquivo_docx)
                                <div class="alert alert-success py-3 mt-3 mb-0 d-flex justify-content-between align-items-center shadow-sm border-0">
                                    <span><i class="fas fa-file-word fs-5 me-2"></i><strong>Versao final em DOCX disponivel</strong></span>
                                    <a href="{{ asset('storage/' . $submissao->arquivo_docx) }}" download class="btn btn-success px-4 shadow-sm">
                                        Baixar Arquivo Final
                                    </a>
                                </div>
                            @elseif($submissao->isAceito())
                                <div class="alert alert-warning py-3 mt-3 mb-0 shadow-sm border-0">
                                    <i class="fas fa-hourglass-half me-2"></i> Aguardando o autor enviar a versao final em DOCX.
                                </div>
                            @endif

                        @endif

                    </div>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $submissoes->links() }}
            </div>

        @endif

    </main>

    {{-- ════════════════════════════════════════════
         MODAL DE SUBSTITUICAO (renderizado uma vez)
    ════════════════════════════════════════════ --}}
    <div class="modal fade" id="modalSubstituicao" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title">Substituir Revisor</h5>
                        <p class="text-muted small mb-0" id="modal-sub-descricao"></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="form-substituicao" action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="revisor_antigo_id" id="modal-sub-substituir-id">
                    <input type="hidden" name="novo_revisor_id" id="modal-sub-substituto-id">
                    <div class="modal-body pt-3">

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">
                                Revisor sendo substituido
                            </label>
                            <div class="d-flex align-items-center gap-2 p-2
                                        bg-danger bg-opacity-10 border border-danger rounded">
                                <i class="fas fa-user-times text-danger"></i>
                                <span id="modal-sub-nome-antigo" class="fw-semibold text-danger"></span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="form-label fw-bold small text-muted text-uppercase">
                                Escolha o substituto
                            </label>
                            <div id="modal-lista-substitutos" class="d-flex flex-column gap-2"></div>
                            <div id="modal-sem-substitutos" class="alert alert-warning small py-2 mt-2" style="display:none;">
                                Nenhum revisor disponivel para substituicao no momento.
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary" id="modal-sub-btn-confirmar" disabled>
                            <i class="fas fa-check me-1"></i> Confirmar Substituicao
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <script>
    // ════════════════════════════════════════════════════════
    // DADOS INJETADOS PELO BLADE
    // ════════════════════════════════════════════════════════
    const estadoSubmissoes = @json($estadoSubmissoes);
    const todosRevisores   = @json($todosRevisores);
    const _recusadosPorSid = {};

    function registrarRecusados(sid, ids) {
        _recusadosPorSid[sid] = ids;
    }

    const _equipes = {};

    function _getEquipe(sid) {
        if (!_equipes[sid]) _equipes[sid] = {};
        return _equipes[sid];
    }

    function adicionarRevisor(sid, id, nome, silencioso = false) {
        if ((_recusadosPorSid[sid] ?? []).includes(id)) {
            if (!silencioso) alert('Este revisor recusou esta submissao e nao pode ser designado novamente.');
            return;
        }
        const equipe = _getEquipe(sid);
        if (equipe[id]) return;
        if (Object.keys(equipe).length >= 4) {
            if (!silencioso) alert('Limite de 4 revisores por submissao.');
            return;
        }
        equipe[id] = nome;
        _renderEquipe(sid);
        const el = document.getElementById(`item-disp-${sid}-${id}`);
        if (el) el.style.display = 'none';
    }

    function removerRevisor(sid, id) {
        const equipe = _getEquipe(sid);
        delete equipe[id];
        _renderEquipe(sid);
        const el = document.getElementById(`item-disp-${sid}-${id}`);
        if (el) el.style.display = 'flex';
    }

    function _renderEquipe(sid) {
        const equipe    = _getEquipe(sid);
        const listaSel  = document.getElementById(`lista-sel-${sid}`);
        const inputsDiv = document.getElementById(`inputs-ocultos-${sid}`);
        if (!listaSel) return;

        listaSel.innerHTML  = '';
        inputsDiv.innerHTML = '';

        Object.entries(equipe).forEach(([id, nome]) => {
            const div = document.createElement('div');
            div.className = 'd-flex justify-content-between align-items-center bg-light border rounded px-2 py-1';
            div.innerHTML = `
                <span class="small text-truncate" style="max-width:130px;" title="${nome}">${nome}</span>
                <button type="button" class="btn btn-sm btn-outline-danger border-0 py-0 px-2"
                    onclick="removerRevisor(${sid}, ${id})" title="Remover">
                    <i class="fas fa-minus"></i>
                </button>`;
            listaSel.appendChild(div);

            const input = document.createElement('input');
            input.type  = 'hidden';
            input.name  = 'revisores[]';
            input.value = id;
            inputsDiv.appendChild(input);
        });
    }

    function validarEnvioRevisao(sid) {
        // Conta selecionados via JS + bloqueados fixos (inputs hidden ja no form)
        const jsCount   = Object.keys(_getEquipe(sid)).length;
        const fixos     = document.querySelectorAll(
            `#form-atribuir-${sid} .bg-success input[name="revisores[]"]`
        ).length;
        const total = jsCount + fixos;
        if (total < 3 || total > 4) {
            alert(`Selecione entre 3 e 4 revisores. Atualmente: ${total}.`);
            return false;
        }
        return true;
    }

    // ════════════════════════════════════════════════════════
    // MODAL DE SUBSTITUICAO (um revisor por vez)
    // ════════════════════════════════════════════════════════

    window.abrirModalSubstituicao = function(submissaoId, substituirId, nomeAntigo) {
        // Preenche cabecalho
        document.getElementById('modal-sub-descricao').textContent  = `Submissao #${submissaoId}`;
        document.getElementById('modal-sub-nome-antigo').textContent = nomeAntigo;
        document.getElementById('modal-sub-substituir-id').value     = substituirId;
        document.getElementById('modal-sub-substituto-id').value     = '';
        document.getElementById('modal-sub-btn-confirmar').disabled  = true;

        // Quem nao pode ser escolhido:
        // - o proprio revisor sendo substituido
        // - demais ja atribuidos a esta submissao (exceto o que esta saindo)
        // - quem ja recusou esta submissao
        const estado    = estadoSubmissoes[submissaoId] ?? { atribuidos: [], recusados: [] };
        const excluidos = new Set([
            substituirId,
            ...estado.atribuidos.filter(id => id !== substituirId),
            ...estado.recusados,
        ]);

        const form = document.getElementById('form-substituicao');
        form.action = `/editor/submissoes/${submissaoId}/substituir-revisor`;

        const disponiveis = todosRevisores.filter(r => !excluidos.has(r.id));

        const lista = document.getElementById('modal-lista-substitutos');
        const aviso = document.getElementById('modal-sem-substitutos');
        lista.innerHTML = '';

        if (!disponiveis.length) {
            aviso.style.display = 'block';
        } else {
            aviso.style.display = 'none';
            disponiveis.forEach(r => {
                const label = document.createElement('label');
                label.className = 'substituto-item';
                label.innerHTML = `
                    <input type="radio" name="__sub_visual" value="${r.id}">
                    <div class="sub-check"></div>
                    <div class="flex-grow-1">
                        <div class="sub-nome">${r.nome}</div>
                        ${r.instituicao ? `<div class="sub-inst"><i class="fas fa-university me-1"></i>${r.instituicao}</div>` : ''}
                    </div>`;
                label.addEventListener('click', () => _selecionarSubstituto(r.id, label));
                lista.appendChild(label);
            });
        }

        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('modalSubstituicao')
        ).show();
    };

    function _selecionarSubstituto(id, el) {
        document.querySelectorAll('.substituto-item').forEach(i => i.classList.remove('selecionado'));
        el.classList.add('selecionado');
        document.getElementById('modal-sub-substituto-id').value    = id;
        document.getElementById('modal-sub-btn-confirmar').disabled = false;
    }

    document.getElementById('modalSubstituicao').addEventListener('hidden.bs.modal', () => {
        document.getElementById('modal-lista-substitutos').innerHTML = '';
        document.getElementById('modal-sub-btn-confirmar').disabled  = true;
    });

    // ════════════════════════════════════════════════════════
    // UTILITARIOS
    // ════════════════════════════════════════════════════════

    function togglePareceres(id) {
        const painel = document.getElementById(`painel-pareceres-${id}`);
        const label  = document.getElementById(`btn-label-${id}`);
        const aberto = painel.style.display !== 'none';
        painel.style.display = aberto ? 'none' : 'block';
        if (label) label.textContent = aberto ? 'Ver pareceres e decidir' : 'Ocultar pareceres';
    }
    </script>

</body>
</html>