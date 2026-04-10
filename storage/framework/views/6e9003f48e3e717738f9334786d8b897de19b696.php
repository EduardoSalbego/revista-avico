<!DOCTYPE html>
<html lang="pt-br" class="fontawesome-i2svg-active fontawesome-i2svg-complete">

<?php echo $__env->make('layouts/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="page-top">

    <?php echo $__env->make('layouts/topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main id="content">
        <header class="masthead"
            style="background-image: url('images/assets/img/home-bg.jpg'); padding-top: 100px; padding-bottom: 50px; min-height: 100vh;">
            <div class="container my-5">
                <h2 class="section-heading text-uppercase mb-4" style="color: black;">Edições da REVICO</h2>

                <form action="<?php echo e(route('edicoes.index')); ?>" method="GET" class="d-flex mb-5" role="search">
                    <input class="form-control me-2" type="search" name="busca" value="<?php echo e(request('busca')); ?>"
                        placeholder="Buscar edição pelo título..." aria-label="Buscar">
                    <button class="btn btn-primary" type="submit">Pesquisar</button>

                    
                    <?php if(request()->has('busca') && request('busca') != ''): ?>
                        <a href="<?php echo e(route('edicoes.index')); ?>" class="btn btn-outline-secondary ms-2">Limpar</a>
                    <?php endif; ?>
                </form>

                <div class="row">
                    
                    <?php if($edicoes->isEmpty()): ?>
                        <div class="col-12 text-center">
                            <p style="color: black; font-size: 1.2rem;">Nenhuma edição encontrada.</p>
                        </div>
                    <?php else: ?>
                        
                        <?php $__currentLoopData = $edicoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edicao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-md-4 px-3 mb-4 mt-4">
                                <div class="card shadow-sm h-100" style="width: 280px; margin:auto;">

                                    
                                    <img class="card-img-top d-block w-100" src="<?php echo e(asset($edicao->imagem_capa)); ?>"
                                        alt="REVICO #<?php echo e($edicao->id); ?>" height="290" style="object-fit: cover;">

                                    <div class="card-body d-flex flex-column">
                                        <p class="datanoticia mb-1 text-muted" style="font-size: 0.9rem;">
                                            <?php echo e(\Carbon\Carbon::parse($edicao->created_at)->format('d/m/Y')); ?>

                                        </p>
                                        <p class="card-text altura-linha mb-3" style="color: black;">
                                            <b>REVICO #<?php echo e($edicao->id); ?> - <?php echo e(Str::limit($edicao->titulo, 40)); ?></b>
                                        </p>

                                        
                                        <div class="mt-auto">
                                            <a class="btn btn-primary btn-sm w-100" href="/edicoes/<?php echo e($edicao->id); ?>">Leia
                                                Mais</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-center mt-5">
                    <?php echo e($edicoes->appends(request()->query())->links()); ?>

                </div>

            </div>
        </header>
    </main>

    <?php echo $__env->make('layouts/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH D:\revista-avico\resources\views/revista/edicoes.blade.php ENDPATH**/ ?>