 <!-- Styles -->
 <link href="<?php echo e(asset('css/select.css')); ?>" rel="stylesheet" type="text/css">



<?php $__env->startSection('content'); ?>
<div class="container mt-3">
    <h3>Submissões Pendentes</h3>
    <hr>
    <h6 class="text-center" id="obrigatorio"><small><?php echo session()->get('erro004'); ?></small></h6>
    <div class="pagination justify-content-center" style="color: black;">
            <?php echo e($submissoes->links("pagination::bootstrap-4")); ?> 
    </div>
    <div class="container" style="margin-bottom: 100px;">
        <table style="transition:none !important;" class="table table-borderless table-hover">
            <thead class="table-dark">
                <th scope="col">Revista</th>
                <th scope="col">Artigos</th>
                <th scope="col">Status</th>
                <th scope="col">Autores</th>
                <th scope="col">Data de Submissão</th>
                <th class="" scope="col"></th>
            </thead>
            <tbody>
                <?php $__currentLoopData = $submissoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submissao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr scope="row" class="align-middle">

                    <td><p class="text-center"><?php echo e($submissao->revista->tituloRevista); ?></p></td>
                    <td class="col col-3">
                    <?php $__currentLoopData = $submissao->artigos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artigo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                    
                        <a target="_blank" href="<?php echo e(asset('storage/' . $artigo->caminhoArtigo)); ?>">
                            <small><p class="articles mb-1 text-center p-1"><?php echo e($artigo->tituloArtigo); ?></br></p></small>    
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td class="col-2">
                    <?php $__currentLoopData = $submissao->artigos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $artigo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <small><p class="status mb-1 text-center p-1"><?php echo e($artigo->situacao->descricaoSituacao); ?></br></p></small>    
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>

                    <td>                        
                        <?php $__currentLoopData = $submissao->artigos[0]->autores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <small><p class="selected-author p-1 mb-1 text-center"><?php echo e($autor->user->name); ?></br></p></small>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>

                    <td><p class="text-center"><?php echo e(date('d/m/Y H:i:s', strtotime($submissao->created_at))); ?></p></td>
                    
                    <td class="text-center">
                        <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#del-modal-<?php echo e($submissao->id); ?>">
                            <i class="fa fa-times" style="transition:none !important;" aria-hidden="true"></i>
                        </a>
                    </td>
                    <!-- Modal -->
                    <div class="modal fade" id="del-modal-<?php echo e($submissao->id); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Deseja mesmo cancelar a submissão?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" >
                                    <a href="<?php echo e(route('delete.submissao', $submissao->id)); ?>" style="color: white;text-decoration: none;">Sim</a>    
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\rp\rp4\resources\views/artigo/submissoes.blade.php ENDPATH**/ ?>