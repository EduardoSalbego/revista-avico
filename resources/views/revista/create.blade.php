<!DOCTYPE html>
<html lang="pt-br">
@include('layouts/head')

<body id="page-top">
    @include('layouts/topbar')

    {{-- Modal de Preview --}}
    <div class="modal fade" id="modalPreview" tabindex="-1" aria-labelledby="modalPreviewLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPreviewLabel">Preview do Capítulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    {{-- Simula o layout da página de leitura --}}
                    <div class="container" style="max-width: 800px;">
                        <div id="preview-titulo-capitulo" class="mb-3 text-muted small"></div>
                        <div id="preview-conteudo" class="artigo-duas-colunas conteudo-edicao"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <main class="container py-5" style="margin-top: 50px;">
        <h2 class="text-center mb-4">
            Criando a edição #{{ $proximaEdicao ?? '1' }} da revista
        </h2>

        <form id="form-edicao" action="{{ route('edicoes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Campo hidden que carrega o status (rascunho ou publicado) --}}
            <input type="hidden" name="status" id="input-status" value="publicado">

            {{-- Informações Básicas --}}
            <div class="card p-4 mb-4">
                <h4 class="mb-3">Informações Básicas</h4>

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título da Edição</label>
                    <input type="text" class="form-control" id="titulo" name="titulo"
                        placeholder="Ex: Edição de Outubro 2025" value="{{ old('titulo') }}" required>
                </div>

                <div class="mb-3">
                    <label for="autor" class="form-label">Autor</label>
                    <input type="text" class="form-control" id="autor" name="autor"
                        placeholder="Nome do autor principal" value="{{ old('autor') }}" required>
                </div>

                <div class="mb-3">
                    <label for="imagem_capa" class="form-label">Imagem de Capa</label>
                    <input type="file" class="form-control" id="imagem_capa" name="imagem_capa" accept="image/*"
                        required>
                </div>
            </div>

            {{-- Capítulos --}}
            <div class="card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Capítulos</h4>
                </div>

                <p class="text-muted small mb-4">
                    Cada capítulo tem seu próprio editor. Cole o conteúdo do Word diretamente em cada capítulo. Títulos,
                    negrito e formatação são preservados.
                </p>

                <div id="capitulos-container">
                    {{-- Capítulos são inseridos aqui via JS --}}
                </div>
                <div class="d-flex justify-content-end align-items-center mb-2">
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="adicionarCapitulo()">
                        + Adicionar Capítulo
                    </button>
                </div>
            </div>

            {{-- Ações --}}
            <div class="mt-4 d-flex justify-content-center gap-3">
                <button type="submit" class="btn btn-outline-secondary btn-lg px-5"
                    onmousedown="document.getElementById('input-status').value='rascunho'">
                    Salvar como rascunho
                </button>
                <button type="submit" class="btn btn-primary btn-lg px-5"
                    onmousedown="document.getElementById('input-status').value='publicado'">
                    Publicar Edição
                </button>
            </div>
        </form>
    </main>

    @include('layouts/footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        let contadorCapitulos = 0;
        const editors = {}; // rastreia instâncias TinyMCE por ID

        // Inicializa com um capítulo por padrão
        document.addEventListener('DOMContentLoaded', () => {
            adicionarCapitulo();
        });

        function adicionarCapitulo() {
            contadorCapitulos++;
            const id = contadorCapitulos;
            const container = document.getElementById('capitulos-container');

            const div = document.createElement('div');
            div.classList.add('card', 'p-3', 'mb-4', 'capitulo-bloco');
            div.dataset.ordem = id;
            div.innerHTML = `
                <div class="d-flex align-items-center gap-2 mb-3 border-bottom pb-2">
                    <strong class="text-primary me-auto">Capítulo ${id}</strong>
                    <button type="button" class="btn btn-sm btn-outline-info" onclick="abrirPreview(${id})">
                        👁 Preview
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removerCapitulo(this, ${id})">
                        Excluir
                    </button>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Título do Capítulo</label>
                    <input type="text"
                           class="form-control"
                           name="capitulos[${id}][titulo]"
                           placeholder="Ex: Artigos Científicos / Saúde e Bem-Estar"
                           required>
                </div>

                <div class="mb-2">
                    <label class="form-label fw-semibold">Conteúdo</label>
                </div>
                <textarea id="editor_${id}" name="capitulos[${id}][conteudo_html]"></textarea>
                <input type="hidden" name="capitulos[${id}][ordem]" class="campo-ordem" value="${id}">
            `;

            container.appendChild(div);
            inicializarEditor(id);
        }

        function inicializarEditor(id) {
            tinymce.init({
                selector: `#editor_${id}`,
                height: 450,
                menubar: false,
                branding: false,
                plugins: [
                    'advlist', 'autolink', 'lists', 'link', 'image',
                    'charmap', 'preview', 'searchreplace', 'visualblocks',
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
                    editors[id] = editor;
                    editor.on('change', () => editor.save());
                }
            });
        }

        function removerCapitulo(botao, id) {
            if (contadorCapitulos <= 1) {
                alert('A edição precisa ter pelo menos um capítulo.');
                return;
            }
            if (!confirm('Excluir este capítulo?')) return;

            const bloco = botao.closest('.capitulo-bloco');
            tinymce.get(`editor_${id}`)?.remove();
            delete editors[id];
            bloco.remove();
            contadorCapitulos--;
            atualizarOrdens();
        }

        function atualizarOrdens() {
            document.querySelectorAll('.capitulo-bloco').forEach((bloco, index) => {
                bloco.querySelector('.campo-ordem').value = index + 1;
            });
        }

        function abrirPreview(id) {
            // Sincroniza o conteúdo do editor antes de exibir
            const editor = tinymce.get(`editor_${id}`);
            if (!editor) return;

            const html = editor.getContent();
            const tituloInput = document.querySelector(`[name="capitulos[${id}][titulo]"]`);
            const titulo = tituloInput?.value || `Capítulo ${id}`;

            document.getElementById('preview-titulo-capitulo').textContent = titulo;
            document.getElementById('preview-conteudo').innerHTML = html;

            const modal = new bootstrap.Modal(document.getElementById('modalPreview'));
            modal.show();
        }

        // Validação no submit de publicação
        document.getElementById('form-edicao').addEventListener('submit', function (e) {
            // Rascunho já sincronizou e submeteu diretamente — só chega aqui via botão Publicar
            if (document.getElementById('input-status').value === 'rascunho') return;

            // Sincroniza para publicação
            tinymce.editors.forEach(editor => editor.save());

            const algumComConteudo = tinymce.editors.some(ed => ed.getContent().trim() !== '');
            if (!algumComConteudo) {
                e.preventDefault();
                alert('Adicione conteúdo em pelo menos um capítulo antes de publicar.');
            }
        });
    </script>
</body>

</html>