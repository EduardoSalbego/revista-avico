<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<style>
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

    .artigo-item {
        transition: background-color .2s;
    }

    .artigo-item:hover {
        background-color: #f8f9fa;
    }

    /* ── Comentários ── */
    .comentario-card {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 16px 20px;
        background: #fff;
        transition: box-shadow .2s;
    }

    .comentario-card:hover {
        box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
    }

    .comentario-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #0d6efd;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 15px;
        flex-shrink: 0;
    }

    /* Expandir/recolher área de comentários */
    #secao-comentarios {
        overflow: hidden;
        transition: max-height .35s ease;
    }

    /* Textarea auto-resize */
    #textarea-comentario {
        resize: none;
        min-height: 80px;
        transition: min-height .2s;
    }

    #textarea-comentario:focus {
        min-height: 120px;
    }
</style>

<body id="page-top" class="bg-light">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">

        {{-- Breadcrumbs --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none">Início</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('edicoes.index') }}" class="text-decoration-none">Todas as Edições</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $edicao->titulo ?? 'Edição Atual' }}
                </li>
            </ol>
        </nav>

        {{-- ════════════════════════════════════════
             CABEÇALHO DA EDIÇÃO
        ════════════════════════════════════════ --}}
        <div class="card border-0 shadow-sm mb-5 overflow-hidden">
            <header class="edicao-header">
                <span class="data">
                    {{ $edicao->data_publicacao
                        ? \Carbon\Carbon::parse($edicao->data_publicacao)->format('d/m/Y')
                        : 'Data não disponível' }}
                </span>
                <span class="site">Edição #{{ $edicao->id }}</span>
                <span class="edicao">Por {{ $edicao->organizador }}</span>
            </header>

            <div class="card-body p-4 p-md-5">
                <h1 class="edicao-title mb-3 border-bottom">{{ $edicao->titulo }}</h1>
                <div class="texto-corrido">
                    {!! nl2br(e($edicao->resumo)) !!}
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════
             LISTA DE ARTIGOS
        ════════════════════════════════════════ --}}
        @if ($artigos->isEmpty())
            <div class="alert alert-info shadow-sm text-center py-4">
                <i class="fas fa-info-circle fs-4 mb-2 d-block text-info"></i>
                Nenhum artigo publicado nesta edição até o momento.
            </div>
        @else
            <div class="row mb-5">
                <div class="col-12">
                    @foreach ($artigos as $artigo)
                        <div class="list-group-item artigo-item p-4 border-bottom">
                            <div class="row align-items-center">
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

        {{-- ════════════════════════════════════════
             SEÇÃO DE COMENTÁRIOS
        ════════════════════════════════════════ --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">

                {{-- Cabeçalho da seção — sempre visível --}}
                <div class="d-flex align-items-center justify-content-between mb-0">
                    <div class="d-flex align-items-center gap-3">
                        @if ($edicao->permitir_comentarios)
                            <h4 class="mb-0 fw-bold" style="color:#1a1a2e;">
                                <i class="fas fa-comments text-primary me-2"></i>
                                Comentários
                            </h4>
                            <span class="badge bg-primary rounded-pill">
                                {{ $comentarios->count() }}
                            </span>
                        @endif
                    </div>

                    {{-- Botão expandir (só se comentários habilitados) --}}
                    @if ($edicao->permitir_comentarios)
                        <button type="button" id="btn-toggle-comentarios" class="btn btn-outline-primary btn-sm"
                            onclick="toggleComentarios()" aria-expanded="false" aria-controls="secao-comentarios">
                            <i class="fas fa-chevron-down me-1" id="icon-toggle"></i>
                            <span id="label-toggle">Ver comentários</span>
                        </button>
                    @endif
                </div>

                {{-- Comentários desabilitados --}}
                @if (!$edicao->permitir_comentarios)
                    <div class="alert alert-light border mt-4 mb-0 d-flex align-items-center gap-3">
                        <i class="fas fa-comment-slash text-muted fs-5 flex-shrink-0"></i>
                        <span class="text-muted">
                            Os comentários estão desabilitados para esta edição.
                        </span>
                    </div>

                    {{-- Comentários habilitados --}}
                @else
                    <div id="secao-comentarios" style="max-height:0; overflow:hidden;">
                        <div class="pt-4">

                            {{-- Flash de sucesso --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            {{-- ── FORMULÁRIO DE NOVO COMENTÁRIO ── --}}
                            @auth
                                <div class="mb-4">
                                    <form action="{{ route('comentarios.store') }}" method="POST" id="form-comentario">
                                        @csrf
                                        <input type="hidden" name="edicao_id" value="{{ $edicao->id }}">

                                        <div class="d-flex gap-3 align-items-start">
                                            {{-- Avatar inicial do usuário --}}
                                            <div class="comentario-avatar flex-shrink-0">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </div>

                                            <div class="flex-grow-1">
                                                <textarea class="form-control @error('comentario') is-invalid @enderror" id="textarea-comentario" name="comentario"
                                                    placeholder="Escreva seu comentário..." required>{{ old('comentario') }}</textarea>
                                                @error('comentario')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                                <div class="d-flex justify-content-between align-items-center mt-2">
                                                    <small class="text-muted">
                                                        Comentando como <strong>{{ auth()->user()->name }}</strong>
                                                    </small>
                                                    <button type="submit" class="btn btn-primary btn-sm px-4">
                                                        <i class="fas fa-paper-plane me-1"></i> Publicar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <hr class="mb-4">
                            @else
                                <div class="alert alert-light border text-center py-3 mb-4">
                                    <i class="fas fa-lock text-muted me-2"></i>
                                    <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">
                                        Faça login
                                    </a>
                                    para deixar um comentário.
                                </div>
                            @endauth

                            {{-- ── LISTA DE COMENTÁRIOS ── --}}
                            @forelse($comentarios as $comentario)
                                <div class="comentario-card mb-3">
                                    <div class="d-flex gap-3 align-items-start">

                                        <div class="comentario-avatar"
                                            style="background:{{ '#' . substr(md5($comentario->user->name), 0, 6) }};">
                                            {{ strtoupper(substr($comentario->user->name, 0, 1)) }}
                                        </div>

                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <span class="fw-semibold text-dark">
                                                        {{ $comentario->user->name }}
                                                    </span>
                                                    <span class="text-muted small ms-2">
                                                        {{ $comentario->created_at->diffForHumans() }}
                                                    </span>
                                                </div>

                                                {{-- Excluir: dono ou admin --}}
                                                @auth
                                                    @if (auth()->id() === $comentario->user_id || auth()->user()->hasRole('admin'))
                                                        <form action="{{ route('comentarios.destroy', $comentario->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apagar este comentário?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-link btn-sm text-danger p-0 ms-2"
                                                                title="Apagar">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                @endauth
                                            </div>

                                            <p class="mb-0 mt-2 text-muted"
                                                style="font-size:.95rem; white-space:pre-line; line-height:1.6;">
                                                {{ $comentario->conteudo }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    <i class="fas fa-comment-dots fs-3 mb-2 d-block opacity-25"></i>
                                    Nenhum comentário ainda. Seja o primeiro a comentar!
                                </div>
                            @endforelse

                        </div>
                    </div>
                @endif

            </div>
        </div>

    </main>

    @include('layouts.footer')

    <script>
        let comentariosAbertos = false;

        // Abre automaticamente se houver erro de validação ou sucesso no comentário
        @if ($errors->has('comentario') || session('success'))
            document.addEventListener('DOMContentLoaded', () => abrirComentarios());
        @endif

        function toggleComentarios() {
            comentariosAbertos ? fecharComentarios() : abrirComentarios();
        }

        function abrirComentarios() {
            const secao = document.getElementById('secao-comentarios');
            const icon = document.getElementById('icon-toggle');
            const label = document.getElementById('label-toggle');
            const btn = document.getElementById('btn-toggle-comentarios');

            secao.style.maxHeight = secao.scrollHeight + 'px';
            icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
            label.textContent = 'Ocultar comentários';
            btn.setAttribute('aria-expanded', 'true');
            comentariosAbertos = true;
        }

        function fecharComentarios() {
            const secao = document.getElementById('secao-comentarios');
            const icon = document.getElementById('icon-toggle');
            const label = document.getElementById('label-toggle');
            const btn = document.getElementById('btn-toggle-comentarios');

            secao.style.maxHeight = '0';
            icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
            label.textContent = 'Ver comentários';
            btn.setAttribute('aria-expanded', 'false');
            comentariosAbertos = false;
        }

        // Recalcula max-height ao redimensionar (caso conteúdo mude)
        window.addEventListener('resize', () => {
            if (comentariosAbertos) {
                const secao = document.getElementById('secao-comentarios');
                if (secao) secao.style.maxHeight = secao.scrollHeight + 'px';
            }
        });
    </script>

</body>

</html>
