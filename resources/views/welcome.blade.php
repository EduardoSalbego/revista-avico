<!DOCTYPE html>
<html lang="pt-br" class="fontawesome-i2svg-active fontawesome-i2svg-complete">

@include('layouts/head')

<body id="page-top">
    @include('layouts/topbar')

    <main id="content">
        <header class="masthead" style="background-image: url('images/assets/img/home-bg.jpg')">
            <div class="container">
                <img src="storage/app/public/imagens/logo_revista.png" alt="Logo REVICO"
                    style="height: 150px; margin-top: -60px; margin-bottom: 35px;">
                <div class="masthead-subheading text-primary">Apoie nosso trabalho e ajude a manter a REVICO e a AVICO
                    ativas!</div>
                <a class="btn btn-primary btn-xl text-uppercase mb-3" href="/nova_edicao">Assine a REVICO</a>
            </div>
        </header>

        <section class="page-section" id="noticias">
            <h2 class="section-heading text-uppercase text-center">edições recentes</h2>
            <div class="container px-lg-5 mb-2 mt-5">
                <div class="carousel-inner mb-2" role="listbox">
                    <a href="/revista" style="text-decoration: none; color: inherit;">
                        <div class="card-hover col-md-4 px-3" style="float:left" href="/revista">
                            <div class="card" style="width: 280px; height: 420px; margin:auto;">
                                <img class="card-img-top d-block w-100" src="storage/app/public/imagens/capas/21.png"
                                    alt="REVICO #21" height="290" width="610">
                                <div class="card-body">
                                    <p class="datanoticia">REVICO #21</p>
                                    <p class="card-text altura-linha">
                                        <b>Covid sob controle: Descobrindo quem resiste</b>
                                    </p>
                                    <p class="card-text altura-linha text-muted"
                                        style="font-size: 11px; margin-top: -15px;">04-10-2025
                                    </p>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="/revista" style="text-decoration: none; color: inherit;">
                        <div class="card-hover col-md-4 px-3" style="float:left" href="/revista">
                            <div class="card" style="width: 280px; height: 420px; margin:auto;">
                                <img class="card-img-top d-block w-100" src="storage/app/public/imagens/capas/20.png"
                                    alt="REVICO #21" height="290" width="610">
                                <div class="card-body">
                                    <p class="datanoticia">REVICO #20</p>
                                    <p class="card-text altura-linha">
                                        <b>Protestos pelo Brasil: Vozes que transformam</b>
                                    </p>
                                    <p class="card-text altura-linha text-muted"
                                        style="font-size: 11px; margin-top: -15px;">27-09-2025
                                    </p>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <a href="/revista" style="text-decoration: none; color: inherit;">
                        <div class="card-hover col-md-4 px-3" style="float:left" href="/revista">
                            <div class="card" style="width: 280px; height: 420px; margin:auto;">
                                <img class="card-img-top d-block w-100" src="storage/app/public/imagens/capas/19.png"
                                    alt="REVICO #21" height="290" width="610">
                                <div class="card-body">
                                    <p class="datanoticia">REVICO #19</p>
                                    <p class="card-text altura-linha">
                                        <b>Sequelas da pandemia: O que ficou no corpo e na mente</b>
                                    </p>
                                    <p class="card-text altura-linha text-muted"
                                        style="font-size: 11px; margin-top: -15px;">20-09-2025
                                    </p>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Livewire Component wire-end:eA6BAo4ZwyP8F7BTErlo -->
            </div>
        </section>

        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2>Por que assinar a</h2>
                    <img src="storage/app/public/imagens/revico_texto.png" alt="Logo REVICO"
                        style="height: 40px; margin-bottom: 20px;">
                    <p class="lead">Descubra os benefícios exclusivos que você terá como assinante da nossa revista
                        digital</p>
                </div>

                <div class="row g-4">
                    <!-- Vantagem 1 -->
                    <div class="col-md-4">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-book-half fs-1 mb-3"></i>
                                <h5 class="card-title text-primary">Conteúdo Exclusivo</h5>
                                <p class="card-text">Acesso a artigos inéditos, histórias inspiradoras e informações que
                                    você não encontra em nenhum outro lugar.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Vantagem 2 -->
                    <div class="col-md-4">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-clock-history fs-1 mb-3 text-primary"></i>
                                <h5 class="card-title text-primary">Atualizações Constantes</h5>
                                <p class="card-text">Receba novas edições e conteúdos toda semana, mantendo você
                                    informado sobre saúde, política e ciência.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Vantagem 3 -->
                    <div class="col-md-4">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-star fs-1 mb-3 text-primary"></i>
                                <h5 class="card-title text-primary">Experiência Premium</h5>
                                <p class="card-text">Sem anúncios, leitura fluida e interface amigável, proporcionando
                                    uma experiência agradável em qualquer dispositivo.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Vantagem 4 -->
                    <div class="col-md-4">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-people fs-1 mb-3 text-primary"></i>
                                <h5 class="card-title text-primary">Comunidade Revico</h5>
                                <p class="card-text">Interaja com outros assinantes, compartilhando experiências e
                                    ideias.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Vantagem 5 -->
                    <div class="col-md-4">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-gift fs-1 mb-3 text-primary"></i>
                                <h5 class="card-title text-primary">Apoio Emocional e Inspiração</h5>
                                <p class="card-text">Conteúdos que acolhem e inspiram, ajudando você a cuidar
                                    da mente e do coração no dia a dia.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Vantagem 6 -->
                    <div class="col-md-4">
                        <div class="card h-100 text-center shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-wallet2 fs-1 mb-3 text-primary"></i>
                                <h5 class="card-title text-primary">Preço Acessível</h5>
                                <p class="card-text">Planos flexíveis para todos os bolsos, garantindo acesso a conteúdo
                                    premium sem pesar no orçamento.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('layouts.patrocinadores')
    </main>

    @include('layouts/footer')
</body>

</html>