<?php
    use Illuminate\Support\Facades\DB;
?>

<?php $__env->startSection('content'); ?>

<div class="container mt-3" >
        <h3>Avaliações</h3>
        <hr>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <th scope="col">Nota</th>
                <th scope="col">Comentarios</th>
            </thead>
            <tbody>
                <?php $__currentLoopData = $avaliacao; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr scope="row">
                    <td><?php echo e($a->nota); ?></td>
                    <td><?php echo e($a->comentarios); ?></td>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desktop\rp4-revista\resources\views/avaliador\avaliacaonota.blade.php ENDPATH**/ ?>