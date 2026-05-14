<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<style>
    .artigo-vinculado {
        border: 1.5px solid #dee2e6;
        border-radius: 10px;
        padding: 14px 18px;
        background: #fff;
        transition: box-shadow .2s;
    }

    .artigo-vinculado:hover {
        box-shadow: 0 2px 10px rgba(0, 0, 0, .07);
    }

    .artigo-novo {
        border: 1.5px dashed #198754;
        border-radius: 10px;
        padding: 14px 18px;
        background: #f0fdf4;
    }

    .drag-handle {
        cursor: grab;
        color: #adb5bd;
        padding: 0 6px;
    }

    .drag-handle:active {
        cursor: grabbing;
    }

    /* Badge de status do artigo */
    .badge-aceito {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .badge-pendente {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fcd34d;
    }
</style>

<body id="page-top" class="bg-light">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top:80px;">

        <div class="d-flex align-items-center justify-content-center gap-3 mb-4">
            <h2 class="text-center mb-0">
                Editando: <span class="text-primary">{{ $edicao->titulo ?: 'Rascunho sem título' }}</span>
            </h2>
            @if ($edicao->status === 'rascunho')
                <span class="badge bg-warning text-dark fs-6">Rascunho</span>
            @else
                <span class="badge bg-success fs-6">Publicado</span>
            @endif
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="form-edicao" action="{{ route('admin.edicoes.update', $edicao->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" id="input-status" value="{{ $edicao->status }}">

            {{-- ════════════════════════════════════
                 INFORMAÇÕES BÁSICAS
            ════════════════════════════════════ --}}
            <div class="card p-4 mb-4 shadow-sm border-0">
                <h4 class="mb-4">Informações Básicas</h4>

                <div class="mb-3">
                    <label for="titulo" class="form-label fw-semibold">Título da Edição</label>
                    <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo"
                        name="titulo" value="{{ old('titulo', $edicao->titulo) }}" required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="organizador" class="form-label fw-semibold">Organizador</label>
                    <input type="text" class="form-control @error('organizador') is-invalid @enderror"
                        id="organizador" name="organizador" value="{{ old('organizador', $edicao->organizador) }}"
                        required>
                    @error('organizador')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="resumo" class="form-label fw-semibold">Resumo da Edição</label>
                    <textarea class="form-control @error('resumo') is-invalid @enderror" id="resumo" name="resumo" rows="4"
                        required>{{ old('resumo', $edicao->resumo) }}</textarea>
                    @error('resumo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="imagem_capa" class="form-label fw-semibold">
                        Imagem de Capa
                        <small class="text-muted fw-normal">(deixe em branco para manter a atual)</small>
                    </label>
                    <input type="file" class="form-control" id="imagem_capa" name="imagem_capa" accept="image/*">
                    @if ($edicao->imagem_capa)
                        <div class="mt-2 d-flex align-items-center gap-3">
                            <img src="{{ asset($edicao->imagem_capa) }}"
                                style="height:80px; border-radius:6px; object-fit:cover;" alt="Capa atual">
                            <small class="text-muted">Capa atual</small>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tipo_acesso" class="form-label fw-semibold">Tipo de Acesso</label>
                        <select class="form-select" id="tipo_acesso" name="tipo_acesso" required>
                            <option value="publica"
                                {{ old('tipo_acesso', $edicao->tipo_acesso) === 'publica' ? 'selected' : '' }}>
                                🌐 Pública
                            </option>
                            <option value="exclusiva"
                                {{ old('tipo_acesso', $edicao->tipo_acesso) === 'exclusiva' ? 'selected' : '' }}>
                                🔒 Exclusiva (assinantes)
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-end pb-1">
                        <div class="form-check form-switch">
                            {{-- Hidden garante que "false" seja enviado quando desmarcado --}}
                            <input type="hidden" name="permitir_comentarios" value="0">
                            <input class="form-check-input" type="checkbox" id="permitir_comentarios"
                                name="permitir_comentarios" value="1"
                                {{ old('permitir_comentarios', $edicao->permitir_comentarios) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="permitir_comentarios">
                                Permitir comentários
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════
                 ARTIGOS DA EDIÇÃO
            ════════════════════════════════════ --}}
            <div class="card p-4 mb-4 shadow-sm border-0">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h4 class="mb-0">Artigos da Edição</h4>
                        <p class="text-muted small mb-0 mt-1">
                            Vincule artigos aprovados no sistema. Arraste para reordenar.
                        </p>
                    </div>
                    <button type="button" class="btn btn-outline-success btn-sm fw-bold" onclick="abrirSeletorArtigo()"
                        id="btn-add-artigo">
                        <i class="fas fa-plus me-1"></i> Adicionar Artigo
                    </button>
                </div>

                <hr>

                {{-- Lista de artigos já vinculados + novos adicionados --}}
                <div id="artigos-container" class="d-flex flex-column gap-3 mb-3">

                    @forelse($artigosEdicao as $artigo)
                        @php
                            $autorNome = $artigo->submissao?->autor->user->name ?? '—';
                        @endphp
                        <div class="artigo-vinculado d-flex align-items-center gap-3"
                            data-artigo-id="{{ $artigo->id }}" draggable="true">

                            <i class="fas fa-grip-vertical drag-handle" title="Arrastar para reordenar"></i>

                            <div class="flex-grow-1">
                                <div class="fw-semibold">{{ $artigo->titulo }}</div>
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i>{{ $autorNome }}
                                    @if ($artigo->doi)
                                        &nbsp;·&nbsp;
                                        <i class="fas fa-link me-1"></i>DOI: {{ $artigo->doi }}
                                    @endif
                                </small>
                            </div>

                            <span class="badge badge-aceito rounded-pill flex-shrink-0">
                                ✓ Aprovado
                            </span>

                            {{-- Input hidden com id e ordem (ordem atualizada pelo JS) --}}
                            <input type="hidden" name="artigos_ids[]" value="{{ $artigo->id }}">

                            <button type="button" class="btn btn-outline-danger btn-sm flex-shrink-0"
                                onclick="removerArtigoVinculado(this)" title="Remover da edição">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @empty
                        <div id="placeholder-vazio" class="text-center text-muted py-4">
                            <i class="fas fa-folder-open fs-3 mb-2 d-block opacity-25"></i>
                            Nenhum artigo vinculado ainda. Clique em "Adicionar Artigo".
                        </div>
                    @endforelse

                </div>

                {{-- Aviso quando não há artigos aprovados disponíveis --}}
                @if (($artigosDisponiveis ?? collect())->isEmpty())
                    <div class="alert alert-info small py-2 mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Não há artigos aprovados aguardando publicação no momento.
                    </div>
                @endif

            </div>

            {{-- ════════════════════════════════════
                 AÇÕES
            ════════════════════════════════════ --}}
            <div class="d-flex justify-content-center gap-3 mt-2 mb-5">
                <a href="{{ route('admin.edicoes.index') }}" class="btn btn-outline-secondary btn-lg px-5">
                    Cancelar
                </a>

                @if ($edicao->status === 'rascunho')
                    <button type="submit" class="btn btn-outline-secondary btn-lg px-5"
                        onmousedown="document.getElementById('input-status').value='rascunho'">
                        Salvar Rascunho
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg px-5"
                        onmousedown="document.getElementById('input-status').value='publicado'">
                        <i class="fas fa-globe me-1"></i> Publicar Edição
                    </button>
                @else
                    <button type="submit" class="btn btn-primary btn-lg px-5"
                        onmousedown="document.getElementById('input-status').value='publicado'">
                        <i class="fas fa-save me-1"></i> Salvar Alterações
                    </button>
                @endif
            </div>

        </form>
    </main>

    {{-- ════════════════════════════════════════════
         MODAL: Selecionar artigo para vincular
    ════════════════════════════════════════════ --}}
    <div class="modal fade" id="modalSeletorArtigo" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <div>
                        <h5 class="modal-title">Adicionar Artigo à Edição</h5>
                        <p class="text-muted small mb-0">
                            Apenas artigos aprovados e sem edição vinculada.
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-0">

                    {{-- Busca rápida --}}
                    <div class="mb-3">
                        <input type="text" id="busca-artigo-modal" class="form-control"
                            placeholder="Filtrar por título ou autor..." oninput="filtrarArtigosModal(this.value)">
                    </div>

                    <div id="lista-artigos-modal" class="d-flex flex-column gap-2"
                        style="max-height:420px; overflow-y:auto;">

                        @forelse($artigosDisponiveis ?? [] as $disponivel)
                            @php
                                $autorNome = $disponivel->autor()->nome ?? '—';
                            @endphp
                            <label
                                class="artigo-modal-item d-flex align-items-center gap-3 p-3
                                          border rounded cursor-pointer"
                                data-titulo="{{ strtolower($disponivel->titulo) }}"
                                data-autor="{{ strtolower($autorNome) }}"
                                style="cursor:pointer; transition:background .15s;"
                                onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background=''"
                                onclick="vincularArtigo({{ $disponivel->id }}, '{{ addslashes($disponivel->titulo) }}', '{{ addslashes($autorNome) }}', this)">

                                <input type="checkbox" class="form-check-input flex-shrink-0 mt-0"
                                    data-id="{{ $disponivel->id }}" style="pointer-events:none;">

                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $disponivel->titulo }}</div>
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>{{ $autorNome }}
                                        @if ($disponivel->doi)
                                            &nbsp;·&nbsp; DOI: {{ $disponivel->doi }}
                                        @endif
                                    </small>
                                </div>

                                <span class="badge badge-aceito rounded-pill flex-shrink-0">
                                    ✓ Aprovado
                                </span>
                            </label>
                        @empty
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-check-circle fs-3 mb-2 d-block text-success opacity-50"></i>
                                Todos os artigos aprovados já estão vinculados a uma edição.
                            </div>
                        @endforelse

                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <script>
        // IDs já vinculados (para não deixar adicionar duplicata)
        const vinculados = new Set([
            @foreach ($artigosEdicao as $a)
                {{ $a->id }},
            @endforeach
        ]);

        // ── Abre o modal de seleção ──
        function abrirSeletorArtigo() {
            document.getElementById('busca-artigo-modal').value = '';
            filtrarArtigosModal('');
            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('modalSeletorArtigo')
            ).show();
        }

        // ── Filtra a lista do modal ──
        function filtrarArtigosModal(q) {
            q = q.toLowerCase().trim();
            document.querySelectorAll('.artigo-modal-item').forEach(item => {
                const titulo = item.dataset.titulo ?? '';
                const autor = item.dataset.autor ?? '';
                item.style.display = (!q || titulo.includes(q) || autor.includes(q)) ?
                    '' : 'none';
            });
        }

        // ── Vincula um artigo clicado no modal ──
        function vincularArtigo(id, titulo, autor, labelEl) {
            if (vinculados.has(id)) {
                // Já está: desvincular
                desvinculaPeloId(id);
                labelEl.querySelector('input[type=checkbox]').checked = false;
                labelEl.style.background = '';
                return;
            }

            vinculados.add(id);
            labelEl.querySelector('input[type=checkbox]').checked = true;
            labelEl.style.background = '#f0fdf4';

            adicionarArtigoNaLista(id, titulo, autor);
            esconderPlaceholder();
        }

        // ── Adiciona o card na lista principal ──
        function adicionarArtigoNaLista(id, titulo, autor) {
            const container = document.getElementById('artigos-container');

            const div = document.createElement('div');
            div.className = 'artigo-vinculado artigo-novo d-flex align-items-center gap-3';
            div.dataset.artigoId = id;
            div.draggable = true;
            div.innerHTML = `
            <i class="fas fa-grip-vertical drag-handle" title="Arrastar"></i>
            <div class="flex-grow-1">
                <div class="fw-semibold">${titulo}</div>
                <small class="text-muted">
                    <i class="fas fa-user me-1"></i>${autor}
                    &nbsp;<span class="badge bg-success ms-1" style="font-size:10px;">Novo</span>
                </small>
            </div>
            <input type="hidden" name="artigos_ids[]" value="${id}">
            <button type="button"
                class="btn btn-outline-danger btn-sm flex-shrink-0"
                onclick="removerArtigoVinculado(this)"
                title="Remover">
                <i class="fas fa-times"></i>
            </button>
        `;

            initDrag(div);
            container.appendChild(div);
        }

        // ── Remove um artigo da lista ──
        function removerArtigoVinculado(btn) {
            const item = btn.closest('[data-artigo-id]');
            const id = Number(item.dataset.artigoId);

            vinculados.delete(id);

            // Desmarca no modal se estiver aberto
            const checkbox = document.querySelector(
                `#lista-artigos-modal [data-id="${id}"]`
            );
            if (checkbox) {
                checkbox.checked = false;
                checkbox.closest('label').style.background = '';
            }

            item.remove();
            mostrarPlaceholderSeVazio();
        }

        function desvinculaPeloId(id) {
            const item = document.querySelector(`[data-artigo-id="${id}"]`);
            if (item) {
                vinculados.delete(id);
                item.remove();
                mostrarPlaceholderSeVazio();
            }
        }

        function esconderPlaceholder() {
            const ph = document.getElementById('placeholder-vazio');
            if (ph) ph.style.display = 'none';
        }

        function mostrarPlaceholderSeVazio() {
            const container = document.getElementById('artigos-container');
            const itens = container.querySelectorAll('[data-artigo-id]');
            if (itens.length === 0) {
                const ph = document.getElementById('placeholder-vazio');
                if (ph) ph.style.display = '';
                else {
                    container.innerHTML =
                        `<div id="placeholder-vazio" class="text-center text-muted py-4">
                        <i class="fas fa-folder-open fs-3 mb-2 d-block opacity-25"></i>
                        Nenhum artigo vinculado ainda. Clique em "Adicionar Artigo".
                    </div>`;
                }
            }
        }

        // ════════════════════════════════════════
        // DRAG & DROP para reordenar
        // ════════════════════════════════════════
        let dragSrc = null;

        function initDrag(el) {
            el.addEventListener('dragstart', function(e) {
                dragSrc = this;
                this.style.opacity = '.4';
                e.dataTransfer.effectAllowed = 'move';
            });
            el.addEventListener('dragend', function() {
                this.style.opacity = '';
                document.querySelectorAll('[data-artigo-id]').forEach(i => {
                    i.classList.remove('drag-over');
                });
            });
            el.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'move';
            });
            el.addEventListener('dragenter', function() {
                if (this !== dragSrc) this.style.outline = '2px dashed #0d6efd';
            });
            el.addEventListener('dragleave', function() {
                this.style.outline = '';
            });
            el.addEventListener('drop', function(e) {
                e.stopPropagation();
                this.style.outline = '';
                if (dragSrc !== this) {
                    const container = document.getElementById('artigos-container');
                    const allItems = [...container.querySelectorAll('[data-artigo-id]')];
                    const srcIdx = allItems.indexOf(dragSrc);
                    const dstIdx = allItems.indexOf(this);

                    if (srcIdx < dstIdx) {
                        this.after(dragSrc);
                    } else {
                        this.before(dragSrc);
                    }
                }
                return false;
            });
        }

        // Inicializa drag nos itens já existentes
        document.querySelectorAll('[data-artigo-id]').forEach(initDrag);

        // Marca no modal os já vinculados ao carregar a página
        document.addEventListener('DOMContentLoaded', () => {
            vinculados.forEach(id => {
                const cb = document.querySelector(`#lista-artigos-modal [data-id="${id}"]`);
                if (cb) {
                    cb.checked = true;
                    cb.closest('label').style.background = '#f0fdf4';
                }
            });
        });
    </script>

</body>

</html>
