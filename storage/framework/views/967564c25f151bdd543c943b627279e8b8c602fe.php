<!DOCTYPE html>
<html lang="pt-br">
<?php echo $__env->make('layouts/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="page-top">
    <?php echo $__env->make('layouts/topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="container py-5" style="margin-top: 50px;">
        <h2 class="text-center mb-4">
            Criando a edição #<?php echo e($proximaEdicao ?? '1'); ?> da revista
        </h2>

        <form action="<?php echo e(route('store.edicao')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

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
                    <input type="file" class="form-control" id="imagem_capa" name="imagem_capa" accept="image/*"
                        required>
                </div>
            </div>

            <div class="card p-4 mb-4">
                <h4 class="mb-3">Formato do Conteúdo</h4>
                <p class="text-muted">Escolha como deseja inserir o conteúdo desta edição.</p>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_conteudo" id="tipo_blocos" value="blocos"
                        checked onchange="alternarFormato()">
                    <label class="form-check-label" for="tipo_blocos">Escrever na Plataforma (Blocos)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="tipo_conteudo" id="tipo_pdf" value="pdf"
                        onchange="alternarFormato()">
                    <label class="form-check-label" for="tipo_pdf">Fazer Upload de PDF</label>
                </div>
            </div>

            <div id="sessao-blocos" class="card p-4 mb-4">
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

            <div id="sessao-pdf" class="card p-4 mb-4" style="display: none;">
                <h4 class="mb-3">Arquivo da Revista</h4>

                <div class="mb-3">
                    <label for="arquivo_pdf" class="form-label">Selecione o arquivo PDF</label>
                    <input type="file" class="form-control" id="arquivo_pdf" name="arquivo_pdf"
                        accept="application/pdf">
                    <div class="form-text">Tamanho máximo recomendado: 10MB. Formato: .pdf</div>
                </div>
            </div>

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary btn-lg px-5">Salvar Edição</button>
            </div>
        </form>
    </main>

    <?php echo $__env->make('layouts/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        function alternarFormato() {
            const formatoEscolhido = document.querySelector('input[name="tipo_conteudo"]:checked').value;
            const sessaoBlocos = document.getElementById('sessao-blocos');
            const sessaoPdf = document.getElementById('sessao-pdf');
            const inputPdf = document.getElementById('arquivo_pdf');

            if (formatoEscolhido === 'blocos') {
                sessaoBlocos.style.display = 'block';
                sessaoPdf.style.display = 'none';
                inputPdf.removeAttribute('required');
            } else {
                sessaoBlocos.style.display = 'none';
                sessaoPdf.style.display = 'block';
                inputPdf.setAttribute('required', 'required');
            }
        }

        let contador = 0;

        function adicionarBloco(tipo) {
            contador++;
            const container = document.getElementById('blocos-container');
            const div = document.createElement('div');
            div.classList.add('card', 'p-3', 'mb-3', 'bloco', 'bg-light');
            div.dataset.id = contador;

            let conteudo = '';

            if (tipo === 'paragrafo') {
                conteudo = `
                    <label class="form-label fw-bold text-muted">Parágrafo</label>
                    <textarea name="conteudo[]" class="form-control" rows="3" required></textarea>
                    <input type="hidden" name="tipo[]" value="paragrafo">
                `;
            } else if (tipo === 'subtitulo') {
                conteudo = `
                    <label class="form-label fw-bold text-muted">Subtítulo</label>
                    <input type="text" name="conteudo[]" class="form-control" required>
                    <input type="hidden" name="tipo[]" value="subtitulo">
                `;
            } else if (tipo === 'imagem') {
                conteudo = `
                    <label class="form-label fw-bold text-muted">Imagem</label>
                    <input type="file" name="conteudo[]" class="form-control" accept="image/*" required>
                    <input type="hidden" name="tipo[]" value="imagem">
                `;
            }

            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <strong class="text-primary">${tipo.charAt(0).toUpperCase() + tipo.slice(1)}</strong>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="moverBloco(this, -1)" title="Mover para cima">▲</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary me-1" onclick="moverBloco(this, 1)" title="Mover para baixo">▼</button>
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

        function moverBloco(botao, direcao) {
            const bloco = botao.closest('.bloco');
            const container = document.getElementById('blocos-container');
            const blocos = [...container.children];
            const index = blocos.indexOf(bloco);

            if (direcao === -1 && index > 0) {
                container.insertBefore(bloco, blocos[index - 1]);
            } else if (direcao === 1 && index < blocos.length - 1) {
                container.insertBefore(bloco, blocos[index + 2]);
            }
        }
    </script>
</body>

</html><?php /**PATH D:\revista-avico\resources\views/revista/create.blade.php ENDPATH**/ ?>