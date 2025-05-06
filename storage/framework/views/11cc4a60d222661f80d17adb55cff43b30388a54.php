 <!-- Styles -->
 <link href="<?php echo e(asset('css/select.css')); ?>" rel="stylesheet" type="text/css">

 

 <?php $__env->startSection('content'); ?>
     <div class="container mt-3">
         <h3>Submissões</h3>
         <hr>
         <div class="pagination justify-content-center" style="color: black;">
             <?php echo e($submissoes->links('pagination::bootstrap-4')); ?>

         </div>
         <div class="container" style="margin-bottom: 100px;">
             <table class="table table-borderless table-hover">
                 <thead class="table-dark">
                     <th scope="col">Revista Referenciada</th>
                     <th scope="col">Data de Submissão</th>
                     <th class="" scope="col"></th>
                 </thead>
                 <tbody>
                     <?php $__currentLoopData = $submissoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submissao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <tr scope="row" class="align-middle">
                             <td><?php echo e($submissao->revista->tituloRevista); ?></td>
                             <td><?php echo e($submissao->created_at); ?></td>
                             <td class="text-center">
                                <a class="btn btn-primary" href="<?php echo e(route('listar_artigos_submissao', $submissao->id)); ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                </a>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desktop\rp4-revista\resources\views/avaliador\listar_submissoes.blade.php ENDPATH**/ ?>