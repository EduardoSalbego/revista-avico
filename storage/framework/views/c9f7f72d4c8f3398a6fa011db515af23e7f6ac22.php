<?php

use Illuminate\Support\Facades\DB;
?>
<!-- Scripts -->
<script src="<?php echo e(asset('js/search.js')); ?>" defer></script>

<!-- Styles -->
<link href="<?php echo e(asset('css/select.css')); ?>" rel="stylesheet" type="text/css">


<?php $__env->startSection('content'); ?>
<?php $periodos_de_chamado = ""; ?>
<div class="container mt-3">
    <?php if(session()->has('success_msg')): ?>
    <div class="container w-50 mt-3">
        <div class="alert alert-success text-center">
            <?php echo e(session()->get('success_msg')); ?>

        </div>
    </div>
    <?php endif; ?>
    <h3>Edições da revista: <?php echo e($revista->tituloRevista); ?></h3>
    <hr>
    <div class="pagination justify-content-center" style="color: black;">
        <?php echo e($edicoes->links("pagination::bootstrap-4")); ?>

    </div>
    <div class="container" style="margin-bottom: 100px;">
        <table style="transition:none !important;" class="table table-borderless table-hover">
            <thead class="table-dark">
                <th scope="col">Número da Edicao</th>
                <th scope="col">Artigos</th>
            </thead>
            <tbody>
                <?php $__currentLoopData = $edicoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edicao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr scope="row">
                    <td><?php echo e($edicao->id); ?></td>
                    <td class="col col-3">

                        <?php
                        $artigos = DB::table('artigos')->where('edicao_id', $edicao->id)->get();
                        ?>
                        <?php $__currentLoopData = $artigos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artigo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a target="_blank" href="<?php echo e(asset('storage/' . $artigo->caminhoArtigo)); ?>">
                            <small>
                                <p class="articles mb-1 text-center p-1"><?php echo e($artigo->tituloArtigo); ?></br></p>
                            </small>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

    </div>
    <?php if (isset($component)) { $__componentOriginal88b1957f21f7f49b400717e8d0a27189798132bf = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Footer::class, []); ?>
<?php $component->withName('footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88b1957f21f7f49b400717e8d0a27189798132bf)): ?>
<?php $component = $__componentOriginal88b1957f21f7f49b400717e8d0a27189798132bf; ?>
<?php unset($__componentOriginal88b1957f21f7f49b400717e8d0a27189798132bf); ?>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desktop\rp4-revista\resources\views/edicao/manage.blade.php ENDPATH**/ ?>