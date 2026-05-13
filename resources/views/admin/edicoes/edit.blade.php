<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<body id="page-top" class="bg-light">
    @include('layouts.topbar')

    <div class="modal fade" id="modalPreview" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview do Artigo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="container" style="max-width: 800px;">
                        <div id="preview-titulo-capitulo" class="mb-3 text-muted small fw-bold"></div>
                        <div id="preview-conteudo" class="conteudo-edicao"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <main class="container py-5" style="margin-top: 80px;">

        <div class="d-flex align-items-center justify-content-center gap-3 mb-4">
            <h2 class="text-center mb-0">
                Editando: <span class="text-primary">{{ $edicao->titulo ?: 'Rascunho sem título' }}</span>
            </h2>
            @if($edicao->status === 'rascunho')
                <span class="badge bg-warning text-dark fs-6">Rascunho</span>
            @else
                <span class="badge bg-success fs-6">Publicado</span>
            @endif
        </div>

        <form id="form-edicao" action="{{ route('admin.edicoes.update', $edicao->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" id="input-status" value="{{ $edicao->status }}">

            <div class="card p-4 mb-4 shadow-sm border-0">
                <h4 class="mb-3">Informações Básicas</h4>

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título da Edição</label>
                    <input type="text" class="form-control" id="titulo" name="titulo"
                        value="{{ old('titulo', $edicao->titulo) }}" required>
                </div>

                <div class="mb-3">
                    <label for="autor" class="form-label">Organizador</label>
                    <input type="text" class="form-control" id="autor" name="autor"
                        value="{{ old('autor', $edicao->autor) }}" required>
                </div>

                <div class="mb-3">
                    <label for="resumo" class="form-label">Resumo da Edição</label>
                    <textarea class="form-control" id="resumo" name="resumo" rows="4" required>{{ old('resumo', $edicao->resumo) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="imagem_capa" class="form-label">
                        Imagem de Capa
                        <small class="text-muted">(deixe em branco para manter a atual)</small>
                    </label>
                    <input type="file" class="form-control" id="imagem_capa" name="imagem_capa" accept="image/*">
                    @if($edicao->imagem_capa)
                        <div class="mt-2">
                            <small class="text-muted">Capa atual:</small><br>
                            <img src="{{ asset($edicao->imagem_capa) }}"
                                style="height: 100px; border-radius: 5px; margin-top: 5px;" alt="Capa atual">
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tipo_acesso" class="form-label">Tipo de acesso</label>
                        <select class="form-select" id="tipo_acesso" name="tipo_acesso" required>
                            <option value="publica" {{ old('tipo_acesso', $edicao->tipo_acesso) === 'publica' ? 'selected' : '' }}>Pública</option>
                            <option value="exclusiva" {{ old('tipo_acesso', $edicao->tipo_acesso) === 'exclusiva' ? 'selected' : '' }}>Exclusiva (assinantes)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input type="hidden" name="permitir_comentarios" value="0">
                            <input class="form-check-input" type="checkbox" id="permitir_comentarios"
                                name="permitir_comentarios" value="1"
                                {{ old('permitir_comentarios', $edicao->permitir_comentarios) ? 'checked' : '' }}>
                            <label class="form-check-label" for="permitir_comentarios">
                                Permitir comentários
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card p-4 mb-4 shadow-sm border-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Artigos</h4>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="adicionarCapitulo()">
                        + Adicionar Artigo
                    </button>
                </div>
                <p class="text-muted small mb-4">
                    O texto de cada artigo será exibido como resumo na página pública da revista.
                </p>

                <div id="capitulos-container"></div>
            </div>

            <div class="mt-4 d-flex justify-content-center gap-3">
                @if($edicao->status === 'rascunho')
                    <button type="submit" class="btn btn-outline-secondary btn-lg px-5"
                        onmousedown="document.getElementById('input-status').value='rascunho'">
                        Salvar Rascunho
                    </button>
                    <button type="submit" class="btn btn-primary btn-lg px-5"
                        onmousedown="document.getElementById('input-status').value='publicado'">
                        Publicar Edição
                    </button>
                @else
                    <button type="submit" class="btn btn-primary btn-lg px-5"
                        onmousedown="document.getElementById('input-status').value='publicado'">
                        Atualizar Publicação
                    </button>
                @endif
            </div>
        </form>
    </main>

    @include('layouts.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        let contadorCapitulos = 0;

        document.addEventListener('DOMContentLoaded', () => {
            const capitulosExistentes = @json($edicao->capitulos);

            if (capitulosExistentes.length > 0) {
                capitulosExistentes.forEach(cap => {
                    adicionarCapitulo(cap.id, cap.titulo, cap.conteudo_html, cap.ordem);
                });
            } else {
                adicionarCapitulo();
            }
        });

        function adicionarCapitulo(capituloId = null, titulo = '', conteudoHtml = '', ordem = null) {
            contadorCapitulos++;
            const idx = contadorCapitulos;
            const container = document.getElementById('capitulos-container');

            const div = document.createElement('div');
            div.classList.add('card', 'p-3', 'mb-4', 'capitulo-bloco');
            div.dataset.ordem = ordem ?? idx;

            div.innerHTML = `
                <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-2">
                    <strong class="text-primary me-auto">Artigo ${idx}</strong>
                    <button type="button" class="btn btn-sm btn-outline-info" onclick="abrirPreview(${idx})">
                        Preview
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removerCapitulo(this, ${idx})">
                        Excluir
                    </button>
                </div>

                <input type="hidden" name="capitulos[${idx}][id]" value="${capituloId ?? ''}">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Título do Artigo</label>
                    <input type="text" class="form-control"
                           name="capitulos[${idx}][titulo]"
                           placeholder="Ex: Interfaces que facilitam ou dificultam?"
                           value="${escapeHtml(titulo)}"
                           required>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-semibold">Resumo do Artigo</label>
                </div>
                <textarea id="editor_${idx}" name="capitulos[${idx}][conteudo_html]"></textarea>
                <input type="hidden" name="capitulos[${idx}][ordem]" class="campo-ordem" value="${ordem ?? idx}">
            `;

            container.appendChild(div);
            document.getElementById(`editor_${idx}`).value = conteudoHtml || '';
            inicializarEditor(idx);
        }

        function inicializarEditor(idx) {
            tinymce.init({
                selector: `#editor_${idx}`,
                height: 280,
                menubar: false,
                branding: false,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'charmap',
                    'searchreplace', 'visualblocks', 'fullscreen', 'wordcount'
                ],
                toolbar:
                    'undo redo | blocks | bold italic underline | bullist numlist | link | removeformat | fullscreen',
                paste_as_text: false,
                paste_merge_formats: true,
                smart_paste: true,
                valid_elements:
                    'p,br,h1,h2,h3,h4,h5,h6,strong/b,em/i,u,ul,ol,li,a[href|target|rel],blockquote,hr,sup,sub',
                block_formats:
                    'Parágrafo=p; Título 2=h2; Título 3=h3; Citação=blockquote',
                setup(editor) {
                    editor.on('change', () => editor.save());
                }
            });
        }

        function removerCapitulo(botao, idx) {
            if (contadorCapitulos <= 1) {
                alert('A edição precisa ter pelo menos um artigo.');
                return;
            }
            if (!confirm('Excluir este artigo? Esta ação não pode ser desfeita.')) return;

            tinymce.get(`editor_${idx}`)?.remove();
            botao.closest('.capitulo-bloco').remove();
            contadorCapitulos--;
            atualizarOrdens();
        }

        function atualizarOrdens() {
            document.querySelectorAll('.capitulo-bloco').forEach((bloco, index) => {
                bloco.querySelector('.campo-ordem').value = index + 1;
            });
        }

        function abrirPreview(idx) {
            const editor = tinymce.get(`editor_${idx}`);
            if (!editor) return;

            const html = editor.getContent();
            const tituloInput = document.querySelector(`[name="capitulos[${idx}][titulo]"]`);
            const titulo = tituloInput?.value || `Artigo ${idx}`;

            document.getElementById('preview-titulo-capitulo').textContent = titulo;
            document.getElementById('preview-conteudo').innerHTML = html;

            new bootstrap.Modal(document.getElementById('modalPreview')).show();
        }

        function escapeHtml(str) {
            if (!str) return '';
            return str
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        document.getElementById('form-edicao').addEventListener('submit', function () {
            tinymce.triggerSave();
        });
    </script>
</body>

</html>
