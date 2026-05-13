<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<style>
    /* ── Referências dinâmicas ── */
    .ref-item {
        display: flex;
        gap: 8px;
        align-items: flex-start;
        margin-bottom: 8px;
    }

    .ref-item textarea {
        resize: vertical;
        min-height: 60px;
        font-size: 13px;
    }

    .ref-num {
        min-width: 24px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 600;
        color: #6c757d;
        padding-top: 6px;
    }

    /* ── Keyword pills ── */
    .kw-group {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 8px;
    }

    @media (max-width: 576px) {
        .kw-group {
            grid-template-columns: 1fr 1fr;
        }
    }

    /* ── Contador de referências ── */
    .ref-counter {
        font-size: 12px;
        color: #6c757d;
    }

    /* ── Seção do modal ── */
    .modal-section-title {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 10px;
        padding-bottom: 6px;
        border-bottom: 1px solid #dee2e6;
    }
</style>

<body id="page-top">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Minhas Submissões</h2>
                <p class="text-muted mb-0">Acompanhe o status dos seus artigos enviados.</p>
            </div>
            <a href="{{ route('autor.submissoes.create') }}" class="btn btn-primary">
                + Submeter Artigo
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($submissoes->isEmpty())
            <div class="text-center py-5">
                <p class="fs-6 text-secondary">Você não submeteu um artigo.</p>
            </div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach ($submissoes as $submissao)
                    <div
                        class="card p-4 mb-2 {{ $submissao->status === 'major_review' ? 'border-warning border-2' : '' }}">

                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <h5 class="mb-1">{{ $submissao->titulo }}</h5>
                                <small class="text-muted">
                                    Enviado em {{ $submissao->created_at->format('d/m/Y') }}
                                </small>
                                @if ($submissao->arquivo_pdf_revisado)
                                    <span class="badge bg-warning text-dark ms-2">
                                        🔄 Resubmissão após Major Review
                                    </span>
                                @endif
                            </div>
                            @if ($submissao->artigoEnviado())
                                <span class="badge bg-success">Artigo Enviado</span>
                            @else
                                {!! $submissao->badgeStatus() !!}
                            @endif
                        </div>

                        <p class="text-muted mt-3 mb-2" style="font-size: 0.95rem;">
                            {{ Str::limit($submissao->resumo, 200) }}
                        </p>

                        {{-- Revisores sugeridos --}}
                        @if ($submissao->revisoresSugeridos->isNotEmpty())
                            <div class="mb-2">
                                <small class="text-muted fw-semibold">Revisores sugeridos: </small>
                                @foreach ($submissao->revisoresSugeridos as $revisor)
                                    <span class="badge bg-light text-dark border">
                                        {{ $revisor->revisor?->user->name ?? $revisor->nome }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Observações do editor --}}
                        @if ($submissao->observacoes && !$submissao->artigoEnviado())
                            <div class="alert alert-info py-2 mt-3 mb-2">
                                <strong>Observação do editor:</strong> {{ $submissao->observacoes }}
                            </div>
                        @endif

                        {{-- MAJOR REVIEW --}}
                        @if ($submissao->status === 'major_review')
                            <div class="alert alert-warning mt-3 mb-0 border-warning">
                                <div class="d-flex align-items-start gap-2 mb-3">
                                    <span style="font-size:1.4rem;">🔄</span>
                                    <div>
                                        <strong>Revisão Maior Solicitada</strong><br>
                                        <span class="small">
                                            Os revisores solicitaram correções significativas. Corrija seu artigo
                                            conforme o feedback acima e reenvie o PDF revisado.
                                        </span>
                                    </div>
                                </div>
                                <form action="{{ route('autor.submissoes.resubmeter', $submissao->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex gap-2 align-items-start flex-wrap">
                                        <div class="flex-grow-1">
                                            <input type="file"
                                                class="form-control form-control-sm @error('arquivo_pdf_revisado') is-invalid @enderror"
                                                name="arquivo_pdf_revisado" accept="application/pdf" required>
                                            <div class="form-text">Apenas PDF. Máximo 20MB.</div>
                                            @error('arquivo_pdf_revisado')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-warning btn-sm px-4 fw-semibold"
                                            onclick="return confirm('Enviar o PDF revisado?')">
                                            Enviar PDF Revisado
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        {{-- MINOR REVIEW: aceito com ajustes pontuais --}}
                        @if ($submissao->status === 'minor_review' && !$submissao->artigoEnviado())
                            <div class="alert alert-info mt-3 mb-0">
                                <div class="d-flex align-items-start gap-2 mb-2">
                                    <span style="font-size:1.4rem;">📝</span>
                                    <div>
                                        <strong>Revisões Pontuais Solicitadas</strong><br>
                                        <span class="small">
                                            Seu artigo foi aceito com pequenos ajustes. Faça as correções
                                            indicadas e envie a versão final com os dados de publicação.
                                        </span>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-info btn-sm px-4 fw-semibold text-dark"
                                    onclick="abrirModalPublicacao({{ $submissao->id }}, '{{ addslashes($submissao->titulo) }}')">
                                    📤 Enviar Versão Final
                                </button>
                            </div>
                        @endif

                        {{-- ACEITO: envio da versão final --}}
                        @if ($submissao->isAceito() && !$submissao->artigoEnviado())
                            <div class="alert alert-success mt-3 mb-0">
                                <div class="d-flex align-items-start gap-2 mb-2">
                                    <span style="font-size:1.4rem;">🎉</span>
                                    <div>
                                        <strong>Artigo Aceito!</strong><br>
                                        <span class="small">
                                            Parabéns! Preencha os dados de publicação e envie a versão final
                                            em PDF para o editor incorporar na próxima edição.
                                        </span>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-sm px-4 fw-semibold"
                                    onclick="abrirModalPublicacao({{ $submissao->id }}, '{{ addslashes($submissao->titulo) }}')">
                                    📤 Enviar Versão Final e Dados de Publicação
                                </button>
                            </div>
                        @elseif ($submissao->artigoEnviado())
                            <div class="alert alert-success py-2 mt-3 mb-0">
                                ✅ Versão final enviada com dados de publicação. Aguardando incorporação pelo editor.
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $submissoes->links() }}
            </div>
        @endif

    </main>

    {{-- ════════════════════════════════════════════════════════
         MODAL: Dados de Publicação + PDF Final
    ════════════════════════════════════════════════════════ --}}
    <div class="modal fade" id="modalPublicacao" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <div>
                        <h5 class="modal-title">Dados de Publicação</h5>
                        <p class="text-muted small mb-0" id="modal-pub-titulo"></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="form-publicacao" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body" style="max-height: 65vh; overflow-y: auto; overflow-x: hidden;">

                        {{-- ── PDF Final ── --}}
                        <p class="modal-section-title">Arquivo Final</p>

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                PDF Final <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" name="arquivo_pdf" id="modal-pdf-input"
                                accept="application/pdf" required>
                            <div class="form-text">Versão final revisada. Apenas PDF. Máximo 20MB.</div>
                        </div>

                        {{-- ── DOI ── --}}
                        <p class="modal-section-title">Identificação</p>

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                DOI
                                <span class="text-muted fw-normal">(opcional)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text text-muted" style="font-size:13px;">
                                    https://doi.org/
                                </span>
                                <input type="text" class="form-control" name="doi" id="modal-doi"
                                    placeholder="10.5753/eres.2025.00000">
                            </div>
                            <div class="form-text">
                                Informe se já possuir DOI registrado. Pode ser preenchido depois pelo editor.
                            </div>
                        </div>

                        {{-- ── Palavras-chave ── --}}
                        <p class="modal-section-title">Palavras-chave</p>

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                5 Palavras-chave <span class="text-danger">*</span>
                            </label>
                            <div class="kw-group">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div>
                                        <input type="text" class="form-control form-control-sm"
                                            name="palavras_chave[]" placeholder="Palavra {{ $i }}"
                                            required>
                                    </div>
                                @endfor
                            </div>
                            <div class="form-text">Informe exatamente 5 palavras ou termos.</div>
                        </div>

                        {{-- ── Referências ── --}}
                        <p class="modal-section-title">
                            Referências
                            <span id="ref-counter" class="ref-counter ms-2">(0 adicionadas)</span>
                        </p>

                        <div class="mb-2">
                            <label class="form-label fw-bold">
                                Referências Bibliográficas <span class="text-danger">*</span>
                            </label>
                            <div class="form-text mb-2">
                                Insira cada referência no formato ABNT. Mínimo 1 referência.
                            </div>
                        </div>

                        <div id="refs-container" class="mb-3">
                            {{-- Populado via JS --}}
                        </div>

                        <button type="button" class="btn btn-outline-secondary btn-sm"
                            onclick="adicionarReferencia()">
                            <i class="fas fa-plus me-1"></i> Adicionar Referência
                        </button>

                        {{-- Exemplo ABNT --}}
                        <div class="alert alert-light border mt-3 py-2">
                            <small class="text-muted">
                                <strong>Exemplo ABNT:</strong><br>
                                SILVA, J. A.; SOUZA, M. B. <em>Título do artigo</em>. Revista X, v. 10, n. 2, p.
                                100–115, 2024.
                            </small>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success px-4" id="modal-pub-submit">
                            <i class="fas fa-paper-plane me-1"></i> Enviar para Publicação
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <script>
        // ════════════════════════════════════════════════════════
        // MODAL DE PUBLICAÇÃO
        // ════════════════════════════════════════════════════════

        let refCount = 0;

        window.abrirModalPublicacao = function(submissaoId, titulo) {
            // Reset do form
            document.getElementById('form-publicacao').reset();
            document.getElementById('refs-container').innerHTML = '';
            refCount = 0;
            atualizarContador();

            // Preenche título e action
            document.getElementById('modal-pub-titulo').textContent = titulo;
            document.getElementById('form-publicacao').action =
                `/autor/submissoes/${submissaoId}/publicacao`;

            // Começa com 1 referência vazia
            adicionarReferencia();

            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('modalPublicacao')
            ).show();
        };

        window.adicionarReferencia = function() {
            refCount++;
            const container = document.getElementById('refs-container');
            const num = container.children.length + 1;

            const item = document.createElement('div');
            item.className = 'ref-item';
            item.id = `ref-item-${refCount}`;

            const uid = refCount;

            item.innerHTML = `
            <span class="ref-num">${num}.</span>
            <textarea
                class="form-control"
                name="referencias[]"
                id="ref-${uid}"
                placeholder="SOBRENOME, Nome. Título. Local: Editora, Ano."
                rows="2"
                required
                oninput="autoExpandRef(this)"></textarea>
            <button type="button"
                class="btn btn-outline-danger btn-sm border-0 mt-1 flex-shrink-0"
                onclick="removerReferencia('ref-item-${uid}')"
                title="Remover">
                <i class="fas fa-times"></i>
            </button>
        `;

            container.appendChild(item);
            atualizarNumeracao();
            atualizarContador();

            // Foca no novo campo
            item.querySelector('textarea').focus();
        };

        window.removerReferencia = function(itemId) {
            const item = document.getElementById(itemId);
            if (!item) return;

            // Garante ao menos 1 referência
            const total = document.querySelectorAll('#refs-container .ref-item').length;
            if (total <= 1) {
                alert('O artigo precisa ter pelo menos uma referência.');
                return;
            }

            item.remove();
            atualizarNumeracao();
            atualizarContador();
        };

        function atualizarNumeracao() {
            document.querySelectorAll('#refs-container .ref-num').forEach((el, i) => {
                el.textContent = `${i + 1}.`;
            });
        }

        function atualizarContador() {
            const total = document.querySelectorAll('#refs-container .ref-item').length;
            document.getElementById('ref-counter').textContent =
                `(${total} ${total === 1 ? 'adicionada' : 'adicionadas'})`;
        }

        // Auto-expande o textarea conforme digita
        window.autoExpandRef = function(el) {
            el.style.height = 'auto';
            el.style.height = (el.scrollHeight) + 'px';
        };

        // Validação antes do submit
        document.getElementById('form-publicacao').addEventListener('submit', function(e) {
            const refs = document.querySelectorAll('#refs-container textarea');
            let temRef = false;

            refs.forEach(r => {
                if (r.value.trim().length > 10) temRef = true;
            });

            if (!temRef) {
                e.preventDefault();
                alert('Adicione pelo menos uma referência bibliográfica.');
                return;
            }

            const kws = document.querySelectorAll('input[name="palavras_chave[]"]');
            for (const kw of kws) {
                if (!kw.value.trim()) {
                    e.preventDefault();
                    alert('Preencha todas as 5 palavras-chave.');
                    kw.focus();
                    return;
                }
            }

            const btn = document.getElementById('modal-pub-submit');
            btn.disabled = true;
            btn.textContent = 'Enviando...';
        });

        // Limpa ao fechar
        document.getElementById('modalPublicacao').addEventListener('hidden.bs.modal', () => {
            document.getElementById('refs-container').innerHTML = '';
            refCount = 0;
            atualizarContador();
        });
    </script>

</body>

</html>
