<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<body id="page-top" class="bg-light">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px;">
        <h2 class="text-center mb-4">
            Editando: <span class="text-primary">{{ $edicao->titulo }}</span>
        </h2>

        <form action="{{ route('admin.edicoes.update', $edicao->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                    <label for="imagem_capa" class="form-label">Imagem de Capa (Deixe em branco para manter a
                        atual)</label>
                    <input type="file" class="form-control" id="imagem_capa" name="imagem_capa" accept="image/*">
                    <div class="mt-2">
                        <small class="text-muted">Capa Atual:</small><br>
                        <img src="{{ asset($edicao->imagem_capa) }}" style="height: 100px; border-radius: 5px;">
                    </div>
                </div>
            </div>

            <div class="card p-4 mb-4 border-primary shadow-sm">
                <h4 class="mb-3">Formato do Conteúdo</h4>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_conteudo" id="tipo_blocos" value="blocos" {{ $edicao->tipo_conteudo == 'blocos' ? 'checked' : '' }} onchange="alternarFormato()">
                    <label class="form-check-label" for="tipo_blocos">Escrever na Plataforma (Blocos)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_conteudo" id="tipo_pdf" value="pdf" {{ $edicao->tipo_conteudo == 'pdf' ? 'checked' : '' }} onchange="alternarFormato()">
                    <label class="form-check-label" for="tipo_pdf">Fazer Upload de PDF</label>
                </div>
            </div>

            <div id="sessao-blocos" class="card p-4 mb-4 shadow-sm border-0"
                style="display: {{ $edicao->tipo_conteudo == 'blocos' ? 'block' : 'none' }};">
                <h4 class="mb-3">Conteúdo da Revista</h4>

                <div id="blocos-container"></div>

                <div class="d-flex justify-content-center mt-3">
                    <button type="button" class="btn btn-outline-primary me-2" onclick="adicionarBloco('paragrafo')">+
                        Parágrafo</button>
                    <button type="button" class="btn btn-outline-primary me-2" onclick="adicionarBloco('subtitulo')">+
                        Subtítulo</button>
                    <button type="button" class="btn btn-outline-primary" onclick="adicionarBloco('imagem')">+
                        Imagem</button>
                </div>
            </div>

            <div id="sessao-pdf" class="card p-4 mb-4 shadow-sm border-0"
                style="display: {{ $edicao->tipo_conteudo == 'pdf' ? 'block' : 'none' }};">
                <h4 class="mb-3">Arquivo da Revista (Deixe em branco para manter o atual)</h4>

                <div class="mb-3">
                    <input type="file" class="form-control" id="arquivo_pdf" name="arquivo_pdf"
                        accept="application/pdf">
                    @if($edicao->arquivo_pdf)
                        <div class="mt-2 text-success">
                            <i class="fas fa-check-circle"></i> Arquivo PDF atual já está salvo no sistema.
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary btn-lg px-5">Atualizar Edição</button>
            </div>
        </form>
    </main>

    @include('layouts.footer')

    <script>
        function alternarFormato() {
            const formatoEscolhido = document.querySelector('input[name="tipo_conteudo"]:checked').value;
            document.getElementById('sessao-blocos').style.display = formatoEscolhido === 'blocos' ? 'block' : 'none';
            document.getElementById('sessao-pdf').style.display = formatoEscolhido === 'pdf' ? 'block' : 'none';
        }

        let contador = 0;

        function adicionarBloco(tipo, valorAtual = '') {
            contador++;
            const container = document.getElementById('blocos-container');
            const div = document.createElement('div');
            div.classList.add('card', 'p-3', 'mb-3', 'bloco', 'bg-light');
            div.dataset.id = contador;

            let conteudo = '';

            if (tipo === 'paragrafo') {
                conteudo = `
                    <label class="form-label fw-bold text-muted">Parágrafo</label>
                    <textarea name="conteudo[]" class="form-control" rows="3" required>${valorAtual}</textarea>
                    <input type="hidden" name="tipo[]" value="paragrafo">
                    <input type="hidden" name="conteudo_antigo[]" value="">
                `;
            } else if (tipo === 'subtitulo') {
                conteudo = `
                    <label class="form-label fw-bold text-muted">Subtítulo</label>
                    <input type="text" name="conteudo[]" class="form-control" value="${valorAtual}" required>
                    <input type="hidden" name="tipo[]" value="subtitulo">
                    <input type="hidden" name="conteudo_antigo[]" value="">
                `;
            } else if (tipo === 'imagem') {
                let avisoImagem = valorAtual ? `<small class="text-success d-block mt-1">Imagem atual preservada. Só envie um arquivo se quiser trocar.</small>` : '';
                conteudo = `
                    <label class="form-label fw-bold text-muted">Imagem</label>
                    <input type="file" name="conteudo[]" class="form-control" accept="image/*" ${valorAtual ? '' : 'required'}>
                    ${avisoImagem}
                    <input type="hidden" name="tipo[]" value="imagem">
                    <input type="hidden" name="conteudo_antigo[]" value="${valorAtual}">
                `;
            }

            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <strong class="text-primary">${tipo.charAt(0).toUpperCase() + tipo.slice(1)}</strong>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removerBloco(this)">Excluir</button>
                    </div>
                </div>
                ${conteudo}
            `;
            container.appendChild(div);
        }

        function removerBloco(botao) {
            botao.closest('.bloco').remove();
        }

        document.addEventListener("DOMContentLoaded", function () {
            const blocosSalvos = @json(json_decode($edicao->conteudo_blocos, true) ?? []);
            blocosSalvos.forEach(bloco => {
                adicionarBloco(bloco.tipo, bloco.conteudo);
            });
        });
    </script>
</body>

</html>