<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<body id="page-top">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Minhas Submissões</h2>
                <p class="text-muted mb-0">Acompanhe o status dos seus artigos enviados.</p>
            </div>
            <a href="{{ route('autor.submissoes.create') }}" class="btn btn-primary">
                + Submeter Artigo
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($submissoes->isEmpty())
            <div class="text-center py-5">
                <p class="fs-6 text-secondary">Você não submeteu um artigo.</p>
            </div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach($submissoes as $submissao)
                    <div class="card p-4 mb-4">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <h5 class="mb-1">{{ $submissao->titulo }}</h5>
                                <small class="text-muted">
                                    Enviado em {{ $submissao->created_at->format('d/m/Y') }}
                                </small>
                            </div>
                            {!! $submissao->badgeStatus() !!}
                        </div>

                        <p class="text-muted mt-3 mb-2" style="font-size: 0.95rem;">
                            {{ Str::limit($submissao->resumo, 200) }}
                        </p>

                        {{-- Revisores sugeridos --}}
                        @if($submissao->revisoresSugeridos->isNotEmpty())
                            <div class="mb-2">
                                <small class="text-muted fw-semibold">Revisores sugeridos: </small>
                                @foreach($submissao->revisoresSugeridos as $revisor)
                                    <span class="badge bg-light text-dark border">{{ $revisor->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Observações do editor --}}
                        @if($submissao->observacoes)
                            <div class="alert alert-info py-2 mt-3 mb-2">
                                <strong>Observação do editor:</strong> {{ $submissao->observacoes }}
                            </div>
                        @endif

                        {{-- Upload de DOCX (só aparece se aceito e ainda não enviou) --}}
                        @if($submissao->isAceito() && !$submissao->arquivo_docx)
                            <div class="alert alert-success mt-3 mb-0">
                                <strong>🎉 Artigo aceito!</strong>
                                Envie agora a versão final em DOCX para o editor incorporar na revista.
                                <form action="{{ route('autor.submissoes.docx', $submissao->id) }}" method="POST"
                                    enctype="multipart/form-data" class="mt-2 d-flex gap-2">
                                    @csrf
                                    <input type="file" class="form-control form-control-sm" name="arquivo_docx" accept=".docx,.doc"
                                        required>
                                    <button type="submit" class="btn btn-success btn-sm px-3">
                                        Enviar DOCX
                                    </button>
                                </form>
                            </div>
                        @elseif($submissao->isAceito() && $submissao->arquivo_docx)
                            <div class="alert alert-success py-2 mt-3 mb-0">
                                ✅ Versão final em DOCX enviada. Aguardando incorporação pelo editor.
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $submissoes->links() }}
            </div>
        @endif

    </main>

    @include('layouts.footer')
</body>

</html>