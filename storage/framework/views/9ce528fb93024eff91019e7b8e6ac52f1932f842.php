<!DOCTYPE html>
<html lang="pt-br">
<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="page-top" class="bg-light">
    <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Editar Usuário: <span class="text-primary"><?php echo e($usuario->name); ?></span></h2>
                    <a href="<?php echo e(route('admin.usuarios.index')); ?>" class="btn btn-outline-secondary">Voltar para a
                        Lista</a>
                </div>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        
                        <form action="<?php echo e(route('admin.usuarios.update', $usuario->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nome Completo</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php echo e(old('name', $usuario->name)); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Endereço de E-mail</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo e(old('email', $usuario->email)); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label fw-bold">Perfil de Acesso</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="leitor" <?php echo e((old('role', $usuario->role) == 'leitor') ? 'selected' : ''); ?>>Leitor</option>
                                    <option value="colaborador" <?php echo e((old('role', $usuario->role) == 'colaborador') ? 'selected' : ''); ?>>Colaborador (Pode enviar textos)</option>
                                    <option value="admin" <?php echo e((old('role', $usuario->role) == 'admin') ? 'selected' : ''); ?>>Administrador (Acesso total)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold text-danger">Nova Senha
                                    (Opcional)</label>
                                <input type="password" class="form-control border-danger" id="password" name="password"
                                    minlength="8">
                                <div class="form-text text-muted">Deixe em branco para não alterar a
                                    senha do usuário.</div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Atualizar Dados</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH D:\revista-avico\resources\views/admin/usuarios/edit.blade.php ENDPATH**/ ?>