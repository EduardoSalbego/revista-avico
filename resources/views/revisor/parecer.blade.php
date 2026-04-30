<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<body id="page-top">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">

        <div class="mb-4">
            <h2 class="mb-0">Minha Fila de Revisão</h2>
            <p class="text-muted">Artigos atribuídos a você para avaliação.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($pareceres->isEmpty())
            <div class="text-center py-5 text-muted">
                <p class="fs-5">Nenhum artigo atribuído a você no momento.</p>
            </div>
        @else
            <div class="d-flex flex-column gap-4">
                @foreach($pareceres as $parecer)
                    @php $submissao = $parecer->submissao; @endphp

                    <div class="card p-4 mb-4">

                        {{-- Cabeçalho --}}
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                            <div>
                                <h5 class="mb-1">
                                    {{ $submissao->titulo }}
                                    {{-- Indica resubmissão após major review --}}
                                    @if($submissao->arquivo_pdf_revisado)
                                        <span class="badge bg-warning text-dark ms-1" style="font-size: 0.7rem;">
                                            🔄 Resubmissão
                                        </span>
                                    @endif
                                </h5>
                                <small class="text-muted">
                                    Autor: <strong>{{ $submissao->autor->name }}</strong>
                                    · Submetido em {{ $submissao->created_at->format('d/m/Y') }}
                                </small>

                                {{-- Aviso de contexto quando é resubmissão --}}
                                @if($submissao->arquivo_pdf_revisado)
                                    <div class="alert alert-warning py-2 mt-2 mb-0" style="font-size: 0.85rem;">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Este artigo passou por uma rodada anterior de revisão e o autor incorporou
                                        as correções solicitadas. Por favor, avalie o PDF revisado abaixo.
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                {{-- Status do parecer --}}
                                @if(is_null($parecer->aceito_tarefa))
                                    <span class="badge bg-warning text-dark">Aguardando sua resposta</span>
                                @elseif(!$parecer->aceito_tarefa)
                                    <span class="badge bg-secondary">Declinado</span>
                                @elseif($parecer->decisao)
                                    {!! $parecer->badgeDecisao() !!}
                                @else
                                    <span class="badge bg-primary">Em avaliação</span>
                                @endif

                                {{-- Botões de download --}}
                                @if($parecer->aceito_tarefa)
                                    {{-- PDF original sempre disponível --}}
                                    {{-- PDF revisado substitui/complementa quando existe --}}
                                    @if($submissao->arquivo_pdf_revisado)
                                        <a href="{{ asset('storage/' . $submissao->arquivo_pdf_revisado) }}" download
                                            class="btn btn-sm btn-warning text-dark fw-semibold">
                                            📥 PDF Revisado
                                        </a>
                                    @endif
                                    <a href="{{ asset('storage/' . $submissao->arquivo_pdf) }}" download
                                        class="btn btn-sm btn-outline-secondary">
                                        📥 PDF Original
                                    </a>
                                @endif
                            </div>
                        </div>
                        {{-- Resumo --}}
                        <p class="text-muted mb-3" style="font-size:0.95rem;">
                            {{ Str::limit($submissao->resumo, 300) }}
                        </p>

                        {{-- Comentário já emitido --}}
                        @if($parecer->comentario && $parecer->decisao)
                            <div class="alert alert-light border py-2 mb-3">
                                <small class="fw-semibold">Seu parecer registrado:</small>
                                <p class="mb-0 small mt-1">{{ $parecer->comentario }}</p>
                            </div>
                        @endif

                        {{-- AÇÃO 1: Aceitar ou declinar a tarefa --}}
                        @if(is_null($parecer->aceito_tarefa))
                            <div class="border-top pt-3 mt-2">
                                <p class="fw-semibold small mb-3">
                                    Você aceita revisar este artigo?
                                </p>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('revisor.pareceres.responderTarefa', $parecer->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="aceito_tarefa" value="1">
                                        <button type="submit" class="btn btn-success btn-sm px-4">
                                            ✅ Aceitar tarefa
                                        </button>
                                    </form>
                                    <form action="{{ route('revisor.pareceres.responderTarefa', $parecer->id) }}" method="POST"
                                        onsubmit="return confirm('Declinar esta tarefa? O editor será notificado para atribuir um substituto.')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="aceito_tarefa" value="0">
                                        <button type="submit" class="btn btn-outline-danger btn-sm px-4">
                                            ❌ Declinar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        {{-- AÇÃO 2: Emitir parecer (só se aceitou e ainda não emitiu) --}}
                        @if($parecer->aceito_tarefa && !$parecer->decisao)
                            <div class="border-top pt-3 mt-2">
                                <p class="fw-semibold small mb-3">Emitir Parecer</p>

                                <form action="{{ route('revisor.pareceres.emitir', $parecer->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Decisão</label>
                                        <div class="d-flex flex-wrap gap-2">

                                            <div class="form-check">
                                                <input class="form-check-input decisao-radio" type="radio" name="decisao"
                                                    id="d_aceito_{{ $parecer->id }}" value="aceito" required>
                                                <label class="form-check-label" for="d_aceito_{{ $parecer->id }}">
                                                    ✅ Aceite
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input decisao-radio" type="radio" name="decisao"
                                                    id="d_rejeitado_{{ $parecer->id }}" value="rejeitado">
                                                <label class="form-check-label" for="d_rejeitado_{{ $parecer->id }}">
                                                    ❌ Decline
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input decisao-radio" type="radio" name="decisao"
                                                    id="d_major_{{ $parecer->id }}" value="major_review">
                                                <label class="form-check-label" for="d_major_{{ $parecer->id }}">
                                                    🔄 Major Review
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input decisao-radio" type="radio" name="decisao"
                                                    id="d_pontual_{{ $parecer->id }}" value="revisao_pontual">
                                                <label class="form-check-label" for="d_pontual_{{ $parecer->id }}">
                                                    📝 Revisão Pontual
                                                </label>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="mb-3" id="comentario_wrap_{{ $parecer->id }}">
                                        <label class="form-label small fw-semibold">
                                            Comentários
                                            <span id="comentario_obrigatorio_{{ $parecer->id }}" class="text-danger"
                                                style="display:none;">
                                                * obrigatório para esta decisão
                                            </span>
                                        </label>
                                        <textarea name="comentario" class="form-control" rows="5" id="comentario_{{ $parecer->id }}"
                                            placeholder="Descreva sua avaliação, pontos a melhorar, justificativa..."></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-sm px-4">
                                        Enviar Parecer
                                    </button>
                                </form>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        @endif

    </main>

    @include('layouts.footer')

    <script>
        // Torna comentário obrigatório para major_review, rejeitado e revisao_pontual
        document.querySelectorAll('.decisao-radio').forEach(radio => {
            radio.addEventListener('change', function () {
                const parecerId = this.id.split('_').pop();
                const comentario = document.getElementById(`comentario_${parecerId}`);
                const aviso = document.getElementById(`comentario_obrigatorio_${parecerId}`);
                const obrigatorio = ['rejeitado', 'major_review', 'revisao_pontual'].includes(this.value);

                comentario.required = obrigatorio;
                aviso.style.display = obrigatorio ? 'inline' : 'none';
            });
        });
    </script>
</body>

</html>