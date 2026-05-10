<div class="card mb-4 shadow-sm border-0">
    <div class="card-body">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-start mb-3">

            <h5 class="card-title mb-0">
                <span class="badge {{ $badge }}">
                    <i class="{{ $icone }}"></i>
                    {{ $titulo }}
                </span>
            </h5>

            {{-- BOTÃO EDITAR TEMAS --}}
            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#modalTemas{{ ucfirst($tipo) }}">
                <i class="fas fa-edit me-1"></i>Editar Temas
            </button>
        </div>
        <hr>

        {{-- TEMAS --}}
        <p class="mb-2">
            <strong>Temas de interesse:</strong>
        </p>

        @if(count($temasSelecionados))
            <div class="d-flex flex-wrap gap-2">
                @foreach($temas as $tema)
                    @if($modelo->temas->contains('id', $tema->id))
                        <span class="badge bg-primary">
                            {{ $tema->nome }}
                        </span>
                    @endif
                @endforeach
            </div>
        @else
            <p class="text-muted mb-0">
                Nenhum tema selecionado.
            </p>
        @endif
    </div>
</div>

{{-- ════════════════════════════════════
MODAL TEMAS
════════════════════════════════════ --}}
<div class="modal fade" id="modalTemas{{ ucfirst($tipo) }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('perfil.temas.update', $tipo) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">
                        Editar temas de {{ $titulo }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column gap-2">
                        @foreach($temas as $tema)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="temas[]" value="{{ $tema->id }}"
                                                    id="tema{{ $tipo }}{{ $tema->id }}" {{ $modelo->temas->contains('id', $tema->id)
                            ? 'checked'
                            : '' }}>

                                                <label class="form-check-label" for="tema{{ $tipo }}{{ $tema->id }}">
                                                    {{ $tema->nome }}
                                                </label>

                                            </div>

                        @endforeach
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Salvar Temas
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>