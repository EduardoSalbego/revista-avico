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
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($submissoes->isEmpty())
            <div class="text-center py-5">
                <p class="fs-6 text-secondary">Você não submeteu um artigo.</p>
            </div>
        @else
            <div class="d-flex flex-column gap-3">
                @foreach($submissoes as $submissao)
                    <div class="card p-4 mb-2 {{ $submissao->status === 'major_review' ? 'border-warning border-2' : '' }}">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <h5 class="mb-1">{{ $submissao->titulo }}</h5>
                                <small class="text-muted">
                                    Enviado em {{ $submissao->created_at->format('d/m/Y') }}
                                </small>

                                {{-- Indica se é uma resubmissão --}}
                                @if($submissao->arquivo_pdf_revisado)
                                    <span class="badge bg-warning text-dark ms-2">
                                        🔄 Resubmissão após Major Review
                                    </span>
                                @endif
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

                        {{-- MAJOR REVIEW: autor precisa corrigir e reenviar o PDF --}}
                        @if($submissao->status === 'major_review')
                            <div class="alert alert-warning mt-3 mb-0 border-warning">
                                <div class="d-flex align-items-start gap-2 mb-3">
                                    <span style="font-size: 1.4rem;">🔄</span>
                                    <div>
                                        <strong>Revisão Maior Solicitada</strong><br>
                                        <span class="small">
                                            Os revisores solicitaram correções significativas antes da aprovação.
                                            Corrija seu artigo conforme o feedback acima e reenvie o PDF revisado.
                                            O artigo voltará para os revisores.
                                        </span>
                                    </div>
                                </div>

                                <form action="{{ route('autor.submissoes.resubmeter', $submissao->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex gap-2 align-items-start flex-wrap">
                                        <div class="flex-grow-1">
                                            <input type="file"
                                                class="form-control form-control-sm @error('arquivo_pdf_revisado') is-invalid @enderror"
                                                name="arquivo_pdf_revisado" accept="application/pdf" required>
                                            <div class="form-text">Apenas PDF. Máximo 20MB.</div>
                                            @error('arquivo_pdf_revisado')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-warning btn-sm px-4 fw-semibold"
                                            onclick="return confirm('Enviar o PDF revisado? Os revisores serão notificados para uma nova rodada.')">
                                            Enviar PDF Revisado
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        {{-- REVISÃO PONTUAL: aceito, aguarda DOCX com ajustes --}}
                        @if($submissao->status === 'revisao_pontual' && !$submissao->arquivo_docx)
                            <div class="alert alert-info mt-3 mb-0">
                                <div class="d-flex align-items-start gap-2 mb-3">
                                    <span style="font-size: 1.4rem;">📝</span>
                                    <div>
                                        <strong>Revisões Pontuais Solicitadas</strong><br>
                                        <span class="small">
                                            Seu artigo foi aceito! Leia o feedback do editor, faça os
                                            ajustes pontuais indicados e envie a versão final em DOCX.
                                        </span>
                                    </div>
                                </div>
                                <form action="{{ route('autor.submissoes.docx', $submissao->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex gap-2 align-items-start flex-wrap">
                                        <div class="flex-grow-1">
                                            <input type="file" class="form-control form-control-sm" name="arquivo_docx"
                                                accept=".docx,.doc" required>
                                            <div class="form-text">Formato .docx ou .doc. Máximo 20MB.</div>
                                        </div>
                                        <button type="submit" class="btn btn-info btn-sm px-4 fw-semibold text-dark">
                                            Enviar DOCX Final
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        {{-- ACEITO: upload do DOCX final sem ressalvas --}}
                        @if($submissao->isAceito() && !$submissao->arquivo_docx)
                            <div class="alert alert-success mt-3 mb-0">
                                <div class="d-flex align-items-start gap-2 mb-3">
                                    <span style="font-size: 1.4rem;">🎉</span>
                                    <div>
                                        <strong>Artigo Aceito!</strong><br>
                                        <span class="small">
                                            Parabéns! Envie agora a versão final em DOCX
                                            para o editor incorporar na próxima edição da revista.
                                        </span>
                                    </div>
                                </div>
                                <form action="{{ route('autor.submissoes.docx', $submissao->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex gap-2 align-items-start flex-wrap">
                                        <div class="flex-grow-1">
                                            <input type="file" class="form-control form-control-sm" name="arquivo_docx"
                                                accept=".docx,.doc" required>
                                            <div class="form-text">Formato .docx ou .doc. Máximo 20MB.</div>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-sm px-4 fw-semibold">
                                            Enviar DOCX Final
                                        </button>
                                    </div>
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