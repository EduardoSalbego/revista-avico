<!DOCTYPE html>
<html lang="pt-br" class="fontawesome-i2svg-active fontawesome-i2svg-complete">

@include('layouts/head')

<body id="page-top">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="storage/app/public/imagens/logo_revista_com_texto.png" alt="Logo REVICO"
                    style="height: 60px;"></a>
            <button class="navbar-toggler items-center" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                aria-label="Toggle navigation">
                <svg class="svg-inline--fa fa-bars ms-1" aria-hidden="true" focusable="false" data-prefix="fas"
                    data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                    data-fa-i2svg="">
                    <path fill="currentColor"
                        d="M0 96C0 78.33 14.33 64 32 64H416C433.7 64 448 78.33 448 96C448 113.7 433.7 128 416 128H32C14.33 128 0 113.7 0 96zM0 256C0 238.3 14.33 224 32 224H416C433.7 224 448 238.3 448 256C448 273.7 433.7 288 416 288H32C14.33 288 0 273.7 0 256zM416 448H32C14.33 448 0 433.7 0 416C0 398.3 14.33 384 32 384H416C433.7 384 448 398.3 448 416C448 433.7 433.7 448 416 448z">
                    </path>
                </svg><!-- <i class="fas fa-bars ms-1"></i> Font Awesome fontawesome.com -->
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/edicoes">EDIÇÕES</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/">Autores e Colaboradores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/">Sobre a Revico</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/">assine</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <main id="content" style="margin-bottom: 79px;">
        <section class="page-section container">
            <form action="https://avicobrasil.com.br/forgot-password" method="post">
                <input type="hidden" name="_token" value="1YfeHZwJ87K8cwljkVEbutM8ODkFZBFNInQ4Oi3g">
                <h1 class="text-center">Recuperação de senha</h1>
                <div
                    class="container-fluid d-md-grid gap-md-2 col-md-6 mx-auto bg-light shadow p-3 mb-5 bg-white rounded">
                    <div class="form-group">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control mb-3" name="email" id="email" type="email">
                        <div>
                            <div class="mt-1 mb-1">
                                <span class="text-danger">
                                </span>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Enviar email para recuperação de senha</button>
                </div>
            </form>
        </section>
    </main>

    @include('layouts/footer')
</body>

</html>