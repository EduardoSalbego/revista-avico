<!DOCTYPE html>
<html lang="pt-br" class="fontawesome-i2svg-active fontawesome-i2svg-complete">

@include('layouts/head')

<body id="page-top">

    @include('layouts/topbar')

    <main id="content">
        <header class="masthead"
            style="background-image: url('images/assets/img/home-bg.jpg'); padding-top: 100px; padding-bottom: 50px; min-height: 100vh;">
            <div class="container my-5">
                <h2 class="section-heading text-uppercase mb-4" style="color: black;">Edições da REVICO</h2>

                <form action="{{ route('edicoes') }}" method="GET" class="d-flex mb-5" role="search">
                    <input class="form-control me-2" type="search" name="busca" value="{{ request('busca') }}"
                        placeholder="Buscar edição pelo título..." aria-label="Buscar">
                    <button class="btn btn-primary" type="submit">Pesquisar</button>

                    {{-- Botão para limpar a busca, caso o usuário tenha pesquisado algo --}}
                    @if(request()->has('busca') && request('busca') != '')
                        <a href="{{ route('edicoes') }}" class="btn btn-outline-secondary ms-2">Limpar</a>
                    @endif
                </form>

                <div class="row">
                    {{-- Verifica se encontrou alguma edição --}}
                    @if($edicoes->isEmpty())
                        <div class="col-12 text-center">
                            <p style="color: black; font-size: 1.2rem;">Nenhuma edição encontrada com esse termo.</p>
                        </div>
                    @else
                        {{-- Loop para listar as revistas --}}
                        @foreach($edicoes as $edicao)
                            <div class="col-md-4 px-3 mb-4 mt-4">
                                <div class="card shadow-sm h-100" style="width: 280px; margin:auto;">

                                    {{-- Usa asset() para o caminho direto, como corrigimos antes --}}
                                    <img class="card-img-top d-block w-100" src="{{ asset($edicao->imagem_capa) }}"
                                        alt="REVICO #{{ $edicao->id }}" height="290" style="object-fit: cover;">

                                    <div class="card-body d-flex flex-column">
                                        <p class="datanoticia mb-1 text-muted" style="font-size: 0.9rem;">
                                            {{ \Carbon\Carbon::parse($edicao->created_at)->format('d/m/Y') }}
                                        </p>
                                        <p class="card-text altura-linha mb-3" style="color: black;">
                                            <b>REVICO #{{ $edicao->id }} - {{ Str::limit($edicao->titulo, 40) }}</b>
                                        </p>

                                        {{-- Botão "Leia Mais" empurrado para a base do card --}}
                                        <div class="mt-auto">
                                            <a class="btn btn-primary btn-sm w-100" href="/revista/{{ $edicao->id }}">Leia
                                                Mais</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $edicoes->appends(request()->query())->links() }}
                </div>

            </div>
        </header>
    </main>

    @include('layouts/footer')
</body>

</html>