<!DOCTYPE html>
<html lang="pt-br">
@include('layouts/head')

<body id="page-top">
    @include('layouts/topbar')

    <main class="container py-5" style="margin-top: 50px;">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <h2 class="text-center mb-4">
            Criando a edição #{{ $proximaEdicao ?? '1' }} da revista
        </h2>

        <form id="form-edicao" action="{{ route('editor.edicoes.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="status" id="input-status" value="publicado">

            {{-- ════════════════════════════════════════════
                 INFORMAÇÕES BÁSICAS DA EDIÇÃO
            ════════════════════════════════════════════ --}}
            <div class="card p-4 mb-4 shadow-sm">
                <h4 class="mb-3 border-bottom pb-2">Informações Básicas</h4>

                <div class="mb-3">
                    <label for="titulo" class="form-label fw-semibold">Título da Edição</label>
                    <input type="text" class="form-control" id="titulo" name="titulo"
                        placeholder="Ex: Edição de Outubro 2025" value="{{ old('titulo') }}" required>
                </div>

                <div class="mb-3">
                    <label for="organizador" class="form-label fw-semibold">Organizador(es)</label>
                    <input type="text" class="form-control" id="organizador" name="organizador"
                        placeholder="Nome do editor, organizador ou equipe" value="{{ old('organizador') }}" required>
                </div>

                <div class="mb-3">
                    <label for="resumo" class="form-label fw-semibold">Resumo/Apresentação da Edição</label>
                    <textarea class="form-control" id="resumo" name="resumo" rows="4"
                        placeholder="Apresente brevemente a edição antes da lista de artigos." required>{{ old('resumo') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="imagem_capa" class="form-label fw-semibold">Imagem de Capa</label>
                    <input type="file" class="form-control" id="imagem_capa" name="imagem_capa" accept="image/*"
                        required>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6 mb-3">
                        <label for="tipo_acesso" class="form-label fw-semibold">Tipo de acesso</label>
                        <select class="form-select" id="tipo_acesso" name="tipo_acesso" required>
                            <option value="publica" {{ old('tipo_acesso', 'publica') === 'publica' ? 'selected' : '' }}>
                                Pública</option>
                            <option value="exclusiva" {{ old('tipo_acesso') === 'exclusiva' ? 'selected' : '' }}>
                                Exclusiva (assinantes)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3 d-flex align-items-end">
                        <div class="form-check form-switch pb-2">
                            <input type="hidden" name="permitir_comentarios" value="0">
                            <input class="form-check-input" type="checkbox" id="permitir_comentarios"
                                name="permitir_comentarios" value="1"
                                {{ old('permitir_comentarios', '1') ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="permitir_comentarios">
                                Permitir comentários
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════════════
                 ARTIGOS DA EDIÇÃO
            ════════════════════════════════════════════ --}}
            <div class="card p-4 mb-4 shadow-sm">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 border-bottom pb-2 gap-2">
                    <h4 class="mb-0">Artigos Aprovados</h4>
                    <button type="button" class="btn btn-outline-success btn-sm fw-bold shadow-sm"
                        onclick="adicionarArtigoSistema()">
                        <i class="fas fa-plus me-1"></i> Adicionar Artigo
                    </button>
                </div>

                <p class="text-muted small mb-4">
                    Selecione os artigos que já passaram pelo processo de revisão e foram aprovados no sistema.
                </p>

                {{-- Onde os formulários vão aparecer --}}
                <div id="artigos-container"></div>

                {{-- Template Escondido para o JS pegar as opções do Banco de Dados --}}
                <template id="opcoes-artigos-template">
                    <option value="" disabled selected>-- Clique para selecionar um artigo aprovado --</option>
                    @forelse($artigos ?? [] as $artigo)
                        <option value="{{ $artigo->id }}">#{{ $artigo->id }} - {{ $artigo->titulo }}</option>
                    @empty
                        <option value="" disabled>Nenhum artigo aprovado pendente de publicação encontrado.
                        </option>
                    @endforelse
                </template>

                <div class="text-center mt-3 d-flex justify-content-center">
                    <button type="button" class="btn btn-outline-success fw-bold w-100"
                        onclick="adicionarArtigoSistema()" id="btn-add-artigo">
                        <i class="fas fa-plus me-1"></i> Selecionar Mais um Artigo
                    </button>
                </div>
            </div>

            {{-- ... RESTANTE DO FORMULÁRIO (Botões de salvar) ... --}}
            <div class="mt-5 d-flex justify-content-center gap-3">
                <button type="submit" class="btn btn-outline-secondary btn-lg px-5 fw-bold shadow-sm"
                    onmousedown="document.getElementById('input-status').value='rascunho'">
                    Salvar Rascunho
                </button>
                <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold shadow-sm"
                    onmousedown="document.getElementById('input-status').value='publicado'">
                    <i class="fas fa-check-circle me-1"></i> Publicar Edição
                </button>
            </div>
        </form>
    </main>

    @include('layouts/footer')

    <script>
        let contadorArtigos = 0;
        const opcoesArtigosHTML = document.getElementById('opcoes-artigos-template').innerHTML;

        document.addEventListener('DOMContentLoaded', () => {
            // Verifica se existem artigos disponíveis para adicionar
            if (opcoesArtigosHTML.includes('disabled>Nenhum')) {
                document.getElementById('artigos-container').innerHTML =
                    '<div class="alert alert-warning shadow-sm"><i class="fas fa-exclamation-triangle me-2"></i>Não há artigos aprovados no sistema no momento.</div>';
                document.getElementById('btn-add-artigo').style.display = 'none';
            } else {
                // Inicia com um bloco aberto
                adicionarArtigoSistema();
            }
        });

        function adicionarArtigoSistema() {
            contadorArtigos++;
            const id = contadorArtigos;
            const container = document.getElementById('artigos-container');

            const div = document.createElement('div');
            div.classList.add('card', 'bg-light', 'p-4', 'mb-4', 'artigo-bloco', 'border-success', 'border-2');
            div.dataset.ordem = id;

            div.innerHTML = `
        <div class="d-flex align-items-center gap-2 mb-3 border-bottom border-success pb-2">
            <strong class="text-success me-auto fs-5"><i class="fas fa-link me-1"></i> Artigo <span class="numero-artigo">${id}</span></strong>
            <button type="button" class="btn btn-sm btn-danger fw-bold shadow-sm" onclick="removerArtigo(this, ${id})">
                <i class="fas fa-trash me-1"></i> Remover
            </button>
        </div>

        <div class="row g-3 mb-2">
            <div class="col-md-12">
                <label class="form-label fw-semibold">Vincular Artigo</label>
                <select class="form-select bg-white select-artigo-sistema" 
                        name="artigos[${id}][artigo_id]" 
                        onchange="validarDuplicata(this)" 
                        required>
                    ${opcoesArtigosHTML}
                </select>
                <div class="form-text">Cada artigo só pode ser adicionado uma vez por edição.</div>
            </div>
        </div>
        <input type="hidden" name="artigos[${id}][ordem]" class="campo-ordem" value="${id}">
    `;

            container.appendChild(div);
            atualizarNumeracao();
        }

        function removerArtigo(botao, id) {
            const container = document.getElementById('artigos-container');
            const blocos = container.querySelectorAll('.artigo-bloco');

            if (blocos.length <= 1) {
                alert('A edição precisa ter pelo menos um artigo vinculado.');
                return;
            }

            botao.closest('.artigo-bloco').remove();
            atualizarNumeracao();
        }

        function atualizarNumeracao() {
            document.querySelectorAll('.artigo-bloco').forEach((bloco, index) => {
                bloco.querySelector('.campo-ordem').value = index + 1;
                bloco.querySelector('.numero-artigo').textContent = index + 1;
            });
        }

        // FUNÇÃO PARA VALIDAR SE JÁ EXISTE
        function validarDuplicata(selectAtual) {
            const todosSelects = document.querySelectorAll('.select-artigo-sistema');
            const valorSelecionado = selectAtual.value;

            let duplicado = 0;
            todosSelects.forEach(s => {
                if (s.value === valorSelecionado && valorSelecionado !== "") {
                    duplicado++;
                }
            });

            if (duplicado > 1) {
                alert("Este artigo já foi selecionado nesta edição. Por favor, escolha outro.");
                selectAtual.value = ""; // Limpa a seleção
            }
        }
    </script>
</body>

</html>
