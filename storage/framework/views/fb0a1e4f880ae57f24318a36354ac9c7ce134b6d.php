
<?php $__env->startSection('content'); ?>
<div class="container mt-3">
    <h3>Gerenciamento de Autores</h3>
    <hr>
    <div class="container" style="margin-bottom: 100px;">
        <table class="table table-borderless table-hover">
            <thead class="table-dark">
                <th scope="col">Id</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Endereço</th>
                <th scope="col">Telefone</th>
                <th scope="col">Data de criação</th>
                <th scope="col">Data de atualização</th>
                <th class="" scope="col">Editar</th>
                <th class="" scope="col">Deletar</th>
            </thead>
            <tbody>
                <?php $__currentLoopData = $autor; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr scope="row">
                    <td><?php echo e($autor->orcid); ?></td>
                    <td><?php echo e($autor->user->name); ?></td>
                    <td><?php echo e($autor->user->email); ?></td>
                    <td><?php echo e($autor->user->endereco); ?></td>
                    <td><?php echo e($autor->user->telefone); ?></td>
                    <td><?php echo e($autor->created_at); ?></td>
                    <td><?php echo e($autor->updated_at); ?></td>
                    <td class="text-center">
                        <a class="btn btn-primary" href="<?php echo e(route('edicao_autor', $autor->orcid)); ?>">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>            
                        </a>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#del-modal-<?php echo e($autor->orcid); ?>">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                    <!-- Modal -->
                    <div class="modal fade" id="del-modal-<?php echo e($autor->orcid); ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Deseja mesmo deletar esse usuário?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php echo e($autor->orcid); ?> - <?php echo e($autor->user->name); ?>  <!-- SE TIVER PROBLEMAS COMENTAR ESSA LINHA -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" >
                                    <a href="<?php echo e(route('exclusao_autor_modal', $autor->orcid)); ?>" style="color: white;text-decoration: none;">
                                    Sim
                                    </a>    
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\rp\rp4\resources\views/autor/gerenciar.blade.php ENDPATH**/ ?>