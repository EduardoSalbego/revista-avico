<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="<?php echo e(asset('storage/imagens/logo_revista_com_texto.png')); ?>" alt="Logo REVICO"
                style="height: 60px;"></a>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('edicoes.index')); ?>">EDIÇÕES</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/">Autores e Colaboradores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/sobre_nos">Sobre a Revico</a>
                </li>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(in_array(Auth::user()->role, ['admin', 'colaborador'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('edicoes.create')); ?>">nova edição</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/assinar">assine</a>
                        </li>
                    <?php endif; ?>


                    <div class="dropdown">
                        <button class="btn btn-secondary btn-nav-drop dropdown-toggle nav-item nav-link" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                            style="text-transform: uppercase;">
                            <?php echo e(Auth::user()->name); ?>

                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php if(Auth::user()->role === 'admin'): ?>
                                <li><a class="dropdown-item" href="/admin/usuarios">Gerenciar Usuários</a></li>
                                <li><a class="dropdown-item" href="/admin/edicoes">Gerenciar Edições</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            <?php endif; ?>

                            <li><a class="dropdown-item" href="/perfil">Perfil</a></li>
                            <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button class="dropdown-item" type="submit" class="dropdown-item">SAIR</button>
                            </form>
                        </ul>
                    </div>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav><?php /**PATH /var/www/html/resources/views/layouts/topbar.blade.php ENDPATH**/ ?>