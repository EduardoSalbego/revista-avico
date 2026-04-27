<!DOCTYPE html>
<html lang="pt-br">
@include('layouts/head')

<body id="page-top">
    @include('layouts/topbar')

    <main class="container py-5" style="margin-top: 50px;">
        <h2 class="text-center mb-4">
            Criando a edição #{{ $proximaEdicao ?? '1' }} da revista
        </h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <h5 class="mb-2">⚠️ Erros ao salvar:</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('edicoes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Informações Básicas --}}
            <div class="card p-4 mb-4">
                <h4 class="mb-3">Informações Básicas</h4>

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título da Edição</label>
                    <input type="text" class="form-control" id="titulo" name="titulo"
                        placeholder="Ex: Edição de Outubro 2025" required>
                </div>

                <div class="mb-3">
                    <label for="autor" class="form-label">Autor</label>
                    <input type="text" class="form-control" id="autor" name="autor"
                        placeholder="Nome do autor principal" required>
                </div>

                <div class="mb-3">
                    <label for="imagem_capa" class="form-label">Imagem de Capa</label>
                    <input type="file" class="form-control" id="imagem_capa" name="imagem_capa"
                        accept="image/*" required>
                </div>
            </div>

            {{-- Editor de Conteúdo --}}
            <div class="card p-4 mb-4">
                <h4 class="mb-3">Conteúdo da Revista</h4>
                <p class="text-muted mb-3">
                    Cole o conteúdo do Word diretamente abaixo. Títulos, parágrafos, negrito,
                    itálico e listas serão preservados automaticamente.
                </p>

                {{-- Campo hidden que recebe o HTML gerado pelo TinyMCE --}}
                <textarea id="conteudo_editor" name="conteudo_html">{{ old('conteudo_html') }}</textarea>

                @error('conteudo_html')
                    <div class="text-danger mt-2 small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary btn-lg px-5">Salvar Edição</button>
            </div>
        </form>
    </main>

    @include('layouts/footer')

    {{-- TinyMCE via CDN (sem API key para domínio próprio; troque pela sua key se usar cloud) --}}
    <script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>

    <script>
        tinymce.init({
            selector: '#conteudo_editor',
            language: 'pt_BR',           // requer o language pack – veja observações abaixo
            height: 600,
            menubar: false,
            branding: false,

            // Plugins essenciais
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image',
                'charmap', 'preview', 'searchreplace', 'visualblocks',
                'fullscreen', 'insertdatetime', 'table', 'wordcount',
                'paste'                  // paste plugin: limpa lixo do Word
            ],

            toolbar:
                'undo redo | blocks | ' +
                'bold italic underline strikethrough | ' +
                'bullist numlist | ' +
                'link image table | ' +
                'alignleft aligncenter alignright | ' +
                'removeformat | fullscreen',

            // Configurações de paste do Word
            // O TinyMCE detecta automaticamente conteúdo do Word e limpa o HTML proprietário,
            // preservando apenas a semântica (h1-h6, strong, em, ul, ol, p, table…)
            paste_as_text: false,           // false = preserva formatação (negrito, itálico etc.)
            paste_remove_styles_if_webkit: true,
            paste_merge_formats: true,
            smart_paste: true,              // TinyMCE 6+

            // Bloquear tags que não fazem sentido salvar no banco
            valid_elements:
                'p,br,h1,h2,h3,h4,h5,h6,' +
                'strong/b,em/i,u,s,strike,' +
                'ul,ol,li,' +
                'a[href|target|rel],' +
                'img[src|alt|width|height|style],' +
                'table,thead,tbody,tr,th[colspan|rowspan],td[colspan|rowspan],' +
                'blockquote,pre,code,hr,' +
                'sup,sub',

            // Estilos de bloco disponíveis no dropdown "Blocks"
            block_formats:
                'Parágrafo=p; ' +
                'Título 1=h1; ' +
                'Título 2=h2; ' +
                'Título 3=h3; ' +
                'Citação=blockquote; ' +
                'Código=pre',

            // Permite upload de imagem inline (base64) – útil se o editor inserir imgs
            // Para produção, prefira images_upload_url apontando para uma rota Laravel
            // images_upload_handler pode ser customizado com fetch + CSRF

            // Garante que o campo hidden seja atualizado antes do submit
            setup(editor) {
                editor.on('change', () => editor.save());
            }
        });

        // Validação no submit: impede envio com editor vazio
        document.querySelector('form').addEventListener('submit', function (e) {
            const html = tinymce.get('conteudo_editor').getContent();
            if (!html || html.trim() === '') {
                e.preventDefault();
                alert('O conteúdo da revista não pode estar vazio.');
                tinymce.get('conteudo_editor').focus();
            }
        });
    </script>
</body>
</html>