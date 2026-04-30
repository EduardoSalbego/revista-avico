<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<body id="page-top" class="bg-light">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Mesa do Editor</h2>
                <p class="text-muted mb-0">Triagem e atribuição de revisores</p>
            </div>

            {{-- Filtro de status --}}
            <div class="d-flex gap-2">
                @foreach(['todos' => 'Todos', 'submetido' => 'Submetidos', 'em_revisao' => 'Em Revisão', 'aceito' => 'Aceitos', 'rejeitado' => 'Rejeitados'] as $valor => $label)
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
                <p class="fs-5 mb-0">Nenhuma submissão encontrada.</p>
            </div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach($submissoes as $submissao)
                    <div class="card p-4 mb-2 shadow-sm border-0">

                        {{-- Cabeçalho --}}
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3 border-bottom pb-3">
                            <div>
                                <h5 class="mb-1 text-primary">Título: {{ $submissao->titulo }}</h5>
                                <small class="text-muted">
                                    Por <strong>{{ $submissao->autor->name }}</strong>
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
                        <p class="text-muted mb-3" style="font-size:0.95rem; text-align: justify;">
                            <strong>Resumo: </strong>{{ Str::limit($submissao->resumo, 320) }}
                        </p>

                        @if(!$submissao->isRejeitado())
                            {{-- Revisores sugeridos pelo autor --}}
                            @if($submissao->revisoresSugeridos->isNotEmpty())
                                <div class="mb-3">
                                    <small class="fw-semibold text-muted">Revisores sugeridos pelo autor:</small>
                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                        @foreach($submissao->revisoresSugeridos as $r)
                                            <span class="badge bg-light text-dark border">{{ $r->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Revisores atribuídos --}}
                            @if($submissao->revisoresAtribuidos->isNotEmpty())
                                <div class="mb-3">
                                    <small class="fw-semibold text-muted">Revisores atribuídos:</small>
                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                        @foreach($submissao->revisoresAtribuidos as $r)
                                            <span class="badge bg-info text-dark shadow-sm">{{ $r->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- AÇÕES DO EDITOR (SÓ APARECEM NA TRIAGEM) --}}
                            @if($submissao->status === 'submetido')
                                <div class="card p-3 mt-2 bg-light border-0">
                                    <div class="row g-3">

                                        {{-- Painel de Atribuição de Revisores com UI de + e - --}}
                                        <div class="col-md-8">
                                            <form action="{{ route('editor.submissoes.atribuir', $submissao->id) }}" method="POST"
                                                id="form-atribuir-{{ $submissao->id }}"
                                                onsubmit="return validarEnvioRevisao({{ $submissao->id }})">
                                                @csrf
                                                @method('PATCH')

                                                <label class="form-label fw-bold small text-primary mb-2">
                                                    Formar Equipe de Revisão
                                                    <span class="text-muted fw-normal">(Selecione de 3 a 4)</span>
                                                </label>

                                                <div class="row g-2">
                                                    {{-- Coluna 1: Disponíveis --}}
                                                    <div class="col-sm-6">
                                                        <div class="border rounded bg-white p-2 shadow-sm"
                                                            style="height: 160px; overflow-y: auto;">
                                                            <small
                                                                class="d-block text-muted mb-2 fw-bold border-bottom pb-1">Disponíveis</small>
                                                            <div id="lista-disp-{{ $submissao->id }}" class="d-flex flex-column gap-1">
                                                                @foreach($revisores as $revisor)
                                                                    <div class="d-flex justify-content-between align-items-center bg-light border rounded px-2 py-1"
                                                                        id="item-disp-{{ $submissao->id }}-{{ $revisor->id }}">
                                                                        <span class="small text-truncate" style="max-width: 130px;"
                                                                            title="{{ $revisor->name }}">{{ $revisor->name }}</span>
                                                                        <button type="button"
                                                                            class="btn btn-sm btn-outline-success border-0 py-0 px-2"
                                                                            onclick="adicionarRevisor({{ $submissao->id }}, {{ $revisor->id }}, '{{ addslashes($revisor->name) }}')"
                                                                            title="Adicionar">
                                                                            <i class="fas fa-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Coluna 2: Selecionados --}}
                                                    <div class="col-sm-6">
                                                        <div class="border rounded bg-white p-2 shadow-sm"
                                                            style="height: 160px; overflow-y: auto;">
                                                            <small
                                                                class="d-block text-muted mb-2 fw-bold border-bottom pb-1">Selecionados</small>
                                                            <div id="lista-sel-{{ $submissao->id }}" class="d-flex flex-column gap-1">
                                                                {{-- JS vai popular os revisores escolhidos aqui --}}
                                                            </div>
                                                            {{-- Inputs ocultos para enviar o POST --}}
                                                            <div id="inputs-ocultos-{{ $submissao->id }}"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-end mt-3">
                                                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                                        <i class="fas fa-paper-plane me-1"></i> Confirmar e Enviar para Revisão
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        {{-- Rejeitar de cara na Triagem --}}
                                        <div class="col-md-4 border-start">
                                            <label class="form-label fw-bold small text-danger">Rejeitar na Triagem</label>
                                            <form action="{{ route('editor.submissoes.decidir', $submissao->id) }}" method="POST"
                                                onsubmit="return confirm('Tem certeza que deseja rejeitar esta submissão direto da triagem? O autor será notificado.')">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejeitado">
                                                <textarea name="observacoes" class="form-control form-control-sm mb-3 shadow-sm"
                                                    rows="5" placeholder="Motivo da rejeição (obrigatório)..." required></textarea>
                                                <button type="submit" class="btn btn-outline-danger w-100 shadow-sm">
                                                    <i class="fas fa-times me-1"></i> Rejeitar Artigo
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            @endif

                            {{-- Se estiver Em Revisão: Mostra o painel trancado --}}
                            @if($submissao->status === 'em_revisao')
                                @if(!$submissao->todosRevisoresResponderam())
                                    <div class="alert alert-info py-3 mt-3 mb-0 shadow-sm border-0 d-flex align-items-center">
                                        <i class="fas fa-lock fs-4 me-3 text-info"></i>
                                        <div>
                                            <strong>Em processo de revisão duplo-cego.</strong><br>
                                            <span class="small">A equipe de revisores foi definida e notificada. A plataforma está
                                                aguardando o envio dos pareceres para liberar a decisão final.</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="mt-3 d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clipboard-check fs-4 me-3 text-success"></i>
                                            <div>
                                                <strong>Revisões concluídas</strong><br>
                                                <span class="small text-muted">
                                                    Todos os revisores já enviaram seus pareceres. A submissão está pronta para decisão
                                                    editorial.
                                                </span>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            onclick="togglePareceres({{ $submissao->id }})">
                                            <i class="fas fa-eye me-1"></i>
                                            <span id="btn-label-{{ $submissao->id }}">Ver pareceres e decidir</span>
                                        </button>
                                    </div>
                                    {{-- Painel oculto por padrão --}}
                                    <div id="painel-pareceres-{{ $submissao->id }}"
                                        class="card p-4 mt-3 bg-white shadow-sm border-primary border-top border-3" style="display: none;">

                                        <h6 class="text-primary mb-3">
                                            <i class="fas fa-clipboard-list me-2"></i>Pareceres Recebidos
                                        </h6>

                                        {{-- Lista de Pareceres --}}
                                        <div class="row g-3 mb-4">
                                            @foreach($submissao->pareceres()->where('aceito_tarefa', true)->whereNotNull('decisao')->with('revisor')->get() as $parecer)
                                                <div class="col-md-6">
                                                    <div class="card bg-light border-0 shadow-sm h-100">
                                                        <div class="card-body p-3">
                                                            <h6 class="card-title text-dark mb-1 fs-6">
                                                                <i class="fas fa-user-check text-success me-1"></i>
                                                                {{ $parecer->revisor->name }}
                                                            </h6>

                                                            {!! $parecer->badgeDecisao() !!}

                                                            <p class="card-text text-muted mb-0"
                                                                style="font-size: 0.85rem; text-align: justify;">
                                                                <strong>Parecer:</strong>
                                                                {{ $parecer->comentario ?? 'Sem comentário fornecido.' }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="p-3 bg-light rounded border">
                                            <h6 class="text-dark mb-3">
                                                <i class="fas fa-gavel me-2"></i>Decisão Final do Editor
                                            </h6>

                                            <form action="{{ route('editor.submissoes.decidir', $submissao->id) }}" method="POST"
                                                onsubmit="return confirm('Confirmar a decisão final? O autor será notificado.')">
                                                @csrf
                                                @method('PATCH')

                                                <div class="row g-3">

                                                    {{-- Feedback (full width) --}}
                                                    <div class="col-12">
                                                        <label class="form-label small fw-bold text-muted mb-1">
                                                            Feedback ao Autor
                                                            <span id="obrig-feedback-{{ $submissao->id }}" class="text-danger"
                                                                style="display:none;">*</span>
                                                        </label>
                                                        <textarea name="observacoes" id="feedback-{{ $submissao->id }}"
                                                            class="form-control shadow-sm" rows="4"
                                                            placeholder="Sintetize os principais pontos dos pareceres e justifique a decisão editorial..."></textarea>
                                                    </div>

                                                    {{-- Linha de baixo: Veredito + Botão --}}
                                                    <div class="col-md-4">
                                                        <label class="form-label small fw-bold text-muted mb-1">Veredito</label>
                                                        <select name="status" class="form-select shadow-sm" required
                                                            id="veredito-{{ $submissao->id }}"
                                                            onchange="atualizarPlaceholder({{ $submissao->id }}, this.value)">
                                                            <option value="" disabled selected>Selecione...</option>
                                                            <option value="aceito">Aceitar</option>
                                                            <option value="rejeitado">Rejeitar</option>
                                                            <option value="major_review">Major Review</option>
                                                            <option value="aceito">Revisão Pontual</option>
                                                        </select>
                                                        <small id="desc-veredito-{{ $submissao->id }}"
                                                            class="text-muted mt-1 d-block"></small>
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


                            {{-- Observações salvas --}}
                            @if($submissao->observacoes)
                                <div class="alert alert-light border py-2 mb-3">
                                    <small class="fw-semibold text-danger"><i class="fas fa-exclamation-circle"></i> Observação
                                        registrada:</small>
                                    <p class="mb-0 small mt-1">{{ $submissao->observacoes }}</p>
                                </div>
                            @endif

                            {{-- DOCX enviado --}}
                            @if($submissao->isAceito() && $submissao->arquivo_docx)
                                <div
                                    class="alert alert-success py-3 mt-3 mb-0 d-flex justify-content-between align-items-center shadow-sm border-0">
                                    <span><i class="fas fa-file-word fs-5 me-2"></i> <strong>Versão final em DOCX
                                            disponível</strong></span>
                                    <a href="{{ asset('storage/' . $submissao->arquivo_docx) }}" download
                                        class="btn btn-success px-4 shadow-sm">
                                        Baixar Arquivo Final
                                    </a>
                                </div>
                            @elseif($submissao->isAceito())
                                <div class="alert alert-warning py-3 mt-3 mb-0 shadow-sm border-0">
                                    <i class="fas fa-hourglass-half me-2"></i> ⏳ Aguardando o autor enviar a versão final em DOCX
                                    formatada.
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

    @include('layouts.footer')

    {{-- LÓGICA DE SELEÇÃO DOS REVISORES (+ / -) --}}
    <script>
        // Dicionário para rastrear os revisores selecionados de cada submissão na tela
        const selecoesPorSubmissao = {};

        function inicializarSubmissao(subId) {
            if (!selecoesPorSubmissao[subId]) {
                selecoesPorSubmissao[subId] = [];
            }
        }

        // Adiciona um revisor (+)
        function adicionarRevisor(subId, revisorId, revisorNome) {
            inicializarSubmissao(subId);

            // Verifica os limites
            if (selecoesPorSubmissao[subId].includes(revisorId)) return;
            if (selecoesPorSubmissao[subId].length >= 4) {
                alert('Você já selecionou o limite máximo de 4 revisores para este artigo.');
                return;
            }

            // Registra a seleção
            selecoesPorSubmissao[subId].push(revisorId);

            // 1. Oculta o revisor da lista de "Disponíveis"
            document.getElementById(`item-disp-${subId}-${revisorId}`).style.display = 'none';

            // 2. Cria o elemento na lista de "Selecionados" (cor azul para dar destaque)
            const listaSel = document.getElementById(`lista-sel-${subId}`);
            const itemHTML = `
                <div class="d-flex justify-content-between align-items-center bg-primary text-white border border-primary rounded px-2 py-1" id="item-sel-${subId}-${revisorId}">
                    <span class="small text-truncate" style="max-width: 130px;" title="${revisorNome}">${revisorNome}</span>
                    <button type="button" class="btn btn-sm btn-primary text-white border-0 py-0 px-2" onclick="removerRevisor(${subId}, ${revisorId})" title="Remover">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            `;
            listaSel.insertAdjacentHTML('beforeend', itemHTML);

            // 3. Cria o input oculto para o <form> enviar o dado no formato array: name="revisores[]"
            const containerInputs = document.getElementById(`inputs-ocultos-${subId}`);
            const inputHTML = `<input type="hidden" name="revisores[]" value="${revisorId}" id="input-oculto-${subId}-${revisorId}">`;
            containerInputs.insertAdjacentHTML('beforeend', inputHTML);
        }

        // Remove um revisor (-)
        function removerRevisor(subId, revisorId) {
            // Remove do array de rastreamento
            selecoesPorSubmissao[subId] = selecoesPorSubmissao[subId].filter(id => id !== revisorId);

            // 1. Mostra de novo na lista de "Disponíveis"
            document.getElementById(`item-disp-${subId}-${revisorId}`).style.display = 'flex';

            // 2. Remove o item visual da lista de "Selecionados"
            document.getElementById(`item-sel-${subId}-${revisorId}`).remove();

            // 3. Remove o input oculto
            document.getElementById(`input-oculto-${subId}-${revisorId}`).remove();
        }

        // Validação final ao clicar em "Enviar para Revisão"
        function validarEnvioRevisao(subId) {
            const quantidadeSelecionada = selecoesPorSubmissao[subId] ? selecoesPorSubmissao[subId].length : 0;

            if (quantidadeSelecionada < 3) {
                alert(`Atenção: Você precisa selecionar pelo menos 3 revisores. Você selecionou apenas ${quantidadeSelecionada}.`);
                return false; // Impede o envio do form
            }

            return confirm('Tem certeza que deseja fechar a equipe e enviar este artigo para revisão? Esta ação não pode ser desfeita.');
        }

        // Executa assim que a página carrega: Se já houver revisores salvos no banco, move eles pro lado direito automaticamente
        document.addEventListener('DOMContentLoaded', function () {
            @foreach($submissoes as $submissao)
                @if($submissao->status === 'submetido')
                    @foreach($submissao->revisoresAtribuidos as $r)
                        adicionarRevisor({{ $submissao->id }}, {{ $r->id }}, '{{ addslashes($r->name) }}');
                    @endforeach
                @endif
            @endforeach
        });

        function togglePareceres(id) {
            const painel = document.getElementById(`painel-pareceres-${id}`);
            const label = document.getElementById(`btn-label-${id}`);
            const aberto = painel.style.display !== 'none';
            painel.style.display = aberto ? 'none' : 'block';
            label.textContent = aberto ? 'Ver Pareceres e Decidir' : 'Ocultar Pareceres';
        }

        const descricoes = {
            aceito: 'O artigo será aceito para publicação.',
            rejeitado: 'O artigo será rejeitado e o autor notificado.',
            major_review: 'O autor deverá corrigir pontos e resubmeter o PDF para nova rodada de revisão.',
            revisao_pontual: 'Aceito, mas o autor fará ajustes pontuais na versão final (DOCX).',
        };

        function atualizarPlaceholder(id, valor) {
            const desc = document.getElementById(`desc-veredito-${id}`);
            const obrig = document.getElementById(`obrig-feedback-${id}`);
            const textarea = document.getElementById(`feedback-${id}`);

            desc.textContent = descricoes[valor] ?? '';

            const precisaFeedback = ['rejeitado', 'major_review', 'revisao_pontual'].includes(valor);
            obrig.style.display = precisaFeedback ? 'inline' : 'none';
            textarea.required = precisaFeedback;
            textarea.placeholder = precisaFeedback
                ? 'Obrigatório: descreva os pontos a corrigir ou o motivo da rejeição...'
                : 'Sintetize os pareceres ou justifique sua decisão...';
        }

    </script>
</body>

</html>