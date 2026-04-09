<!DOCTYPE html>
<html lang="pt-br" class="fontawesome-i2svg-active fontawesome-i2svg-complete">

<?php echo $__env->make('layouts/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="page-top">
    <?php echo $__env->make('layouts/topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main id="content">
        <header class="masthead"
            style="background-image: url('<?php echo e(asset('images/assets/img/home-bg.jpg')); ?>'); padding-top: 50px;">
            <div class="container my-5 text-center">
                <img src="<?php echo e(asset('storage/imagens/logo_revista.png')); ?>" alt="Logo Revico"
                    style="max-width: 400px; width: 100%;">
            </div>
        </header>

        <div class="container"
            style="margin-top: -50px; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <header class="edicao-header mb-4 border-bottom pb-3">
                
                <span class="data me-3"><strong>Data:</strong>
                    <?php echo e(\Carbon\Carbon::parse($edicao->created_at)->format('d/m/Y')); ?></span>
                <span class="site me-3"><strong>Edição:</strong> #<?php echo e($edicao->id); ?></span>
                <span class="edicao"><strong>Autor:</strong> <?php echo e($edicao->autor); ?></span>
            </header>

            <div class="<?php echo e($edicao->tipo_conteudo === 'pdf' ? '' : 'artigo-duas-colunas'); ?>">
                <h1 class="mb-4"><?php echo e($edicao->titulo); ?></h1>

                
                <?php if($edicao->tipo_conteudo === 'pdf'): ?>

                    <div class="pdf-container my-5 text-center">
                        <iframe src="<?php echo e(asset($edicao->arquivo_pdf)); ?>" width="70%" height="1000px"
                            style="border: 1px solid #ccc; border-radius: 5px;">
                            Seu navegador não suporta a visualização de PDFs.
                        </iframe>
                        <div class="mt-3">
                            <a href="<?php echo e(asset($edicao->arquivo_pdf)); ?>" download class="btn btn-outline-primary">
                                Baixar PDF da Edição
                            </a>
                        </div>
                    </div>

                <?php elseif($edicao->tipo_conteudo === 'blocos'): ?>

                    
                    <?php
                        $blocos = json_decode($edicao->conteudo_blocos, true) ?? [];
                    ?>

                    
                    <?php $__currentLoopData = $blocos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bloco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($bloco['tipo'] === 'paragrafo'): ?>
                            <p class="mb-3" style="text-align: justify; line-height: 1.8;">
                                <?php echo e($bloco['conteudo']); ?>

                            </p>
                        <?php elseif($bloco['tipo'] === 'subtitulo'): ?>
                            <h3 class="mt-4 mb-3"><?php echo e($bloco['conteudo']); ?></h3>
                        <?php elseif($bloco['tipo'] === 'imagem'): ?>
                            <div class="text-center my-4">
                                <img src="<?php echo e(asset($bloco['conteudo'])); ?>" alt="Imagem do artigo" class="img-fluid rounded"
                                    style="max-height: 500px; object-fit: cover;">
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php endif; ?>

            </div>
        </div>

        <section class="py-5 bg-light mt-5">
            <div class="container">
                <h4 class="text-center mb-4">Comentários</h4>

                <div class="mb-5">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-1">Maria Luiza</h6>
                            <small class="text-muted">Postado em 05/10/2025</small>
                            <p class="card-text mt-2">Texto incrível! É fascinante como a ciência ainda está descobrindo
                                novas respostas sobre a covid.</p>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-1">João Pereira</h6>
                            <small class="text-muted">Postado em 04/10/2025</small>
                            <p class="card-text mt-2">Li a edição completa e fiquei impressionado com a pesquisa.
                                Parabéns à equipe da Revico!</p>
                        </div>
                    </div>
                </div>

                <div class="text-center mb-4">
                    <button id="toggleFormBtn" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">
                        💬 Deixe seu comentário
                    </button>
                </div>

                <div id="commentForm" class="card" style="display: none; max-width: 600px; margin: auto;">
                    <div class="card-body">
                        <h5 class="card-title">Novo Comentário</h5>
                        <form action="#" method="POST">
                            <?php echo csrf_field(); ?>
                            
                            <input type="hidden" name="edicao_id" value="<?php echo e($edicao->id); ?>">

                            <div class="mb-3">
                                <textarea class="form-control" name="comentario" id="comentario" rows="3"
                                    placeholder="Escreva aqui..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?php echo $__env->make('layouts.patrocinadores', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </main>
    <?php echo $__env->make('layouts/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        document.getElementById("toggleFormBtn").addEventListener("click", function () {
            const form = document.getElementById("commentForm");
            if (form.style.display === "none") {
                form.style.display = "block";
                this.textContent = "Fechar formulário";
                this.classList.remove("btn-primary");
                this.classList.add("btn-danger"); // Alterei para btn-danger para fazer sentido com o "Fechar"
            } else {
                form.style.display = "none";
                this.textContent = "💬 Deixe seu comentário";
                this.classList.remove("btn-danger");
                this.classList.add("btn-primary");
            }
        });
    </script>
</body>

</html><?php /**PATH D:\revista-avico\resources\views/revista/show.blade.php ENDPATH**/ ?>