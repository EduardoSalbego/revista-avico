<!DOCTYPE html>
<html lang="pt-br">
@include('layouts/head')

<style>
    /* ── Card exclusivo bloqueado ── */
    .card-exclusiva-bloqueada {
        position: relative;
        filter: grayscale(80%) opacity(.7);
        pointer-events: none;
        user-select: none;
    }

    .card-exclusiva-bloqueada .btn {
        pointer-events: none;
    }

    /* Overlay com cadeado sobre o card bloqueado */
    .card-lock-overlay {
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, .18);
        border-radius: inherit;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        pointer-events: none;
    }

    /* Wrapper com tooltip clicável (pointer-events: auto no wrapper) */
    .card-exclusiva-wrapper {
        position: relative;
        display: block;
        width: 280px;
        margin: auto;
        cursor: not-allowed;
    }

    /* Badge tipo_acesso */
    .badge-publica {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #6ee7b7;
    }

    .badge-exclusiva {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fcd34d;
    }
</style>

<body id="page-top">
    @include('layouts/topbar')

    @php
        $ehAssinante = auth()->user()->isAssinante();
    @endphp

    <main id="content">
        <header class="masthead"
            style="background-image: url('{{ asset('images/assets/img/home-bg.jpg') }}');
                   padding-top: 100px; padding-bottom: 50px; min-height: 100vh;">
            <div class="container my-5">

                <h2 class="section-heading text-uppercase mb-4" style="color: black;">
                    Edições da REVICO
                </h2>

                {{-- Busca --}}
                <form action="{{ route('edicoes.index') }}" method="GET" class="d-flex mb-5" role="search">
                    <input class="form-control me-2" type="search" name="busca" value="{{ request('busca') }}"
                        placeholder="Buscar edição pelo título..." aria-label="Buscar">
                    <button class="btn btn-primary" type="submit">Pesquisar</button>
                    @if (request('busca'))
                        <a href="{{ route('edicoes.index') }}" class="btn btn-outline-secondary ms-2">Limpar</a>
                    @endif
                </form>

                {{-- Grid de edições --}}
                <div class="row">
                    @if ($edicoes->isEmpty())
                        <div class="col-12 text-center">
                            <p style="color:black; font-size:1.2rem;">
                                Nenhuma edição encontrada.
                            </p>
                        </div>
                    @else
                        @foreach ($edicoes as $edicao)
                            @php
                                $bloqueada = $edicao->tipo_acesso === 'exclusiva' && !$ehAssinante;
                            @endphp

                            <div class="col-md-4 px-3 mb-4 mt-4">

                                @if ($bloqueada)
                                    {{-- ── Card bloqueado: wrapper clicável abre modal ── --}}
                                    <div class="card-exclusiva-wrapper" onclick="abrirModalAssinatura()"
                                        title="Exclusivo para assinantes">

                                        <div class="card shadow-sm h-100 card-exclusiva-bloqueada">
                                            <img class="card-img-top d-block w-100"
                                                src="{{ asset($edicao->imagem_capa) }}"
                                                alt="REVICO #{{ $edicao->id }}" height="290"
                                                style="object-fit:cover;">
                                            <div class="card-body d-flex flex-column">
                                                <div class="mb-2">
                                                    <span class="badge badge-exclusiva rounded-pill">
                                                        🔒 Exclusivo
                                                    </span>
                                                </div>
                                                <p class="datanoticia mb-1 text-muted" style="font-size:.9rem;">
                                                    {{ \Carbon\Carbon::parse($edicao->data_publicacao)->format('d/m/Y') }}
                                                </p>
                                                <p class="card-text mb-2" style="color:black;">
                                                    <b>REVICO #{{ $edicao->id }}
                                                        — {{ Str::limit($edicao->titulo, 40) }}</b>
                                                </p>
                                                <div class="mt-auto">
                                                    <button class="btn btn-secondary btn-sm w-100" disabled>
                                                        <i class="fas fa-lock me-1"></i> Conteúdo Exclusivo
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Ícone de cadeado centralizado --}}
                                        <div class="card-lock-overlay">
                                            <span
                                                style="background:rgba(0,0,0,.55); border-radius:50%;
                                                         width:52px; height:52px; display:flex;
                                                         align-items:center; justify-content:center;">
                                                <i class="fas fa-lock text-white" style="font-size:1.4rem;"></i>
                                            </span>
                                        </div>

                                    </div>
                                @else
                                    {{-- ── Card normal (pública ou assinante) ── --}}
                                    <div class="card shadow-sm h-100" style="width:280px; margin:auto;">
                                        <img class="card-img-top d-block w-100" src="{{ asset($edicao->imagem_capa) }}"
                                            alt="REVICO #{{ $edicao->id }}" height="290" style="object-fit:cover;">
                                        <div class="card-body d-flex flex-column">
                                            <div class="mb-2">
                                                @if ($edicao->tipo_acesso === 'publica')
                                                    <span class="badge badge-publica rounded-pill">
                                                        🌐 Pública
                                                    </span>
                                                @else
                                                    <span class="badge badge-exclusiva rounded-pill">
                                                        ⭐ Exclusiva
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="datanoticia mb-1 text-muted" style="font-size:.9rem;">
                                                {{ \Carbon\Carbon::parse($edicao->created_at)->format('d/m/Y') }}
                                            </p>
                                            <p class="card-text mb-2" style="color:black;">
                                                <b>REVICO #{{ $edicao->id }}
                                                    — {{ Str::limit($edicao->titulo, 40) }}</b>
                                            </p>
                                            <div class="mt-auto">
                                                <a class="btn btn-primary btn-sm w-100"
                                                    href="{{ route('edicoes.show', $edicao->id) }}">
                                                    Leia Mais
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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

    {{-- ════════════════════════════════════════════
         MODAL: convidar a assinar
    ════════════════════════════════════════════ --}}
    <div class="modal fade" id="modalAssinatura" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-crown text-warning" style="font-size:3.5rem;"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Conteúdo Exclusivo para Assinantes</h5>
                    <p class="text-muted mb-4">
                        Esta edição está disponível apenas para assinantes da REVICO.
                        Assine agora e tenha acesso ilimitado a todo o conteúdo exclusivo.
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('assinar') }}" class="btn btn-warning fw-bold px-4">
                            <i class="me-1"></i>Assinar Agora
                        </a>
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                Já sou assinante
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts/footer')

    <script>
        function abrirModalAssinatura() {
            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('modalAssinatura')
            ).show();
        }
    </script>

</body>

</html>
