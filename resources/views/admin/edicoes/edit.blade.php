<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<body id="page-top" class="bg-light">
    @include('layouts.topbar')

    {{-- Modal de Preview --}}
    <div class="modal fade" id="modalPreview" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview do Capítulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="container" style="max-width: 800px;">
                        <div id="preview-titulo-capitulo" class="mb-3 text-muted small fw-bold"></div>
                        <div id="preview-conteudo" class="artigo-duas-colunas conteudo-edicao"></div>
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

            {{-- Informações Básicas --}}
            <div class="card p-4 mb-4 shadow-sm border-0">
                <h4 class="mb-3">Informações Básicas</h4>

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título da Edição</label>
                    <input type="text" class="form-control" id="titulo" name="titulo"
                        value="{{ old('titulo', $edicao->titulo) }}" required>
                </div>

                <div class="mb-3">
                    <label for="autor" class="form-label">Autor</label>
                    <input type="text" class="form-control" id="autor" name="autor"
                        value="{{ old('autor', $edicao->autor) }}" required>
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
                                style="height: 100px; border-radius: 5px; margin-top: 5px;">
                        </div>
                    @endif
                </div>
            </div>

            {{-- Capítulos --}}
            <div class="card p-4 mb-4 shadow-sm border-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Capítulos</h4>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="adicionarCapitulo()">
                        + Adicionar Capítulo
                    </button>
                </div>
                <p class="text-muted small mb-4">
                    Cole o conteúdo do Word diretamente em cada capítulo. Títulos, negrito e formatação são preservados.
                </p>

                <div id="capitulos-container">
                    {{-- Capítulos existentes são carregados via JS no DOMContentLoaded --}}
                </div>
            </div>

            {{-- Ações --}}
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

        // Carrega os capítulos existentes ao abrir a tela
        document.addEventListener('DOMContentLoaded', () => {
            const capitulosExistentes = @json($edicao->capitulos);

            if (capitulosExistentes.length > 0) {
                capitulosExistentes.forEach(cap => {
                    adicionarCapitulo(cap.id, cap.titulo, cap.conteudo_html, cap.ordem);
                });
            } else {
                adicionarCapitulo(); // garante ao menos um capítulo
            }

            Sortable.create(document.getElementById('capitulos-container'), {
                handle: '.drag-handle',
                animation: 150,
                onEnd: atualizarOrdens,
            });
        });

        function adicionarCapitulo(capituloId = null, titulo = '', conteudoHtml = '', ordem = null) {
            contadorCapitulos++;
            const idx = contadorCapitulos; // índice local para nomear os campos
            const container = document.getElementById('capitulos-container');

            const div = document.createElement('div');
            div.classList.add('card', 'p-3', 'mb-4', 'capitulo-bloco');
            div.dataset.ordem = ordem ?? idx;

            div.innerHTML = `
                <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-2">
                    <strong class="text-primary me-auto">Capítulo ${idx}</strong>
                    <button type="button" class="btn btn-sm btn-outline-info" onclick="abrirPreview(${idx})">
                        👁 Preview
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removerCapitulo(this, ${idx})">
                        Excluir
                    </button>
                </div>

                {{-- ID do capítulo existente (null = novo) --}}
                <input type="hidden" name="capitulos[${idx}][id]" value="${capituloId ?? ''}">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Título do Capítulo</label>
                    <input type="text" class="form-control"
                           name="capitulos[${idx}][titulo]"
                           placeholder="Ex: Artigos Científicos / Saúde e Bem-Estar"
                           value="${escapeHtml(titulo)}"
                           required>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-semibold">Conteúdo</label>
                </div>
                <textarea id="editor_${idx}" name="capitulos[${idx}][conteudo_html]">${conteudoHtml}</textarea>
                <input type="hidden" name="capitulos[${idx}][ordem]" class="campo-ordem" value="${ordem ?? idx}">
            `;

            container.appendChild(div);
            inicializarEditor(idx);
        }

        function inicializarEditor(idx) {
            tinymce.init({
                selector: `#editor_${idx}`,
                height: 450,
                menubar: false,
                branding: false,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image',
                    'charmap', 'searchreplace', 'visualblocks',
                    'fullscreen', 'table', 'wordcount'
                ],
                toolbar:
                    'undo redo | blocks | ' +
                    'bold italic underline strikethrough | ' +
                    'bullist numlist | ' +
                    'link image table | ' +
                    'alignleft aligncenter alignright | ' +
                    'removeformat | fullscreen',
                paste_as_text: false,
                paste_merge_formats: true,
                smart_paste: true,
                valid_elements:
                    'p,br,h1,h2,h3,h4,h5,h6,' +
                    'strong/b,em/i,u,s,strike,' +
                    'ul,ol,li,' +
                    'a[href|target|rel],' +
                    'img[src|alt|width|height|style],' +
                    'table,thead,tbody,tr,th[colspan|rowspan],td[colspan|rowspan],' +
                    'blockquote,pre,code,hr,sup,sub',
                block_formats:
                    'Parágrafo=p; Título 1=h1; Título 2=h2; Título 3=h3; Citação=blockquote; Código=pre',
                setup(editor) {
                    editor.on('change', () => editor.save());
                }
            });
        }

        function removerCapitulo(botao, idx) {
            if (contadorCapitulos <= 1) {
                alert('A edição precisa ter pelo menos um capítulo.');
                return;
            }
            if (!confirm('Excluir este capítulo? Esta ação não pode ser desfeita.')) return;

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
            const titulo = tituloInput?.value || `Capítulo ${idx}`;

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

        // Sincroniza todos os editores antes do submit
        document.getElementById('form-edicao').addEventListener('submit', function () {
            tinymce.triggerSave();
        });
    </script>
</body>

</html>