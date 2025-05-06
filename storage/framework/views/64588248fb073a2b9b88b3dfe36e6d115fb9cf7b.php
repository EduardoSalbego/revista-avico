<?php
use Illuminate\Support\Facades\DB;
?>



<?php $__env->startSection('content'); ?>
    <div class="container pt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="col-md-12">
                    <h3 class="text-center">Atribuição de Avaliações para Avaliadores</h3>
                    <hr>
                    <div class="pagination justify-content-center" style="color: black;">
                        <?php echo e($avaliadores->links('pagination::bootstrap-4')); ?>

                    </div>

                    <?php if(Session::has('message')): ?>
                        <p style="color: green;" class=""><?php echo e(Session::get('message')); ?></p>
                    <?php elseif(Session::has('error')): ?>
                    <p style="color:red;"><?php echo e(Session::get('error')); ?>

                    </p>
                    <?php endif; ?>


                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <th scope="col">Avaliador</th>
                                <th scope="col">Área de preferência</th>
                                <th scope="col">Atribuir Artigo</th>
                            </thead>
                            <tr scope="row" class="align-middle">
                                <tbody>
                                    <?php $__currentLoopData = $avaliadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avaliador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr scope="row">
                                            <td><?php echo e($avaliador->user->name); ?></td>
                                            <td><?php echo e($avaliador->area->descricaoArea); ?></td>
                                            <td class="text-center">
                                                <a class="btn btn-primary" id="artigos-modal" value="<?php echo e($avaliador->id); ?>"
                                                    data-bs-toggle="modal" data-bs-target="#artigos-<?php echo e($avaliador->id); ?>">
                                                    <i class="fa fa-address-book" aria-hidden="true"></i>
                                                </a>

                                                <!-- Modal -->
                                                <div class="modal fade" id="artigos-<?php echo e($avaliador->id); ?>" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Artigos
                                                                    disponíveis</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="<?php echo e(route('atribuir.avaliacao', $avaliador->id)); ?>"
                                                                method="POST">
                                                                <?php echo csrf_field(); ?>
                                                                <select name="artigo" id="artigo">
                                                                    <?php

                                                                    $artigos = DB::table('artigos')->get();
                                                                    foreach ($artigos as $artigo) {
                                                                        echo '<option value=' . $artigo->id . '>' . $artigo->tituloArtigo . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>

                                                                <div class="col form-group">
                                                                    <input type="submit" name="submit" id="salvar"
                                                                        class="btn btn-success btn-md col-6"
                                                                        style="color:white;" value="Salvar">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Desktop\rp4-revista\resources\views/editores\atribuirava.blade.php ENDPATH**/ ?>