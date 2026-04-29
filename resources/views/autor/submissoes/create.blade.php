<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<body id="page-top">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px;">

        <div class="row justify-content-center">
            <div>

                <h2 class="text-center mb-1">Submeter Artigo</h2>
                <p class="text-muted text-center mb-4">
                    Envie seu artigo em PDF para avaliação. Caso aprovado, você será solicitado
                    a enviar a versão final em DOCX.
                </p>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('autor.submissoes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Informações do Artigo --}}
                    <div class="card p-4 mb-4">
                        <h5 class="mb-3">Informações do Artigo</h5>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Título do Artigo</label>
                            <input type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo"
                                value="{{ old('titulo') }}" placeholder="Título completo do artigo" required>
                            @error('titulo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Resumo</label>
                            <textarea class="form-control @error('resumo') is-invalid @enderror" name="resumo" rows="11"
                                placeholder="Resumo do artigo (abstract)..." required>{{ old('resumo') }}</textarea>
                            @error('resumo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Arquivo PDF --}}
                    <div class="card p-4 mb-4">
                        <h5 class="mb-1">Arquivo para Revisão</h5>
                        <p class="text-muted small mb-3">Somente PDF. Tamanho máximo: 20MB.</p>

                        <div class="mb-0">
                            <input type="file" class="form-control @error('arquivo_pdf') is-invalid @enderror"
                                name="arquivo_pdf" accept="application/pdf" required>
                            @error('arquivo_pdf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Cover Letter --}}
                    <div class="card p-4 mb-4">
                        <h5 class="mb-1">Carta de Apresentação</h5>
                        <p class="text-muted small mb-3">
                            Explique brevemente a relevância do artigo, contribuições originais
                            e por que ele é adequado para a REVICO.
                        </p>

                        <textarea class="form-control @error('cover_letter') is-invalid @enderror" name="cover_letter"
                            rows="8" placeholder="Escreva sua carta de apresentação aqui..."
                            required>{{ old('cover_letter') }}</textarea>
                        @error('cover_letter')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Revisores Sugeridos --}}
                    <div class="card p-4 mb-4">
                        <h5 class="mb-1">Revisores Sugeridos</h5>
                        <p class="text-muted small mb-3">
                            Opcional. Você pode sugerir até 4 revisores cadastrados na plataforma.
                            A designação final é de responsabilidade do editor.
                        </p>

                        {{-- Campo de busca --}}
                        <div class="mb-3 position-relative">
                            <input type="text" id="busca-revisor" class="form-control"
                                placeholder="Buscar revisor pelo nome...">
                            <div id="resultados-revisores" class="list-group position-absolute w-100 shadow"
                                style="z-index: 100; display: none; top: 100%;"></div>
                        </div>

                        {{-- Tags dos revisores selecionados --}}
                        <div id="revisores-selecionados" class="d-flex flex-wrap gap-2">
                            {{-- Tags inseridas via JS --}}
                        </div>
                        <div id="revisores-inputs">
                            {{-- Inputs hidden inseridos via JS --}}
                        </div>
                        <small id="aviso-limite" class="text-danger mt-1" style="display:none;">
                            Limite de 4 revisores sugeridos atingido.
                        </small>
                    </div>

                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('autor.submissoes.index') }}" class="btn btn-outline-danger btn-lg">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            Enviar Submissão
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </main>

    @include('layouts.footer')

    <script>
        const MAX_REVISORES = 4;
        const selecionados = {}; // { id: nome }

        const inputBusca = document.getElementById('busca-revisor');
        const resultadosDiv = document.getElementById('resultados-revisores');
        const selecionadosDiv = document.getElementById('revisores-selecionados');
        const inputsDiv = document.getElementById('revisores-inputs');
        const avisoLimite = document.getElementById('aviso-limite');
        inputBusca.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });

        let debounceTimer;
        inputBusca.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            const q = inputBusca.value.trim();

            if (q.length < 2) {
                resultadosDiv.style.display = 'none';
                return;
            }

            // Espera 300ms depois que o usuário parar de digitar para não travar o banco
            debounceTimer = setTimeout(() => buscarRevisores(q), 300);
        });

        // Fecha a caixinha de resultados se clicar fora dela
        document.addEventListener('click', (e) => {
            if (!inputBusca.contains(e.target) && !resultadosDiv.contains(e.target)) {
                resultadosDiv.style.display = 'none';
            }
        });

        // COMUNICAÇÃO COM O SERVIDOR (AJAX)
        async function buscarRevisores(q) {
            try {
                const res = await fetch(`/revisores/buscar?q=${encodeURIComponent(q)}`);
                const data = await res.json(); // Retorna array: [{ id, name }]

                resultadosDiv.innerHTML = '';

                if (!data.length) {
                    resultadosDiv.innerHTML = '<div class="list-group-item text-muted">Nenhum revisor encontrado.</div>';
                    resultadosDiv.style.display = 'block';
                    return;
                }

                data.forEach(revisor => {
                    if (selecionados[revisor.id]) return; // Ignora se já estiver selecionado

                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'list-group-item list-group-item-action';
                    btn.textContent = revisor.name;
                    btn.addEventListener('click', () => adicionarRevisor(revisor.id, revisor.name));
                    resultadosDiv.appendChild(btn);
                });

                resultadosDiv.style.display = 'block';
            } catch (error) {
                console.error("Erro ao buscar revisores:", error);
            }
        }

        // ADICIONA A TAG NA TELA
        function adicionarRevisor(id, nome) {
            if (Object.keys(selecionados).length >= MAX_REVISORES) return;
            if (selecionados[id]) return;

            selecionados[id] = nome;

            const tag = document.createElement('span');
            tag.className = 'badge bg-primary d-flex align-items-center gap-1 px-3 py-2 shadow-sm';
            tag.style.fontSize = '0.85rem';
            tag.innerHTML = `
                ${nome}
                <button type="button" class="btn-close btn-close-white ms-1"
                    style="font-size:0.6rem;"
                    onclick="removerRevisor(${id}, this.closest('span'))">
                </button>
            `;
            selecionadosDiv.appendChild(tag);

            // Cria o Input hidden invisível para enviar no POST do formulário
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'revisores_sugeridos[]';
            input.value = id;
            input.id = `revisor_input_${id}`;
            inputsDiv.appendChild(input);

            // Limpa a barra de busca
            inputBusca.value = '';
            resultadosDiv.style.display = 'none';

            // Verifica se bateu o limite
            avisoLimite.style.display = Object.keys(selecionados).length >= MAX_REVISORES ? 'block' : 'none';
            if (Object.keys(selecionados).length >= MAX_REVISORES) {
                inputBusca.disabled = true;
                inputBusca.placeholder = 'Limite de 4 revisores atingido.';
            }
        }

        // 5. REMOVE A TAG
        function removerRevisor(id, tag) {
            delete selecionados[id];
            tag.remove(); // Remove o visual
            document.getElementById(`revisor_input_${id}`)?.remove(); // Remove o hidden

            avisoLimite.style.display = 'none';
            inputBusca.disabled = false;
            inputBusca.placeholder = 'Buscar revisor pelo nome...';
        }
    </script>
</body>

</html>