<!DOCTYPE html>
<html lang="pt-br" class="fontawesome-i2svg-active fontawesome-i2svg-complete">

<?php echo $__env->make('layouts/head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="page-top">

    <?php echo $__env->make('layouts/topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main id="content" style="margin-bottom: 65px;">
        <section class="page-section">
            <div class="col-md-4 col-md-offset-4 container">
                <form action="<?php echo e(route('login')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <h3 class="text-center mb-4">Entre com a sua conta</h3>

                    <?php if(session('info')): ?>
                        <div class="alert alert-info"><?php echo e(session('info')); ?></div>
                    <?php elseif(session('error')): ?>
                        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
                    <?php endif; ?>
                    <div class="form-group mb-2">
                        <label class="form-label" for="emailInput">Email</label>
                        <input class="form-control" name="email" id="emailInput" type="email"
                            placeholder="Digite seu Email" required autofocus>
                    </div>

                    <div class="form-group mb-2">
                        <label class="form-label" for="passwordInput">Senha</label>
                        <input class="form-control" name="password" id="passwordInput" type="password"
                            placeholder="Digite sua Senha" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="mt-2 mb-2 btn btn-primary" type="submit">Login</button>
                    </div>

                    <div class="text-center">
                        <a href="/register" class="btn btn-outline-secondary">Não possui uma conta? Cadastre-se</a>
                        <a href="/redefinir_senha" class="d-block mb-2" style="font-size: 15px;">Esqueci minha senha</a>
                    </div>
                </form>
            </div>
        </section>
    </main>

    <?php echo $__env->make('layouts/footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>