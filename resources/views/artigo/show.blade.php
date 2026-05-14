<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<style>
    /* Estilos específicos para a página do artigo para manter a leitura agradável */
    .artigo-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a2e;
        line-height: 1.3;
    }

    .autor-nome {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0d6efd;
    }

    .autor-filiacao {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .secao-titulo {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1a1a2e;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 8px;
        margin-bottom: 16px;
        margin-top: 32px;
    }

    .texto-corrido {
        font-size: 1rem;
        line-height: 1.8;
        color: #495057;
        text-align: justify;
    }

    .badge-keyword {
        background-color: #e8f0fe;
        color: #0d6efd;
        border: 1px solid #b6d4fe;
        font-weight: 500;
        font-size: 0.85rem;
        padding: 6px 12px;
    }

    .doi-link {
        color: #212529;
        text-decoration: none;
    }

    .doi-link:hover {
        color: #212529;
        text-decoration: underline;
    }
</style>

<body id="page-top" class="bg-light">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">

        {{-- ── BREADCRUMBS (Navegação) ── --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('edicoes.index') }}"
                        class="text-decoration-none">Edições</a></li>
                <li class="breadcrumb-item"><a href="{{ route('edicoes.show', $artigo->edicao_id) }}"
                        class="text-decoration-none">{{ $artigo->edicao->titulo ?? 'Edição Atual' }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $artigo->titulo }}</li>
            </ol>
        </nav>

        <div class="row g-5">

            {{-- ════════════════════════════════════════════
                 COLUNA PRINCIPAL (Esquerda)
            ════════════════════════════════════════════ --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">

                        {{-- Título --}}
                        <h1 class="artigo-title" style="margin-bottom: 3rem;">{{ $artigo->titulo }}</h1>

                        {{-- Autores --}}
                        <div class="mb-4">
                            {{-- Exemplo assumindo que você tem uma relação $artigo->autores --}}
                            @foreach ($artigo->submissao->autores as $autor)
                                <div class="mb-3">
                                    <div class="fw-bold">{{ trim($autor->nome) }}</div>
                                    @if ($autor->instituicao)
                                        <div class="autor-filiacao">{{ trim($autor->instituicao) }}</div>
                                    @endif
                                </div>

                                @if ($autor->orcid)
                                    <div class="autor-filiacao mt-1">
                                        <i class="fas fa-id-badge me-1"></i>
                                        <a href="https://orcid.org/{{ $autor->orcid }}" target="_blank"
                                            class="text-decoration-none text-muted">
                                            ORCID: {{ $autor->orcid }}
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        {{-- DOI (Se houver) --}}
                        @if ($artigo->doi)
                            <div class="align-items-center gap-2">
                                <span class="fw-bold text-secondary small">DOI:</span>

                                <a href="https://doi.org/{{ $artigo->doi }}" target="_blank" class="doi-link small">
                                    https://doi.org/{{ $artigo->doi }}
                                </a>
                            </div>
                        @endif

                        {{-- Resumo --}}
                        <h3 class="secao-titulo text-secondary">RESUMO</h3>
                        <p class="texto-corrido">
                            {{ $artigo->resumo }}
                        </p>

                        {{-- Palavras-chave --}}
                        @if (!empty($artigo->palavras_chave))
                            <div class="mt-3 mb-2">
                                <span class="fw-bold text-secondary small me-2">Palavras-chave:</span>
                                <div class="d-inline-flex flex-wrap gap-2 mt-1 small">
                                    @foreach ($artigo->palavras_chave as $pc)
                                        {{ trim($pc) }}@if (!$loop->last), @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif


                        {{-- Referências --}}
                        @if (!empty($artigo->referencias))
                            <h3 class="secao-titulo text-secondary">REFERÊNCIAS</h3>
                            <ol class="ref-lista">
                                @foreach ($artigo->referencias as $i => $ref)
                                    <li class="mb-3 small">
                                        <span class="ref-n">{{ $i + 1 }}.</span>
                                        <span>{{ trim($ref) }}</span>
                                    </li>
                                @endforeach
                            </ol>
                        @endif

                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════════════
                 COLUNA LATERAL (Direita)
            ════════════════════════════════════════════ --}}
            <div class="col-lg-4">

                {{-- Botão de PDF --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4 text-center">
                        <a href="{{ asset('storage/' . $artigo->arquivo_pdf) }}" target="_blank"
                            class="btn btn-danger w-100 shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-file-pdf"></i> Baixar PDF
                        </a>
                    </div>
                </div>

                {{-- Informações de Publicação --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-normal mb-3 border-bottom pb-2">PUBLICADO</h6>
                        <div class="mb-3">
                            <span class="text-dark">
                                {{ $artigo->updated_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Informações de Publicação --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-normal mb-3 border-bottom pb-2">EDIÇÃO</h6>
                        <div class="mb-3">
                            <a href="#" class="text-decoration-none fw-semibold">
                                {{ $artigo->edicao->titulo }}
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Como Citar (Geração Dinâmica Básica) --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-3 border-bottom pb-2">Como Citar (ABNT)</h6>

                        @php
                            // Lógica simples para montar a citação ABNT
                            $sobrenomes = [];
                            foreach ($artigo->submissao->autores as $autor) {
                                $autor = trim($autor->nome);
                                $partesNome = explode(' ', $autor);
                                $sobrenome = strtoupper(array_pop($partesNome));
                                $nomeRestante = implode(' ', $partesNome);
                                $sobrenomes[] = $sobrenome . ', ' . $nomeRestante;
                            }
                            $autoresFormatados = implode('; ', $sobrenomes);
                            $ano = $artigo->updated_at->format('Y');
                            $url = url()->current();
                        @endphp

                        <div class="bg-light p-3 rounded border small text-muted mb-3" id="texto-citacao"
                            style="text-align: justify;">
                            {{ $autoresFormatados }}. <strong>{{ $artigo->titulo }}</strong>. REVICO - Revista
                            Científica Online, v. 1, n. 1, p. 1-10, {{ $ano }}. Disponível em:
                            &lt;{{ $url }}&gt;. Acesso em: {{ date('d M. Y') }}.
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-primary w-100 shadow-sm"
                            onclick="copiarCitacao()">
                            <i class="fas fa-copy me-1"></i> Copiar Citação
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </main>

    @include('layouts.footer')

    {{-- Script para copiar a citação --}}
    <script>
        function copiarCitacao() {
            const texto = document.getElementById('texto-citacao').innerText;
            navigator.clipboard.writeText(texto).then(() => {}).catch(err => {
                console.error('Erro ao copiar: ', err);
            });
        }
    </script>
</body>

</html>
