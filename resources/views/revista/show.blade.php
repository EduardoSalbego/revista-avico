<!DOCTYPE html>
<html lang="pt-br" class="fontawesome-i2svg-active fontawesome-i2svg-complete">

@include('layouts/head')

<body id="page-top">
    @include('layouts/topbar')

    <main id="content">
        <header class="masthead"
            style="background-image: url('{{ asset('images/assets/img/home-bg.jpg') }}'); padding-top: 50px;">
            <div class="container my-5 text-center">
                <img src="{{ asset('storage/imagens/logo_revista.png') }}" alt="Logo Revico"
                    style="max-width: 400px; width: 100%;">
            </div>
        </header>

        <div class="container"
            style="margin-top: -50px; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
            <header class="edicao-header mb-4 border-bottom pb-3">
                {{-- Formata a data para padrão BR --}}
                <span class="data me-3">
                    {{ \Carbon\Carbon::parse($edicao->created_at)->format('d/m/Y') }}</span>
                <span class="site me-3">Edição #{{ $edicao->id }}</span>
                <span class="edicao"> {{ $edicao->autor }}</span>
            </header>

            <div class="{{ $edicao->tipo_conteudo === 'pdf' ? '' : 'artigo-duas-colunas' }}">
                <h1 class="mb-4">{{ $edicao->titulo }}</h1>

                {{-- LÓGICA CONDICIONAL: PDF ou BLOCOS --}}
                @if($edicao->tipo_conteudo === 'pdf')

                    <div class="pdf-container my-5 text-center">
                        <iframe src="{{ asset($edicao->arquivo_pdf) }}" width="70%" height="1000px"
                            style="border: 1px solid #ccc; border-radius: 5px;">
                            Seu navegador não suporta a visualização de PDFs.
                        </iframe>
                        <div class="mt-3">
                            <a href="{{ asset($edicao->arquivo_pdf) }}" download class="btn btn-outline-primary">
                                Baixar PDF da Edição
                            </a>
                        </div>
                    </div>

                @elseif($edicao->tipo_conteudo === 'blocos')

                    {{-- Decodifica o JSON do banco para um array PHP --}}
                    @php
                        $blocos = json_decode($edicao->conteudo_blocos, true) ?? [];
                    @endphp

                    {{-- Faz um loop para renderizar cada bloco na ordem certa --}}
                    @foreach($blocos as $bloco)
                        @if($bloco['tipo'] === 'paragrafo')
                            <p class="mb-3" style="text-align: justify; line-height: 1.8;">
                                {{ $bloco['conteudo'] }}
                            </p>
                        @elseif($bloco['tipo'] === 'subtitulo')
                            <h3 class="mt-4 mb-3">{{ $bloco['conteudo'] }}</h3>
                        @elseif($bloco['tipo'] === 'imagem')
                            <div class="text-center my-4">
                                <img src="{{ asset($bloco['conteudo']) }}" alt="Imagem do artigo" class="img-fluid rounded"
                                    style="max-height: 500px; object-fit: cover;">
                            </div>
                        @endif
                    @endforeach

                @endif

            </div>
        </div>

        <section class="py-5 bg-light mt-5">
            <div class="container">
                <h4 class="text-center mb-4">Comentários</h4>

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

                <div class="text-center mb-4">
                    <button id="toggleFormBtn" class="btn btn-primary px-4 py-2" style="border-radius: 8px;">
                        💬 Deixe seu comentário
                    </button>
                </div>

                <div id="commentForm" class="card" style="display: none; max-width: 600px; margin: auto;">
                    <div class="card-body">
                        <h5 class="card-title">Novo Comentário</h5>
                        <form action="#" method="POST">
                            @csrf
                            {{-- Campo oculto para vincular o comentário à edição atual --}}
                            <input type="hidden" name="edicao_id" value="{{ $edicao->id }}">

                            <div class="mb-3">
                                <textarea class="form-control" name="comentario" id="comentario" rows="3"
                                    placeholder="Escreva aqui..." required></textarea>
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

    <script>
        document.getElementById("toggleFormBtn").addEventListener("click", function () {
            const form = document.getElementById("commentForm");
            if (form.style.display === "none") {
                form.style.display = "block";
                this.textContent = "Fechar formulário";
                this.classList.remove("btn-primary");
                this.classList.add("btn-danger"); // Alterei para btn-danger para fazer sentido com o "Fechar"
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