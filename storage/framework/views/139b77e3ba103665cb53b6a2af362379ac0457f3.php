<!DOCTYPE html>
<html lang="pt-br">
<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="page-top" class="bg-light">
    <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gerenciar Edições</h2>
            <a href="<?php echo e(route('edicoes.create')); ?>" class="btn btn-success">+ Nova Edição</a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Capa</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Capítulos</th>
                            <th>Status</th>
                            <th>Data de Publicação</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $edicoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edicao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>#<?php echo e($edicao->id); ?></td>
                                <td>
                                    <img src="<?php echo e(asset($edicao->imagem_capa)); ?>" alt="Capa"
                                        style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px;">
                                </td>
                                <td style="max-width: 250px;" class="text-truncate" title="<?php echo e($edicao->titulo); ?>">
                                    <?php echo e($edicao->titulo); ?>

                                </td>
                                <td><?php echo e($edicao->autor); ?></td>
                                <td>ㅤㅤ<?php echo e($edicao->capitulos()->count()); ?></td>
                                <td>
                                    <?php if($edicao->status === 'publicado'): ?>
                                        <span class="badge bg-success">Publicado</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Rascunho</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e(\Carbon\Carbon::parse($edicao->created_at)->format('d/m/Y')); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('edicoes.show', $edicao->id)); ?>" target="_blank"
                                        class="btn btn-sm btn-outline-secondary" title="Visualizar">
                                        Ver
                                    </a>

                                    <a href="<?php echo e(route('admin.edicoes.edit', $edicao->id)); ?>" target="_blank"
                                        class="btn btn-sm btn-outline-secondary" title="Editar">
                                        Editar
                                    </a>

                                    <form action="<?php echo e(route('admin.edicoes.destroy', $edicao->id)); ?>" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('ATENÇÃO: Tem certeza que deseja excluir a edição #<?php echo e($edicao->id); ?>? Esta ação não pode ser desfeita.');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            title="Excluir">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Nenhuma edição publicada ainda.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="mt-4 d-flex justify-content-center">
                    <?php echo e($edicoes->links()); ?>

                </div>
            </div>
        </div>
    </main>

    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH /var/www/html/resources/views/admin/edicoes/index.blade.php ENDPATH**/ ?>