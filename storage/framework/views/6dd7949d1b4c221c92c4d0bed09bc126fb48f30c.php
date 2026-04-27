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
                
                <span class="data me-3">
                    <?php echo e(\Carbon\Carbon::parse($edicao->created_at)->format('d/m/Y')); ?></span>
                <span class="site me-3">Edição #<?php echo e($edicao->id); ?></span>
                <span class="edicao"> <?php echo e($edicao->autor); ?></span>
            </header>

            <h2 class="mb-4" style="text-align: center;"><?php echo e($edicao->titulo); ?></h2>
            <?php $__currentLoopData = $edicao->capitulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $capitulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <h3><?php echo e($capitulo->titulo); ?></h3>
                <div class="conteudo-edicao artigo-duas-colunas">
                    <?php echo $capitulo->conteudo_html; ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <section class="py-5 bg-light mt-5">
            <div class="container">
                <h4 class="text-center mb-4">Comentários (<?php echo e($comentarios->count()); ?>)</h4>

                <?php if(session('success')): ?>
                    <div class="alert alert-success text-center max-w-600 mx-auto" style="max-width: 600px;">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <div class="mb-5" style="max-width: 800px; margin: 0 auto;">
                    
                    <?php $__empty_1 = true; $__currentLoopData = $comentarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comentario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="card mb-3 shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1 text-primary"><?php echo e($comentario->user->name); ?></h6>
                                        <small class="text-muted">Postado em
                                            <?php echo e(\Carbon\Carbon::parse($comentario->created_at)->format('d/m/Y')); ?></small>
                                    </div>
                                    <?php if(auth()->guard()->check()): ?>
                                        <?php if(Auth::id() === $comentario->user_id || Auth::user()->role === 'admin'): ?>
                                            <form action="<?php echo e(route('comentarios.destroy', $comentario->id)); ?>" method="POST"
                                                onsubmit="return confirm('Tem certeza que deseja apagar este comentário?');">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    title="Apagar comentário">
                                                    <i class="bi bi-trash-fill"></i> </button>
                                            </form>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <p class="card-text mt-3" style="white-space: pre-line;"><?php echo e($comentario->conteudo); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-center text-muted">Nenhum comentário ainda. Seja o primeiro a comentar!</p>
                    <?php endif; ?>
                </div>

                <?php if(auth()->guard()->check()): ?>
                    <div class="text-center mb-4">
                        <button id="toggleFormBtn" class="btn btn-primary px-4 py-2 shadow-sm" style="border-radius: 8px;">
                            Deixe um comentário
                        </button>
                    </div>

                    <div id="commentForm" class="card shadow"
                        style="display: none; max-width: 600px; margin: auto; border: 0;">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">Novo Comentário</h5>
                            <form action="<?php echo e(route('comentarios.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="edicao_id" value="<?php echo e($edicao->id); ?>">

                                <div class="mb-3">
                                    <textarea class="form-control bg-light" name="comentario" id="comentario" rows="4"
                                        placeholder="Escreva sua opinião aqui..." required></textarea>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">Enviar Comentário</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center mt-4">
                        <p class="text-muted">Você precisa estar logado para comentar.</p>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary">Fazer Login</a>
                    </div>
                <?php endif; ?>
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
                this.textContent = "Cancelar";
                this.classList.remove("btn-primary");
                this.classList.add("btn-danger");
            } else {
                form.style.display = "none";
                this.textContent = "Deixe um comentário";
                this.classList.remove("btn-danger");
                this.classList.add("btn-primary");
            }
        });
    </script>
</body>

</html><?php /**PATH /var/www/html/resources/views/revista/show.blade.php ENDPATH**/ ?>