<!DOCTYPE html>
<html lang="pt-br" class="fontawesome-i2svg-active fontawesome-i2svg-complete">

@include('layouts/head')

<body id="page-top">
    @include('layouts/topbar')

    <main id="content">
        <header class="masthead" style="background-image: url('images/assets/img/home-bg.jpg'); padding-top: 50px;">
            <div class="container my-5">
                <img src="storage/app/public/imagens/logo_revista.png" alt="Logo Revico" style="width: 400px;">
            </div>
        </header>
        <div class="container" style="margin-top: -110px;">
            <header class="edicao-header">
                <span class="data">Seg, 23 mar 2024</span>
                <span class="site">Edição #01</span>
                <span class="edicao">Por Eduardo Salbego</span>
            </header>
            <div class="artigo-duas-colunas">

                <img src="storage/app/public/imagens/teste_covid.png" alt="Pessoa realizando teste de covid"
                    class="img-coluna">

                <h3>Segredo dos 'imunes': por que alguns não têm covid mesmo expostos ao vírus?</h2>

                    <p>Durante a pandemia, uma das principais questões era por que algumas pessoas escapavam da
                        covid-19, enquanto outras contraíam o vírus várias vezes.</p>

                    <p>Por meio de uma colaboração entre o University College London, o Wellcome Sanger Institute e o
                        Imperial College London, no Reino Unido, nos propusemos a responder a essa pergunta usando o
                        primeiro "ensaio de desafio" controlado para covid-19 no mundo, no qual os voluntários foram
                        deliberadamente expostos ao SARS-CoV-2, o vírus que causa a covid-19, para que este processo
                        pudesse ser estudado em detalhes.</p>

                    <div class="citacao">
                        “O novo coronavírus joga luz no que você tem de melhor e de pior”, diz Maria Luiza, sobrevivente
                        da COVID-19. “É uma experiência que você tem que escolher quem você é”.
                    </div>

                    <p>Voluntários saudáveis não vacinados, sem histórico prévio de covid-19, foram expostos —por meio
                        de um spray nasal— a uma dose extremamente baixa da cepa original do SARS-CoV-2. Os voluntários
                        foram então monitorados de perto em uma unidade de quarentena, com testes regulares e amostras
                        coletadas para estudar sua resposta ao vírus em um ambiente altamente controlado e seguro.</p>

                    <p>Para nosso estudo mais recente, publicado na revista Nature, coletamos amostras de tecido
                        localizado no meio do caminho entre o nariz e a garganta, bem como amostras de sangue de 16
                        voluntários. Essas amostras foram coletadas antes de os participantes serem expostos ao vírus,
                        para nos fornecer uma medição de linha de base, e depois em intervalos regulares.</p>

                    <p>Em seguida, as amostras foram processadas e analisadas com a tecnologia de sequenciamento de
                        célula única (single-cell sequencing), que nos permitiu extrair e sequenciar o material genético
                        de células individuais. Com essa tecnologia de ponta, pudemos acompanhar a evolução da doença em
                        detalhes sem precedentes, desde antes da infecção até a recuperação.</p>

                    <p>Para nossa surpresa, descobrimos que, apesar de todos os voluntários terem sido cuidadosamente
                        expostos à mesma dose exata do vírus da mesma maneira, nem todos acabaram testando positivo para
                        a covid-19.</p>

                    <p>De fato, conseguimos dividir os voluntários em três grupos distintos de infecção. Seis dos 16
                        voluntários desenvolveram covid-19 leve típica, testando positivo por vários dias com sintomas
                        semelhantes aos de um resfriado. Nós nos referimos a esse grupo como o "grupo de infecção
                        sustentada".</p>

                    <img src="storage/app/public/imagens/equipe_aplaudindo.png" alt="Equipe médica aplaudindo paciente"
                        class="img-coluna">
            </div>
        </div>

        <!-- Seção de Comentários -->
        <section class="py-5 bg-light">
            <div class="container">
                <h4 class="text-center mb-4">Comentários</h4>

                <!-- Lista de comentários existentes -->
                <div class="mb-5">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-1">Maria Luiza</h6>
                            <small class="text-muted">Postado em 05/10/2025</small>
                            <p class="card-text mt-2">Texto incrível! É fascinante como a ciência ainda está descobrindo
                                novas respostas sobre a covid.</p>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-body">
                            <h6 class="card-title mb-1">João Pereira</h6>
                            <small class="text-muted">Postado em 04/10/2025</small>
                            <p class="card-text mt-2">Li a edição completa e fiquei impressionado com a pesquisa.
                                Parabéns à equipe da Revico!</p>
                        </div>
                    </div>
                </div>

                <!-- Botão para mostrar o formulário -->
                <div class="text-center mb-4">
                    <button id="toggleFormBtn" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">
                        💬 Deixe seu comentário
                    </button>
                </div>

                <!-- Formulário (inicialmente escondido) -->
                <div id="commentForm" class="card" style="display: none; max-width: 600px; margin: auto;">
                    <div class="card-body">
                        <h5 class="card-title">Novo Comentário</h5>
                        <form>
                            <div class="mb-3">
                                <textarea class="form-control" id="comentario" rows="3"
                                    placeholder="Escreva aqui..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        @include('layouts.patrocinadores')

    </main>
    @include('layouts/footer')
    <!-- Script para alternar a exibição -->
    <script>
        document.getElementById("toggleFormBtn").addEventListener("click", function () {
            const form = document.getElementById("commentForm");
            if (form.style.display === "none") {
                form.style.display = "block";
                this.textContent = "✖ Fechar formulário";
                this.classList.remove("btn-primary");
                this.classList.add("btn-primary");
            } else {
                form.style.display = "none";
                this.textContent = "💬 Deixe seu comentário";
                this.classList.remove("btn-danger");
                this.classList.add("btn-primary");
            }
        });
    </script>
</body>

</html>