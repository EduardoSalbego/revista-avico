<!DOCTYPE html>
<html lang="pt-br">
<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="page-top" class="bg-light">
    <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">
        <div class="row">

            <div class="col-12 mb-4">
                <h2>Meu Perfil</h2>
                <p class="text-muted">Gerencie seus dados de acesso e assinatura da plataforma.</p>
            </div>

            
            <div class="col-12">
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4">Dados Pessoais</h4>

                        <form action="<?php echo e(route('perfil.update')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nome Completo</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?php echo e(old('name', $user->name)); ?>" required>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">E-mail de Acesso</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?php echo e(old('email', $user->email)); ?>" required>
                            </div>

                            <hr class="mb-4">
                            <h5 class="mb-3">Segurança</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-bold">Nova Senha</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Mínimo 8 caracteres">
                                    <div class="form-text">Deixe em branco se não quiser alterar.</div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="password_confirmation" class="form-label fw-bold">Confirmar Nova
                                        Senha</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Repita a nova senha">
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100 bg-primary text-white">
                    <div class="card-body p-4 d-flex flex-column">
                        <h4 class="card-title mb-4 border-bottom border-light pb-2">Seu Status</h4>

                        <div class="mb-4">
                            <h6 class="text-white-50 text-uppercase mb-1">Nível de Acesso</h6>
                            <p class="fs-5 fw-bold mb-0">
                                <?php if($user->perfil === 'admin'): ?>
                                    Administrador
                                <?php elseif($user->perfil === 'colaborador'): ?>
                                    Colaborador
                                <?php else: ?>
                                    Leitor
                                <?php endif; ?>
                            </p>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-white-50 text-uppercase mb-1">Assinatura ReVICO</h6>
                            <?php if($user->assinante_ate && \Carbon\Carbon::parse($user->assinante_ate)->isFuture()): ?>
                                <p class="fs-5 fw-bold text-warning mb-0">
                                    <i class="fas fa-crown me-2"></i> Ativa
                                </p>
                                <small class="text-light">Válida até
                                    <?php echo e(\Carbon\Carbon::parse($user->assinante_ate)->format('d/m/Y')); ?></small>
                            <?php else: ?>
                                <p class="fs-5 fw-bold text-light mb-0">
                                    Inativa
                                </p>
                                <small class="text-light">Você não possui um plano ativo.</small>
                            <?php endif; ?>
                        </div>

                        <div class="mt-auto pt-4">
                            <a href="<?php echo e(route('assinar')); ?>" class="btn btn-light w-100 fw-bold text-primary">
                                <?php echo e(($user->assinante_ate && \Carbon\Carbon::parse($user->assinante_ate)->isFuture()) ? 'Renovar / Estender Plano' : 'Assinar Agora'); ?>

                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH D:\revista-avico\resources\views/perfil/index.blade.php ENDPATH**/ ?>