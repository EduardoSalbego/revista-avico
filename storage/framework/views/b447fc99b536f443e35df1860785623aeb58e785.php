<!DOCTYPE html>
<html lang="pt-br" class="fontawesome-i2svg-active fontawesome-i2svg-complete">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="icon" type="image/x-icon" href="https://avicobrasil.com.br/images/assets/img/faviconV2.png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&amp;display=swap" rel="stylesheet">
    <link href="https://avicobrasil.com.br/css/style.css" rel="stylesheet">
    <link href="https://avicobrasil.com.br/css/estilos-adicionais.css" rel="stylesheet">
    <link href="https://avicobrasil.com.br/css/form_cadastro.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/revico.css')); ?>">
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <style type="text/css" id="operaUserStyle"></style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
        </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"
        integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    <title>Avico Brasil - Associação de Vítimas e Familiares de Vítimas da Covid-19</title>
    <style>
        [wire\:loading],
        [wire\:loading\.delay],
        [wire\:loading\.inline-block],
        [wire\:loading\.inline],
        [wire\:loading\.block],
        [wire\:loading\.flex],
        [wire\:loading\.table],
        [wire\:loading\.grid],
        [wire\:loading\.inline-flex] {
            display: none;
        }

        [wire\:loading\.delay\.shortest],
        [wire\:loading\.delay\.shorter],
        [wire\:loading\.delay\.short],
        [wire\:loading\.delay\.long],
        [wire\:loading\.delay\.longer],
        [wire\:loading\.delay\.longest] {
            display: none;
        }

        [wire\:offline] {
            display: none;
        }

        [wire\:dirty]:not(textarea):not(input):not(select) {
            display: none;
        }

        input:-webkit-autofill,
        select:-webkit-autofill,
        textarea:-webkit-autofill {
            animation-duration: 50000s;
            animation-name: livewireautofill;
        }

        @keyframes  livewireautofill {
            from {}
        }
    </style>
    <noscript>Seu navegador não possui suporte ou o Javascript foi desabilitado</noscript>
    <style type="text/css">
        :root {
            --df-messenger-bot-message: #ecf3fe;
            --df-messenger-button-titlebar-color: #0b57d0;
            --df-messenger-button-titlebar-font-color: white;
            --df-messenger-chat-background-color: #fafafa;
            --df-messenger-font-color: #001d35;
            --df-messenger-input-box-color: white;
            --df-messenger-input-font-color: rgba(0, 0, 0, 0.87);
            --df-messenger-input-placeholder-font-color: #757575;
            --df-messenger-minimized-chat-close-icon-color: rgba(0, 0, 0, 0.87);
            --df-messenger-send-icon: #1e88e5;
            --df-messenger-user-message: #e1e3e1;
            --df-messenger-chip-color: white;
            --df-messenger-chip-border-color: #e0e0e0;
            --df-messenger-focus-color: #1e88e5;
            --df-messenger-focus-color-contrast: white;
        }
    </style>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto_old" rel="stylesheet" type="text/css">
</head>

<body id="page-top">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="/"><img
                    src="https://avicobrasil.com.br/images/assets/img/cropped-LOGO-AVICO-2021-OK-PNG-1536x402.png"
                    alt="Logo AVICO"></a>
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
    <main id="content">
        <header class="masthead" style="background-image: url('images/assets/img/home-bg.jpg')">
            <div class="container">
                <div class="masthead-heading text-uppercase text-primary">REVICO</div>
                <div class="masthead-subheading text-primary">Apoie nosso trabalho e ajude a manter a REVICO e a AVICO
                    ativas!</div>
                <a class="btn btn-primary btn-xl text-uppercase mb-3" href="/">Assine a REVICO</a>
            </div>
        </header>

        <section class="page-section" id="noticias">
            <h2 class="section-heading text-uppercase text-center">edições recentes</h2>
            <div class="container px-lg-5">
                <div wire:id="eA6BAo4ZwyP8F7BTErlo">
                    <div id="multi-item-example" class="carousel slide carousel-multi-item" data-ride="carousel">
                        <div class="carousel-inner mb-2" role="listbox">
                            <div class="carousel-item active">
                                <div class="col-md-4 px-3 " style="float:left">
                                    <div>
                                        <div class="card">
                                            <img class="card-img-top d-block w-100"
                                                src="https://avicobrasil.com.br/images/assets/img/cropped-LOGO-AVICO-2021-OK-PNG-1536x402.png"
                                                alt="REVICO #21" height="290" width="610">
                                            <div class="card-body">
                                                <p class="datanoticia">04-10-2025</p>
                                                <p class="card-text altura-linha"><b>REVICO #21</b>
                                                </p>
                                                <p></p>
                                                <a class="btn btn-primary btn-sm" href="/">Leia Mais</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 px-3 lgcards " style="float:left">
                                    <div>
                                        <div class="card">
                                            <img class="card-img-top d-block w-100"
                                                src="https://avicobrasil.com.br/images/assets/img/cropped-LOGO-AVICO-2021-OK-PNG-1536x402.png"
                                                alt="REVICO #20" height="290" width="610">
                                            <div class="card-body">
                                                <p class="datanoticia">04-04-25</p>
                                                <p class="card-text altura-linha"><b>REVICO #20</b>
                                                </p>
                                                <p></p>
                                                <a class="btn btn-primary btn-sm"
                                                    href="https://avicobrasil.com.br/noticias/noticia/26">Leia
                                                    Mais</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 px-3 lgcards " style="float:left">
                                    <div>
                                        <div class="card">
                                            <img class="card-img-top d-block w-100"
                                                src="https://avicobrasil.com.br/images/assets/img/cropped-LOGO-AVICO-2021-OK-PNG-1536x402.png"
                                                alt="REVICO #19" height="290" width="610">
                                            <div class="card-body">
                                                <p class="datanoticia">04-04-23</p>
                                                <p class="card-text altura-linha"><b>REVICO #19</b>
                                                </p>
                                                <p></p>
                                                <a class="btn btn-primary btn-sm"
                                                    href="https://avicobrasil.com.br/noticias/noticia/25">Leia
                                                    Mais</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-md-4 px-3 " style="float:left">
                                    <div>
                                        <div class="card">
                                            <img class="card-img-top d-block w-100"
                                                src="https://avicobrasil.com.br/images/assets/img/cropped-LOGO-AVICO-2021-OK-PNG-1536x402.png"
                                                alt="REVICO #18" ,="" diz="" silvio="" almeida="" durante=""
                                                homenagem="" às="" vítimas="" da="" pandemia="" e="" negligência=""
                                                política"="" height="290" width="610">
                                            <div class="card-body">
                                                <p class="datanoticia">04-04-23</p>
                                                <p class="card-text altura-linha"><b>REVICO #18</b>
                                                </p>
                                                <p></p>
                                                <a class="btn btn-primary btn-sm"
                                                    href="https://avicobrasil.com.br/noticias/noticia/24">Leia
                                                    Mais</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 px-3 lgcards " style="float:left">
                                    <div>
                                        <div class="card">
                                            <img class="card-img-top d-block w-100"
                                                src="https://avicobrasil.com.br/images/assets/img/cropped-LOGO-AVICO-2021-OK-PNG-1536x402.png"
                                                alt="REVICO #17" height="290" width="610">
                                            <div class="card-body">
                                                <p class="datanoticia">04-04-23</p>
                                                <p class="card-text altura-linha"><b>REVICO #17</b>
                                                </p>
                                                <p></p>
                                                <a class="btn btn-primary btn-sm"
                                                    href="https://avicobrasil.com.br/noticias/noticia/23">Leia
                                                    Mais</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 px-3 lgcards " style="float:left">
                                    <div>
                                        <div class="card">
                                            <img class="card-img-top d-block w-100"
                                                src="https://avicobrasil.com.br/images/assets/img/cropped-LOGO-AVICO-2021-OK-PNG-1536x402.png"
                                                alt="REVICO #16" height="290" width="610">
                                            <div class="card-body">
                                                <p class="datanoticia">04-04-23</p>
                                                <p class="card-text altura-linha"><b>REVICO #16</b>
                                                </p>
                                                <p></p>
                                                <a class="btn btn-primary btn-sm"
                                                    href="https://avicobrasil.com.br/noticias/noticia/22">Leia
                                                    Mais</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ol class="carousel-indicators">
                            <li data-target="#multi-item-example" data-slide-to="0" class="active"></li>
                            <li data-target="#multi-item-example" data-slide-to="1" class=""></li>
                        </ol>
                    </div>
                </div>

                <!-- Livewire Component wire-end:eA6BAo4ZwyP8F7BTErlo -->
            </div>
        </section>

        <section class="page-section bg-light" id="portfolio">
            <div class="container px-5">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase">Para conhecer melhor a nossa história</h2>
                    <iframe width="100%" height="700rem" src="https://www.youtube.com/embed/iphbaAw50b8"
                        title="FAÇA DIFERENÇA - AJUDA VíTIMAS DA COVID"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen=""></iframe>
                </div>
            </div>
        </section>

    </main>
    <style>
        .content {
            flex: 1 0 auto;
        }
    </style>
    <footer class="footer py-lg-4 fixed-bottom">
        <div class="container">
            <div>
                <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
                <df-messenger intent="WELCOME" chat-title="AVICOBOT" agent-id="6fe77d24-4ddc-4dae-9326-9e4251616b8e"
                    language-code="pt-br" session-id="dfMessenger-32799432"
                    api-uri="https://dialogflow.cloud.google.com/v1/integrations/messenger/webhook"></df-messenger>
            </div>
            <div class="row align-items-center">
                <div class="d-none d-lg-block col-lg-4 text-lg-start police">Copyright © AVICO BRASIL 2022
                </div>
                <div class="col-lg-4 my-3 my-lg-0">
                    <a class="btn btn-dark btn-social mx-lg-2" href="https://twitter.com/AvicoBrasil"
                        aria-label="Twitter"><svg class="svg-inline--fa fa-twitter" aria-hidden="true" focusable="false"
                            data-prefix="fab" data-icon="twitter" role="img" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M459.4 151.7c.325 4.548 .325 9.097 .325 13.65 0 138.7-105.6 298.6-298.6 298.6-59.45 0-114.7-17.22-161.1-47.11 8.447 .974 16.57 1.299 25.34 1.299 49.06 0 94.21-16.57 130.3-44.83-46.13-.975-84.79-31.19-98.11-72.77 6.498 .974 12.99 1.624 19.82 1.624 9.421 0 18.84-1.3 27.61-3.573-48.08-9.747-84.14-51.98-84.14-102.1v-1.299c13.97 7.797 30.21 12.67 47.43 13.32-28.26-18.84-46.78-51.01-46.78-87.39 0-19.49 5.197-37.36 14.29-52.95 51.65 63.67 129.3 105.3 216.4 109.8-1.624-7.797-2.599-15.92-2.599-24.04 0-57.83 46.78-104.9 104.9-104.9 30.21 0 57.5 12.67 76.67 33.14 23.72-4.548 46.46-13.32 66.6-25.34-7.798 24.37-24.37 44.83-46.13 57.83 21.12-2.273 41.58-8.122 60.43-16.24-14.29 20.79-32.16 39.31-52.63 54.25z">
                            </path>
                        </svg><!-- <i class="fab fa-twitter"></i> Font Awesome fontawesome.com --></a>
                    <a class="btn btn-dark btn-social mx-lg-2" href="https://www.facebook.com/AVICOBRASIL"
                        aria-label="Facebook"><svg class="svg-inline--fa fa-facebook-f" aria-hidden="true"
                            focusable="false" data-prefix="fab" data-icon="facebook-f" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M279.1 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.4 0 225.4 0c-73.22 0-121.1 44.38-121.1 124.7v70.62H22.89V288h81.39v224h100.2V288z">
                            </path>
                        </svg><!-- <i class="fab fa-facebook-f"></i> Font Awesome fontawesome.com --></a>
                    <a class="btn btn-dark btn-social mx--lg-2" href="https://api.whatsapp.com/message/ADJGY4UDTDAZJ1"
                        aria-label="WhatsApp"><svg class="svg-inline--fa fa-whatsapp" aria-hidden="true"
                            focusable="false" data-prefix="fab" data-icon="whatsapp" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z">
                            </path>
                        </svg><!-- <i class="fa-brands fa-whatsapp"></i> Font Awesome fontawesome.com --></a>
                    <a class="btn btn-dark btn-social mx-lg-2" href="https://www.instagram.com/avicobrasil/"
                        aria-label="Instagram"><svg class="svg-inline--fa fa-instagram" aria-hidden="true"
                            focusable="false" data-prefix="fab" data-icon="instagram" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                            </path>
                        </svg><!-- <i class="fa-brands fa-instagram"></i> Font Awesome fontawesome.com --></a>
                    <a class="btn btn-dark btn-social mx-lg-2"
                        href="https://www.youtube.com/channel/UCDqJYVJaFZ63BYjhXc35JXQ" aria-label="Youtube"><svg
                            class="svg-inline--fa fa-youtube" aria-hidden="true" focusable="false" data-prefix="fab"
                            data-icon="youtube" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                            data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M549.7 124.1c-6.281-23.65-24.79-42.28-48.28-48.6C458.8 64 288 64 288 64S117.2 64 74.63 75.49c-23.5 6.322-42 24.95-48.28 48.6-11.41 42.87-11.41 132.3-11.41 132.3s0 89.44 11.41 132.3c6.281 23.65 24.79 41.5 48.28 47.82C117.2 448 288 448 288 448s170.8 0 213.4-11.49c23.5-6.321 42-24.17 48.28-47.82 11.41-42.87 11.41-132.3 11.41-132.3s0-89.44-11.41-132.3zm-317.5 213.5V175.2l142.7 81.21-142.7 81.2z">
                            </path>
                        </svg><!-- <i class="fa-brands fa-youtube"></i> Font Awesome fontawesome.com --></a>
                    <a class="btn btn-dark btn-social mx-lg-2" href="mailto:avicobrasil@gmail.com"
                        aria-label="Email"><svg class="svg-inline--fa fa-envelope" aria-hidden="true" focusable="false"
                            data-prefix="fas" data-icon="envelope" role="img" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M464 64C490.5 64 512 85.49 512 112C512 127.1 504.9 141.3 492.8 150.4L275.2 313.6C263.8 322.1 248.2 322.1 236.8 313.6L19.2 150.4C7.113 141.3 0 127.1 0 112C0 85.49 21.49 64 48 64H464zM217.6 339.2C240.4 356.3 271.6 356.3 294.4 339.2L512 176V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V176L217.6 339.2z">
                            </path>
                        </svg><!-- <i class="fa-solid fa-envelope"></i> Font Awesome fontawesome.com --></a>
                </div>
                <div class="d-none d-lg-block col-lg-4 text-lg-start">Versão Beta</div>
            </div>
        </div>
    </footer>
    <script src="/livewire/livewire.js?id=90730a3b0e7144480175" data-turbo-eval="false" data-turbolinks-eval="false">
    </script>
    <script data-turbo-eval="false" data-turbolinks-eval="false">
        window.livewire = new Livewire();
        window.Livewire = window.livewire;
        window.livewire_app_url = '';
        window.livewire_token = 'vIXpOkwg2SQ3OXAPTUWtvzg5PreBmfegb2N2rrvQ';
        window.deferLoadingAlpine = function (callback) {
            window.addEventListener('livewire:load', function () {
                callback();
            });
        };
        let started = false;
        window.addEventListener('alpine:initializing', function () {
            if (!started) {
                window.livewire.start();
                started = true;
            }
        });
        document.addEventListener("DOMContentLoaded", function () {
            if (!started) {
                window.livewire.start();
                started = true;
            }
        });
    </script>

    <script src="https://avicobrasil.com.br/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/messenger-internal.min.js?v=4"></script>
</body>

</html><?php /**PATH D:\revista-avico\resources\views/welcome.blade.php ENDPATH**/ ?>