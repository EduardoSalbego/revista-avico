<!DOCTYPE html>
<html lang="pt-br">
<?php echo $__env->make('layouts/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="page-top">
    <?php echo $__env->make('layouts/topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="container py-5" style="margin-top: 50px;">
        <h2 class="text-center mb-4">
            Criando a edição #<?php echo e($proximaEdicao ?? '1'); ?> da revista
        </h2>

        <form action="" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <label for="titulo" class="form-label">Título da Edição</label>
                <input type="text" class="form-control" id="titulo" name="titulo"
                    placeholder="Ex: Edição de Outubro 2025" required>
            </div>

            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input type="text" class="form-control" id="autor" name="autor" placeholder="Nome do autor principal"
                    required>
            </div>

            <div class="mb-3">
                <label for="imagem_capa" class="form-label">Imagem de Capa</label>
                <input type="file" class="form-control" id="imagem_capa" name="imagem_capa" accept="image/*" required>
            </div>

            <hr>

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

            <div class="mt-5 text-center">
                <button type="submit" class="btn btn-primary btn-lg">Salvar Edição</button>
            </div>
        </form>
    </main>

    <?php echo $__env->make('layouts/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        let contador = 0;

        function adicionarBloco(tipo) {
            contador++;
            const container = document.getElementById('blocos-container');
            const div = document.createElement('div');
            div.classList.add('card', 'p-3', 'mb-3', 'bloco');
            div.dataset.id = contador;

            let conteudo = '';

            if (tipo === 'paragrafo') {
                conteudo = `
                    <label>Parágrafo</label>
                    <textarea name="conteudo[]" class="form-control" rows="3" required></textarea>
                    <input type="hidden" name="tipo[]" value="paragrafo">
                `;
            } else if (tipo === 'subtitulo') {
                conteudo = `
                    <label>Subtítulo</label>
                    <input type="text" name="conteudo[]" class="form-control" required>
                    <input type="hidden" name="tipo[]" value="subtitulo">
                `;
            } else if (tipo === 'imagem') {
                conteudo = `
                    <label>Imagem</label>
                    <input type="file" name="conteudo[]" class="form-control" accept="image/*" required>
                    <input type="hidden" name="tipo[]" value="imagem">
                `;
            }

            div.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <strong>${tipo.charAt(0).toUpperCase() + tipo.slice(1)}</strong>
                    <div>
                        <button type="button" class="btn btn-sm btn-outline-primary me-1" onclick="moverBloco(this, -1)">▲</button>
                        <button type="button" class="btn btn-sm btn-outline-primary me-1" onclick="moverBloco(this, 1)">▼</button>
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