@php $sid = $submissao->id; @endphp

<form action="{{ $rotaForm }}" method="POST" id="form-atribuir-{{ $sid }}"
    onsubmit="return validarEnvioRevisao({{ $sid }})">
    @csrf
    @method('PATCH')

    <label class="form-label fw-bold small text-primary mb-2">
        Equipe de Revisão
        <span class="text-muted fw-normal">(3 a 4 revisores)</span>
    </label>

    <div class="row g-2">
        {{-- Coluna: Disponíveis --}}
        <div class="col-sm-6">
            <div class="border rounded bg-white p-2 shadow-sm" style="height:180px;overflow-y:auto;">
                <small class="d-block text-muted mb-2 fw-bold border-bottom pb-1">Disponíveis</small>
                <div id="lista-disp-{{ $sid }}" class="d-flex flex-column gap-1">
                    @foreach ($revisores as $revisor)
                        <div class="d-flex justify-content-between align-items-center bg-light border rounded px-2 py-1"
                            id="item-disp-{{ $sid }}-{{ $revisor->id }}">
                            <span class="small text-truncate" style="max-width:130px;"
                                title="{{ $revisor->user->name }}">{{ $revisor->user->name }}</span>
                            <button type="button" class="btn btn-sm btn-outline-success border-0 py-0 px-2"
                                onclick="adicionarRevisor({{ $sid }}, {{ $revisor->id }}, '{{ addslashes($revisor->user->name) }}')"
                                title="Adicionar">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Coluna: Selecionados --}}
        <div class="col-sm-6">
            <div class="border rounded bg-white p-2 shadow-sm" style="height:180px;overflow-y:auto;">
                <small class="d-block text-muted mb-2 fw-bold border-bottom pb-1">Selecionados</small>
                <div id="lista-sel-{{ $sid }}" class="d-flex flex-column gap-1"></div>
                <div id="inputs-ocultos-{{ $sid }}"></div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary px-4 shadow-sm">
            <i class="fas fa-paper-plane me-1"></i> {{ $labelBtn }}
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const preCarregados = @json($preCarregados ?? []);
        Object.entries(preCarregados).forEach(([id, nome]) => {
            adicionarRevisor({{ $sid }}, Number(id), nome, true);
        });
    });
</script>
