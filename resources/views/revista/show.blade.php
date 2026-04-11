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

                    @php
                        $blocos = json_decode($edicao->conteudo_blocos, true) ?? [];
                    @endphp

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
                <h4 class="text-center mb-4">Comentários ({{ $comentarios->count() }})</h4>

                @if(session('success'))
                    <div class="alert alert-success text-center max-w-600 mx-auto" style="max-width: 600px;">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-5" style="max-width: 800px; margin: 0 auto;">
                    {{-- Loop para listar os comentários --}}
                    @forelse($comentarios as $comentario)
                        <div class="card mb-3 shadow-sm border-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title mb-1 text-primary">{{ $comentario->user->name }}</h6>
                                        <small class="text-muted">Postado em
                                            {{ \Carbon\Carbon::parse($comentario->created_at)->format('d/m/Y') }}</small>
                                    </div>
                                    @auth
                                        @if(Auth::id() === $comentario->user_id || Auth::user()->role === 'admin')
                                            <form action="{{ route('comentarios.destroy', $comentario->id) }}" method="POST"
                                                onsubmit="return confirm('Tem certeza que deseja apagar este comentário?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    title="Apagar comentário">
                                                    <i class="bi bi-trash-fill"></i> </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>

                                <p class="card-text mt-3" style="white-space: pre-line;">{{ $comentario->conteudo }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">Nenhum comentário ainda. Seja o primeiro a comentar!</p>
                    @endforelse
                </div>

                @auth
                    <div class="text-center mb-4">
                        <button id="toggleFormBtn" class="btn btn-primary px-4 py-2 shadow-sm" style="border-radius: 8px;">
                            Deixe um comentário
                        </button>
                    </div>

                    <div id="commentForm" class="card shadow"
                        style="display: none; max-width: 600px; margin: auto; border: 0;">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-3">Novo Comentário</h5>
                            <form action="{{ route('comentarios.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="edicao_id" value="{{ $edicao->id }}">

                                <div class="mb-3">
                                    <textarea class="form-control bg-light" name="comentario" id="comentario" rows="4"
                                        placeholder="Escreva sua opinião aqui..." required></textarea>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-success">Enviar Comentário</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="text-center mt-4">
                        <p class="text-muted">Você precisa estar logado para comentar.</p>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Fazer Login</a>
                    </div>
                @endauth
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
                this.textContent = "Cancelar";
                this.classList.remove("btn-primary");
                this.classList.add("btn-danger");
            } else {
                form.style.display = "none";
                this.textContent = "Deixe um comentário";
                this.classList.remove("btn-danger");
                this.classList.add("btn-primary");
            }
        });
    </script>
</body>

</html>