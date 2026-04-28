<!DOCTYPE html>
<html lang="pt-br">
<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="page-top">
    <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gerenciar Usuários</h2>
            <a href="<?php echo e(route('admin.usuarios.create')); ?>" class="btn btn-success">+ Novo Usuário</a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        
        <?php if($pendentes->isNotEmpty()): ?>
            <div class="card border-warning shadow-sm mb-5">
                <div class="card-header bg-warning text-dark fw-bold">
                    ⏳ Contas Aguardando Aprovação (<?php echo e($pendentes->count()); ?>)
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Perfil</th>
                                <th>Cadastro</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pendentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($user->name); ?></td>
                                    <td><?php echo e($user->email); ?></td>
                                    <td><?php echo $user->role_badge_html; ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($user->created_at)->format('d/m/Y')); ?></td>
                                    <td class="text-center">
                                        
                                        <form action="<?php echo e(route('admin.usuarios.aprovar', $user->id)); ?>" method="POST"
                                            class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="btn btn-sm btn-success">
                                                ✅ Aprovar
                                            </button>
                                        </form>

                                        
                                        <form action="<?php echo e(route('admin.usuarios.destroy', $user->id)); ?>" method="POST"
                                            class="d-inline" onsubmit="return confirm('Rejeitar e excluir esta conta?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                ❌ Rejeitar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        
        <div class="card shadow-sm">
            <div class="card-header fw-bold bg-light">
                Usuários Ativos
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Perfil</th>
                            <th>Cadastro</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($user->id); ?></td>
                                <td><?php echo e($user->name); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <td><?php echo $user->role_badge_html; ?></td>
                                <td><?php echo e(\Carbon\Carbon::parse($user->created_at)->format('d/m/Y')); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('admin.usuarios.edit', $user->id)); ?>"
                                        class="btn btn-sm btn-outline-primary">Editar</a>

                                    <form action="<?php echo e(route('admin.usuarios.destroy', $user->id)); ?>" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <div class="p-3">
                    <?php echo e($usuarios->links()); ?>

                </div>
            </div>
        </div>
    </main>

    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH /var/www/html/resources/views/admin/usuarios/index.blade.php ENDPATH**/ ?>