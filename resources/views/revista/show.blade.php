<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<style>
    /* Estilos específicos para a página da Edição */
    .edicao-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #1a1a2e;
        line-height: 1.3;
    }

    .secao-titulo {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a2e;
        border-bottom: 3px solid #0d6efd;
        display: inline-block;
        padding-bottom: 5px;
        margin-bottom: 20px;
    }

    .texto-corrido {
        font-size: 1.05rem;
        line-height: 1.8;
        color: #495057;
    }

    .artigo-link {
        color: #0d6efd;
        transition: color 0.2s ease-in-out;
    }

    .artigo-link:hover {
        color: #0043a8;
        text-decoration: underline !important;
    }

    .artigo-autores {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }

    .artigo-item {
        transition: background-color 0.2s;
    }

    .artigo-item:hover {
        background-color: #f8f9fa;
    }
</style>

<body id="page-top" class="bg-light">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">

        {{-- ── BREADCRUMBS ── --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('edicoes.index') }}" class="text-decoration-none">Todas as
                        Edições</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $edicao->titulo ?? 'Edição Atual' }}</li>
            </ol>
        </nav>

        {{-- ════════════════════════════════════════════
             CABEÇALHO DA EDIÇÃO (Resumo e Infos)
        ════════════════════════════════════════════ --}}
        <div class="card border-0 shadow-sm mb-5 overflow-hidden">
            {{-- Faixa superior decorativa --}}

            <header class="edicao-header">
                <span
                    class="data">{{ $edicao->data_publicacao ? \Carbon\Carbon::parse($edicao->data_publicacao)->format('d/m/Y') : 'Data não disponível' }}</span>
                <span class="site">Edição #{{ $edicao->id }}</span>
                <span class="edicao">Por {{ $edicao->organizador }}</span>
            </header>

            <div class="card-body p-4 p-md-5">
                <h1 class="edicao-title mb-3 border-bottom">{{ $edicao->titulo }}</h1>

                {{-- Descrição / Resumo do Organizador --}}
                <div class="texto-corrido text-justify">
                    {!! nl2br(e($edicao->resumo)) !!}
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════
             LISTA DE ARTIGOS (Agrupados por Seção/Trilha)
        ════════════════════════════════════════════ --}}

        @if ($artigos->isEmpty())
            <div class="alert alert-info shadow-sm text-center py-4">
                <i class="fas fa-info-circle fs-4 mb-2 d-block text-info"></i>
                Nenhum artigo publicado nesta edição até o momento.
            </div>
        @else
            <div class="row">
                <div class="col-12">

                    @foreach ($artigos as $artigo)
                        <div class="list-group-item artigo-item p-4 border-bottom">
                            <div class="row align-items-center">

                                {{-- Dados do Artigo --}}
                                <div class="col-md-10 mb-3 mb-md-0">
                                    <a href="{{ route('artigos.show', $artigo->id) }}"
                                        class="text-decoration-none fw-bold fs-5 d-block mb-1"
                                        style="color: black; text-decoration: none;">
                                        {{ $artigo->titulo }}
                                    </a>

                                    <div class="artigo-autores mb-2">
                                        {{ $artigo->submissao?->autores->pluck('nome')->implode(', ') }}
                                    </div>
                                </div>

                                {{-- Botões de Ação (PDF) --}}
                                <div class="col-md-2 text-md-end">
                                    @if ($artigo->arquivo_pdf)
                                        <a href="{{ asset('storage/' . $artigo->arquivo_pdf) }}" target="_blank"
                                            class="btn btn-sm btn-outline-danger shadow-sm px-3 rounded-pill fw-semibold">
                                            <i class="fas fa-file-pdf me-1"></i> PDF
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        @endif

    </main>

    @include('layouts.footer')
</body>

</html>
