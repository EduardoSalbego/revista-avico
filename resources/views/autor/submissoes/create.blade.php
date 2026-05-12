<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<style>
    /* ── Tabs de modo de sugestão ── */
    .revisor-tabs .nav-link {
        color: #6c757d;
        border-radius: 8px 8px 0 0;
    }

    .revisor-tabs .nav-link.active {
        color: #0d6efd;
        font-weight: 600;
    }

    /* ── Tags de revisores selecionados ── */
    .revisor-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #e8f0fe;
        border: 1px solid #c2d4fb;
        color: #0d4fb8;
        border-radius: 999px;
        padding: 5px 12px;
        font-size: 13px;
    }

    .revisor-tag.externo {
        background: #fff3cd;
        border-color: #ffc107;
        color: #7a5800;
    }

    .revisor-tag .tag-remove {
        background: none;
        border: none;
        padding: 0;
        line-height: 1;
        cursor: pointer;
        font-size: 16px;
        color: inherit;
        opacity: .6;
        transition: opacity .15s;
    }

    .revisor-tag .tag-remove:hover {
        opacity: 1;
    }

    /* ── Dropdown de busca ── */
    #resultados-revisores {
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 8px 8px;
        max-height: 220px;
        overflow-y: auto;
    }

    #resultados-revisores .list-group-item {
        font-size: 14px;
        cursor: pointer;
    }

    #resultados-revisores .list-group-item:hover {
        background: #f0f4ff;
    }

    .revisor-label-badge {
        font-size: 10px;
        padding: 2px 7px;
        border-radius: 999px;
        font-weight: 500;
    }
</style>

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
                    {{-- ════════════════════════════════════
                    AUTORES E COAUTORES
                    ════════════════════════════════════ --}}
                    <div class="card p-4 mb-4">
                        <h5 class="mb-1">Autores do Artigo</h5>
                        <p class="text-muted small mb-3">
                            Informe o autor principal obrigatoriamente. Você também pode adicionar coautores caso o
                            trabalho tenha sido feito em equipe.
                        </p>

                        {{-- Autor Principal (Obrigatório) --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Autor Principal <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('autor_principal') is-invalid @enderror"
                                name="autor_principal" value="{{ old('autor_principal') }}"
                                placeholder="Nome completo do autor principal" required>
                            @error('autor_principal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Coautores (Opcional) --}}
                        <div class="mb-2">
                            <label class="form-label fw-semibold">Coautores <span
                                    class="text-muted fw-normal">(Opcional)</span></label>

                            <div id="container-coautores">
                                {{-- Recuperação de old('coautores') em caso de erro de validação --}}
                                @if(old('coautores'))
                                    @foreach(old('coautores') as $coautor)
                                        <div class="input-group mb-2 coautor-row">
                                            <input type="text" class="form-control" name="coautores[]" value="{{ $coautor }}"
                                                placeholder="Nome completo do coautor">
                                            <button class="btn btn-outline-danger" type="button" onclick="removerCoautor(this)">
                                                <i class="bi bi-trash"></i> Remover
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <button type="button" class="btn btn-sm btn-outline-secondary mt-1"
                                onclick="adicionarCoautor()">
                                + Adicionar Coautor
                            </button>
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

                    {{-- ════════════════════════════════════
                    REVISORES SUGERIDOS (refatorado)
                    ════════════════════════════════════ --}}
                    <div class="card p-4 mb-4">

                        <h5 class="mb-1">Revisores Sugeridos</h5>
                        <p class="text-muted small mb-3">
                            Opcional. Você pode sugerir até 4 revisores. A designação final
                            é responsabilidade do editor.
                        </p>

                        {{-- Tags dos revisores já adicionados ── --}}
                        <div id="revisores-selecionados" class="d-flex flex-wrap gap-2 mb-3"></div>

                        {{-- Aviso de limite ── --}}
                        <div id="aviso-limite" class="alert alert-warning py-2 small" style="display:none;">
                            ⚠️ Limite de 4 revisores atingido.
                        </div>

                        {{-- Tabs: Buscar no sistema / Indicar externo ── --}}
                        <ul class="nav nav-tabs revisor-tabs mb-3" id="tabsRevisor">
                            <li class="nav-item">
                                <button class="nav-link active" type="button" data-tab="busca"
                                    onclick="switchTab('busca', this)">
                                    🔍 Buscar no sistema
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" type="button" data-tab="externo"
                                    onclick="switchTab('externo', this)">
                                    ✉️ Indicar externo
                                </button>
                            </li>
                        </ul>

                        {{-- Painel: Busca ── --}}
                        <div id="painel-busca">
                            <div class="position-relative">
                                <input type="text" id="busca-revisor" class="form-control"
                                    placeholder="Digite o nome do revisor...">
                                <div id="resultados-revisores" class="list-group position-absolute w-100 shadow"
                                    style="z-index: 100; display: none; top: 100%;">
                                </div>
                            </div>
                            <div class="form-text mt-1">
                                Busca revisores cadastrados na plataforma.
                            </div>
                        </div>

                        {{-- Painel: Externo ── --}}
                        <div id="painel-externo" style="display:none;">
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <input type="text" id="ext-nome" class="form-control"
                                        placeholder="Nome completo do revisor">
                                </div>
                                <div class="col-md-5">
                                    <input type="email" id="ext-email" class="form-control"
                                        placeholder="E-mail do revisor">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-primary w-100"
                                        onclick="adicionarExterno()">
                                        Adicionar
                                    </button>
                                </div>
                            </div>
                            <div class="form-text mt-1">
                                Informe nome e e-mail de um revisor que ainda não está cadastrado.
                            </div>
                            <div id="ext-erro" class="text-danger small mt-1" style="display:none;"></div>
                        </div>

                        {{-- Inputs hidden enviados ao servidor ── --}}
                        <div id="revisores-inputs"></div>

                    </div>
                    {{-- /revisores --}}

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
        function adicionarCoautor() {
            const container = document.getElementById('container-coautores');

            // Cria a div row
            const div = document.createElement('div');
            div.className = 'input-group mb-2 coautor-row';

            // Cria o input e o botão de remover
            div.innerHTML = `
                <input type="text" class="form-control" name="coautores[]" placeholder="Nome completo do coautor" required>
                <button class="btn btn-outline-danger" type="button" onclick="removerCoautor(this)">
                    Remover
                </button>
            `;

            container.appendChild(div);

            // Opcional: focar automaticamente no novo campo criado
            div.querySelector('input').focus();
        }

        function removerCoautor(botao) {
            botao.closest('.coautor-row').remove();
        }
        (() => {
            const MAX = 4;

            // Estado: lista de revisores adicionados
            // Cada item: { tipo: 'sistema'|'externo', revisor_id, nome, email }
            const lista = [];

            // ── Referências DOM ──
            const tagsDiv = document.getElementById('revisores-selecionados');
            const inputsDiv = document.getElementById('revisores-inputs');
            const avisoLimite = document.getElementById('aviso-limite');
            const inputBusca = document.getElementById('busca-revisor');
            const resultados = document.getElementById('resultados-revisores');
            const extNome = document.getElementById('ext-nome');
            const extEmail = document.getElementById('ext-email');
            const extErro = document.getElementById('ext-erro');

            // ────────────────────────────────────────
            // Tabs
            // ────────────────────────────────────────
            window.switchTab = function (tab, btn) {
                document.querySelectorAll('.revisor-tabs .nav-link')
                    .forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                document.getElementById('painel-busca').style.display = tab === 'busca' ? 'block' : 'none';
                document.getElementById('painel-externo').style.display = tab === 'externo' ? 'block' : 'none';

                resultados.style.display = 'none';
            };

            // ────────────────────────────────────────
            // Busca no sistema (revisores cadastrados)
            // ────────────────────────────────────────
            let debounce;
            inputBusca.addEventListener('input', () => {
                clearTimeout(debounce);
                const q = inputBusca.value.trim();
                if (q.length < 2) { resultados.style.display = 'none'; return; }
                debounce = setTimeout(() => buscar(q), 300);
            });

            inputBusca.addEventListener('keydown', e => {
                if (e.key === 'Enter') e.preventDefault();
            });

            document.addEventListener('click', e => {
                if (!inputBusca.contains(e.target) && !resultados.contains(e.target)) {
                    resultados.style.display = 'none';
                }
            });

            async function buscar(q) {
                try {
                    const res = await fetch(`/revisores/buscar?q=${encodeURIComponent(q)}`);
                    const data = await res.json(); // [{ id, nome, email }]

                    resultados.innerHTML = '';

                    const idsJaSelecionados = lista
                        .filter(r => r.tipo === 'sistema')
                        .map(r => r.revisor_id);

                    const disponiveis = data.filter(r => !idsJaSelecionados.includes(r.id));

                    if (!disponiveis.length) {
                        resultados.innerHTML =
                            '<div class="list-group-item text-muted py-2">Nenhum revisor encontrado.</div>';
                        resultados.style.display = 'block';
                        return;
                    }

                    disponiveis.forEach(r => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center';
                        btn.innerHTML = `
                        <span>${r.nome ?? r.name}</span>
                        <span class="revisor-label-badge bg-primary text-white">Cadastrado</span>
                    `;
                        btn.addEventListener('click', () => {
                            adicionarDeSistema(r.id, r.nome ?? r.name, r.email);
                        });
                        resultados.appendChild(btn);
                    });

                    resultados.style.display = 'block';
                } catch (err) {
                    console.error('Erro ao buscar revisores:', err);
                }
            }

            function adicionarDeSistema(id, nome, email) {
                if (lista.length >= MAX) return;
                if (lista.some(r => r.tipo === 'sistema' && r.revisor_id === id)) return;

                lista.push({ tipo: 'sistema', revisor_id: id, nome, email });
                renderTags();
                renderInputs();

                inputBusca.value = '';
                resultados.style.display = 'none';
                atualizarLimite();
            }

            // ────────────────────────────────────────
            // Revisor externo (não cadastrado)
            // ────────────────────────────────────────
            window.adicionarExterno = function () {
                extErro.style.display = 'none';
                const nome = extNome.value.trim();
                const email = extEmail.value.trim();

                if (!nome) {
                    mostrarErroExt('Informe o nome do revisor.');
                    return;
                }
                if (!email || !email.includes('@')) {
                    mostrarErroExt('Informe um e-mail válido.');
                    return;
                }
                if (lista.some(r => r.tipo === 'externo' && r.email === email)) {
                    mostrarErroExt('Este e-mail já foi adicionado.');
                    return;
                }
                if (lista.length >= MAX) return;

                lista.push({ tipo: 'externo', revisor_id: null, nome, email });
                renderTags();
                renderInputs();

                extNome.value = '';
                extEmail.value = '';
                atualizarLimite();
            };

            function mostrarErroExt(msg) {
                extErro.textContent = msg;
                extErro.style.display = 'block';
            }

            // ────────────────────────────────────────
            // Remover
            // ────────────────────────────────────────
            function remover(idx) {
                lista.splice(idx, 1);
                renderTags();
                renderInputs();
                atualizarLimite();
            }

            // ────────────────────────────────────────
            // Render tags visuais
            // ────────────────────────────────────────
            function renderTags() {
                tagsDiv.innerHTML = '';
                lista.forEach((r, i) => {
                    const tag = document.createElement('span');
                    tag.className = `revisor-tag ${r.tipo === 'externo' ? 'externo' : ''}`;
                    tag.innerHTML = `
                    <span>
                        ${r.nome}
                        ${r.tipo === 'externo'
                            ? `<small class="opacity-75 ms-1">(externo)</small>`
                            : ''
                        }
                    </span>
                    <button type="button" class="tag-remove" onclick="window._remover(${i})" title="Remover">
                        &times;
                    </button>
                `;
                    tagsDiv.appendChild(tag);
                });
            }

            // Expõe remover globalmente para o onclick inline
            window._remover = remover;

            // ────────────────────────────────────────
            // Render inputs hidden para o POST
            // ────────────────────────────────────────
            function renderInputs() {
                inputsDiv.innerHTML = '';
                lista.forEach((r, i) => {
                    // revisor_id (null se externo)
                    const inputId = document.createElement('input');
                    inputId.type = 'hidden';
                    inputId.name = `revisores_sugeridos[${i}][revisor_id]`;
                    inputId.value = r.revisor_id ?? '';
                    inputsDiv.appendChild(inputId);

                    // nome
                    const inputNome = document.createElement('input');
                    inputNome.type = 'hidden';
                    inputNome.name = `revisores_sugeridos[${i}][nome]`;
                    inputNome.value = r.nome;
                    inputsDiv.appendChild(inputNome);

                    // email
                    const inputEmail = document.createElement('input');
                    inputEmail.type = 'hidden';
                    inputEmail.name = `revisores_sugeridos[${i}][email]`;
                    inputEmail.value = r.email ?? '';
                    inputsDiv.appendChild(inputEmail);
                });
            }

            // ────────────────────────────────────────
            // Controle do limite
            // ────────────────────────────────────────
            function atualizarLimite() {
                const cheio = lista.length >= MAX;
                avisoLimite.style.display = cheio ? 'block' : 'none';
                inputBusca.disabled = cheio;
                extNome.disabled = cheio;
                extEmail.disabled = cheio;
                inputBusca.placeholder = cheio
                    ? 'Limite de 4 revisores atingido.'
                    : 'Digite o nome do revisor...';
            }

        })();
    </script>

</body>

</html>