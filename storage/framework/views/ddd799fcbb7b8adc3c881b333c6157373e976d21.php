 <!-- Styles -->
 <link href="<?php echo e(asset('css/select.css')); ?>" rel="stylesheet" type="text/css">

 

 <?php $__env->startSection('content'); ?>
     <div class="container mt-3">
         <h3>Artigos Submetidos</h3>
         <hr>
         <div class="pagination justify-content-center" style="color: black;">
             
         </div>
         <div class="container" style="margin-bottom: 100px;">
             <table class="table table-borderless table-hover">
                 <thead class="table-dark">
                     <th scope="col">Artigo</th>
                     <th scope="col">Data de Submissão</th>
                     <th scope="col">Data Final da Avaliacao</th>
                     <th class="" scope="col"></th>
                 </thead>
                 <tbody>
                     <?php $id = Auth::id();
                     $avaliador = DB::table('avaliadors')
                         ->where('user_id', $id)
                         ->first(); ?>
                     <?php $__currentLoopData = $submissoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submissao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <tr scope="row" class="align-middle">

                             <?php $artigo = DB::table('artigos')
                                 ->where('id', $submissao->artigo_id)
                                 ->first();

                             $artigoavaliador = DB::table('artigoavaliador')
                                 ->where('avaliador_id', $avaliador->id)
                                 ->get();

                             $avaliacao = DB::table('avaliacao')
                                 ->where('avaliador_id', $id)
                                 ->first();

                             $submissao_id = DB::table('submissao')
                                 ->where('id', $submissao->submissao_id)
                                 ->first();

                             $periodo = DB::table('periodochamada')
                                 ->where('revista_id', $submissao_id->revista_id)
                                 ->first();

                             ?>

                             <?php $__currentLoopData = $artigoavaliador; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <?php if($result->artigo_id == $artigo->id): ?>
                                     <?php
                                     $a = DB::table('avaliacao')
                                     ->where('avaliador_id', $avaliador->id)
                                     ->where('artigo_id', $result->artigo_id)
                                     ->first();

                                     ?>
                                     <td><?php echo e($artigo->tituloArtigo); ?></td>
                                     <td><?php echo e($artigo->created_at); ?></td>
                                     <td><?php echo e($periodo->dataMaximaAvaliacao); ?></td>
                                     <td class="text-center">
                                         <a class="btn btn-primary"
                                             href="<?php echo e(route('avaliar.artigo', $artigo->id)); ?>">
                                             <i class="fa fa-check-square" aria-hidden="true"></i>
                                         </a>
                                         <a class="btn btn-primary"
                                             href="<?php echo e(route('avaliarartigo')); ?>">
                                             <i class="fa fa-eye" aria-hidden="true"></i>
                                         </a>
                                     </td>
                                 <?php endif; ?>
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desktop\rp4-revista\resources\views/avaliador\listarartigossubmissao.blade.php ENDPATH**/ ?>