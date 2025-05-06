<?php
    use Illuminate\Support\Facades\DB;
?>

<?php $__env->startSection('content'); ?>

<div class="container mt-3" >
        <h3>Gerenciamento de Avaliadores</h3>
        <hr>
        <div class="pagination justify-content-center" style="color: black;">
            <?php echo e($avaliador->links("pagination::bootstrap-4")); ?>

        </div>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <th scope="col">Id</th>
                <th scope="col">Nome</th>
                <th scope="col">Endereço</th>
                <th scope="col">Email</th>
                <th scope="col">Telefone</th>
                <th scope="col">Área de Preferência</th>
                <th class="table-borderless" scope="col">Editar</th>
                <th class="table-borderless" scope="col">Excluir</th>
            </thead>
            <tbody>
                <?php $__currentLoopData = $avaliador; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $avaliador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr scope="row">

                    <td><?php echo e($avaliador->id); ?></td>
                    <td><?php echo e($avaliador->user->name); ?></td>
                    <td><?php echo e($avaliador->user->endereco); ?></td>
                    <td><?php echo e($avaliador->user->email); ?></td>
                    <td><?php echo e($avaliador->user->telefone); ?></td>
                    <td><?php echo e($avaliador->area->descricaoArea); ?></td>
                    <!-- <td><?php echo e($avaliador->pais_origem); ?></td>
                    <td><?php echo e($avaliador->area_pref); ?></td> -->

                    <td class="text-center">
                        <a class="btn btn-primary" href="<?php echo e(route('editarAvaliador', $avaliador->id)); ?>">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#del-modal">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="del-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deseja mesmo deletar esse Avaliador?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php echo e($avaliador->user->name); ?>  <!-- SE TIVER PROBLEMAS COMENTAR ESSA LINHA -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" >
                                <a href="<?php echo e(route('deletarAvaliador', $avaliador->id)); ?>" style="color: white;text-decoration: none;">
                                Sim
                                </a>
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                        </div>
                        </div>
                    </div>
                </div>
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



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\rp\rp4\resources\views/avaliador\manage.blade.php ENDPATH**/ ?>