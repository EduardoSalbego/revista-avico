<!-- Scripts -->
<script src="<?php echo e(asset('js/search.js')); ?>" defer></script>

 <!-- Styles -->
 <link href="<?php echo e(asset('css/select.css')); ?>" rel="stylesheet" type="text/css">


<?php $__env->startSection('content'); ?>
<?php $periodos_de_chamado = "";?>
<div class="container mt-3">
    <h3>Gerenciamento de Revistas</h3>
    <hr>
    <div class="pagination justify-content-center" style="color: black;">
            <?php echo e($revistas->links("pagination::bootstrap-4")); ?> 
    </div>
    <div class="container" style="margin-bottom: 100px;">
        <table style="transition:none !important;" class="table table-borderless table-hover">
            <thead class="table-dark">
                <th scope="col">Id</th>
                <th scope="col">Título</th>
                <th scope="col">Editor</th>
                <th scope="col">ISSN</th>
                <th scope="col">Limite de Artigos</th>
                <th scope="col">Área</th>
                <th scope="col">Período de Chamado</th>
                <th scope="col">Periodicidade</th>
                <th class="" scope="col"></th>
                <th class="" scope="col"></th>
            </thead>
            <tbody>
                <?php $__currentLoopData = $revistas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $revista): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr scope="row">

                    <td><?php echo e($revista->id); ?></td>
                    <td><?php echo e($revista->tituloRevista); ?></td>
                    <td><?php echo e($revista->editor->user->name); ?></td>
                    <td><?php echo e($revista->ISSNRevista); ?></td>
                    <td><?php echo e($revista->limiteArtigo); ?></td>
                    <td><?php echo e($revista->area->descricaoArea); ?></td>
                    <td><a class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#chamados-<?php echo e($revista->ISSNRevista); ?>">Visualizar</a></td>
                    <td><?php echo e($revista->periodicidade->descricaoPeriodicidade); ?></td>
                    
                    <td class="text-center">
                        <a class="btn btn-primary" href="<?php echo e(route('select.revista', $revista->id)); ?>">
                            <i class="fa fa-pencil-square-o" style="transition:none !important;" aria-hidden="true"></i>            
                        </a>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#del-modal-<?php echo e($revista->ISSNRevista); ?>">
                            <i class="fa fa-trash-o" style="transition:none !important;" aria-hidden="true"></i>
                        </a>
                    </td>
                    <!-- Chamados Modal -->
                    <div class="modal fade" id="chamados-<?php echo e($revista->ISSNRevista); ?>" tabindex="-1" aria-labelledby="modal2" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header justify-content-center">
                                    <h5 class="modal-title text-center" id="modal2">Períodos de Chamado </h5> <br>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <p class="fw-light fs-5"><?php echo e($revista->tituloRevista); ?></p>
                                <?php $__currentLoopData = $revista->periodo_chamada; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chamado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $periodos_de_chamado ?>
                                    <div class="row card rounded shadow m-3 pb-4 pt-4 text-center">                                                                  
                                        <div class="row d-flex text-center  justify-content-center">
                                            <label class="col-4 fw-bold fs-10">Data Inicio</label><label class="col-4 fw-bold fs-10">Data Final</label>                                  
                                            <div class="row justify-content-center text-center">
                                                <span class="col-4"><?php echo e(date('d/m/y', strtotime($chamado->dataInicio))); ?></span>
                                                <span class="col-4"><?php echo e(date('d/m/y', strtotime($chamado->dataFinal))); ?></span> 
                                            </div>                                
                                        </div>
                                        <div class="row d-flex text-center mt-2 justify-content-center">
                                            <small>
                                            <span class="col col-4 text-center">
                                                <span class="fs-10">Divulgado em</span>
                                                <?php echo e(date('d/m/y', strtotime($chamado->dataDivulgacao))); ?>

                                            </span>
                                            -
                                            <span class="col col-4 text-center">
                                                <span class="fs-10">Avaliações até</span>
                                                <?php echo e(date('d/m/y', strtotime($chamado->dataMaximaAvaliacao))); ?>

                                            </span>
                                            </small>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                           
                                </div>
                            </div>
                        </div>   
                    </div> 
                    <!-- Fim Modal -->

                    <!-- Deletar Modal -->
                    <div class="modal fade" id="del-modal-<?php echo e($revista->ISSNRevista); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Deseja mesmo deletar a revista ?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="fw-light fs-5"><?php echo e($revista->tituloRevista); ?></p> 
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" >
                                    <a href="<?php echo e(route('delete.revista', $revista->id)); ?>" style="color: white;text-decoration: none;">
                                    Sim
                                    </a>    
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                            </div>
                            </div>
                        </div>
                    </div>  
                    <!-- Fim Modal -->
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\rp\rp4\resources\views/revista\manage.blade.php ENDPATH**/ ?>