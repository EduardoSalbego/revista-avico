<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<link rel="stylesheet" href="{{ asset('css/perfil.index.css') }}">

<body id="page-top" class="bg-light">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">
        <div class="row">

            {{-- Cabeçalho ── --}}
            <div class="col-12 mb-4">
                <h2>Meu Perfil</h2>
                <p class="text-muted">Gerencie seus dados de acesso, funções e temas de interesse.</p>
            </div>

            {{-- Alertas ── --}}
            <div class="col-12">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        {{ session('info') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>

            {{-- COLUNA ESQUERDA — Dados pessoais --}}
            <div class="col-md-8 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4">Dados Pessoais</h4>
                        <form action="{{ route('perfil.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nome Completo</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-bold">E-mail de Acesso</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <hr class="mb-4">
                            <h5 class="mb-3">Segurança</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label fw-bold">Nova Senha</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Mínimo 8 caracteres">
                                    <div class="form-text">Deixe em branco se não quiser alterar.</div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="password_confirmation" class="form-label fw-bold">
                                        Confirmar Nova Senha
                                    </label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Repita a nova senha">
                                </div>
                            </div>
                            @php
                                $perfilAcademico = $user->revisor ?? $user->autor;
                            @endphp
                            @if ($perfilAcademico)
                                <hr class="mb-4">
                                <h4 class="card-title mb-4">Dados Acadêmicos</h4>

                                {{-- Instituição --}}
                                <div class="mb-3">
                                    <label for="instituicao" class="form-label fw-bold">
                                        Instituição
                                    </label>
                                    <input type="text" class="form-control" id="instituicao" name="instituicao"
                                        placeholder="Universidade ou instituição de vínculo"
                                        value="{{ old('instituicao', $perfilAcademico->instituicao) }}">
                                </div>

                                {{-- ORCID --}}
                                <div class="mb-3">
                                    <label for="orcid" class="form-label fw-bold">
                                        ORCID
                                    </label>
                                    <input type="text" class="form-control" id="orcid" name="orcid"
                                        placeholder="0000-0000-0000-0000"
                                        value="{{ old('orcid', $perfilAcademico->orcid) }}">
                                </div>

                                {{-- Lattes --}}
                                <div class="mb-3">
                                    <label for="lattes_url" class="form-label fw-bold">
                                        URL do Currículo Lattes
                                    </label>
                                    <input type="url" class="form-control" id="lattes_url" name="lattes_url"
                                        placeholder="https://lattes.cnpq.br/..."
                                        value="{{ old('lattes_url', $perfilAcademico->lattes_url) }}">
                                </div>

                                {{-- Titulação apenas para revisor --}}
                                @if ($user->revisor)
                                    <div class="mb-4">
                                        <label for="titulacao" class="form-label fw-bold">
                                            Titulação
                                        </label>
                                        <input type="text" class="form-control" id="titulacao" name="titulacao"
                                            placeholder="Doutor em Saúde Pública"
                                            value="{{ old('titulacao', $user->revisor->titulacao) }}">
                                    </div>
                                @endif
                            @endif
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Salvar Alterações
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- COLUNA DIREITA — Status --}}
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100 bg-primary text-white">
                    <div class="card-body p-4 d-flex flex-column">
                        <h4 class="card-title mb-4 border-bottom border-light pb-2">Seu Status</h4>
                        <div class="mb-4">
                            <h6 class="text-white-50 text-uppercase mb-2">Funções no Sistema</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($user->funcoes as $funcao)
                                    <span class="badge {{ $funcao['classe'] }} fs-6">
                                        <i class="{{ $funcao['icone'] }} me-1"></i>
                                        {{ $funcao['nome'] }}
                                    </span>
                                @endforeach
                            </div>
                            @php
                                $funcoesDisponiveis = array_filter([
                                    'autor' => !$user->autor,
                                    'revisor' => !$user->revisor,
                                    'leitor' => !$user->leitor,
                                ]);
                            @endphp
                            {{-- BOTÃO ADICIONAR FUNÇÃO --}}
                            @if (!empty($funcoesDisponiveis))
                                <button type="button" class="btn btn-light w-100 fw-bold text-primary mt-3"
                                    data-bs-toggle="modal" data-bs-target="#modalAdicionarFuncao">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    Adicionar Nova Função
                                </button>
                            @endif
                        </div>

                        <div
                            class="mb-4 text-center d-flex flex-column justify-content-center align-items-center h-100">
                            <h6 class="text-white-50 text-uppercase mb-1">Assinatura ReVICO</h6>

                            @if ($user->isAssinante())
                                <p class="fs-5 fw-bold mb-0">
                                    <i class="fas fa-crown me-2"></i> Ativa
                                </p>

                                <small class="text-light">
                                    Válida até {{ \Carbon\Carbon::parse($user->assinante_ate)->format('d/m/Y') }}
                                </small>
                            @else
                                <p class="fs-5 fw-bold text-light mb-0">Inativa</p>

                                <small class="text-light">
                                    Você não possui um plano ativo.
                                </small>
                            @endif
                        </div>

                        <div class="mt-auto pt-4">
                            <a href="{{ route('assinar') }}" class="btn btn-light w-100 fw-bold text-primary">
                                {{ $user->assinante_ate && \Carbon\Carbon::parse($user->assinante_ate)->isFuture()
                                    ? 'Renovar / Estender Plano'
                                    : 'Assinar Agora' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FUNÇÕES — Cards por perfil de domínio --}}
            <div class="col-12 mt-2 mb-2">
                <h4 class="mb-1">Minhas Funções</h4>
                <p class="text-muted mb-4">Edite seus temas de interesse para cada função.</p>

                {{-- ── Autor ── --}}
                @if ($user->autor)
                    @include('perfil._funcao_card', [
                        'tipo' => 'autor',
                        'titulo' => 'Autor',
                        'icone' => 'fas fa-pen-nib',
                        'badge' => 'bg-success',
                        'modelo' => $user->autor,
                        'temas' => $temas,
                        'temasSelecionados' => $user->autor->temas->pluck('id')->toArray(),
                    ])
                @endif

                {{-- ── Revisor ── --}}
                @if ($user->revisor)
                    @include('perfil._funcao_card', [
                        'tipo' => 'revisor',
                        'titulo' => 'Revisor',
                        'icone' => 'fas fa-search',
                        'badge' => 'bg-info text-dark',
                        'modelo' => $user->revisor,
                        'temas' => $temas,
                        'temasSelecionados' => $user->revisor->temas->pluck('id')->toArray(),
                    ])
                @endif

                {{-- ── Leitor ── --}}
                @if ($user->leitor)
                    @include('perfil._funcao_card', [
                        'tipo' => 'leitor',
                        'titulo' => 'Leitor',
                        'icone' => 'fas fa-book-open',
                        'badge' => 'bg-secondary',
                        'modelo' => $user->leitor,
                        'temas' => $temas,
                        'temasSelecionados' => $user->leitor->temas->pluck('id')->toArray(),
                    ])
                @endif
            </div>
        </div>
    </main>

    {{-- MODAL — Adicionar nova função --}}
    <div class="modal fade" id="modalAdicionarFuncao" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Adicionar nova função</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('perfil.funcao.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        {{-- Seleção de função ── --}}
                        <p class="section-divider">Escolha a função</p>
                        <div class="row g-2 mb-3">
                            @if (!$user->leitor)
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="perfil" id="m-leitor"
                                        value="leitor">
                                    <label class="role-label w-100 text-start p-2" for="m-leitor">
                                        <div class="fw-bold mb-1">📖 Leitor</div>
                                        <small class="text-muted">Acesse e comente as edições.</small>
                                    </label>
                                </div>
                            @endif

                            @if (!$user->autor)
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="perfil" id="m-autor"
                                        value="autor">
                                    <label class="role-label w-100 text-start p-2" for="m-autor">
                                        <div class="fw-bold mb-1">✍️ Autor</div>
                                        <small class="text-muted">Submeta artigos para publicação.</small>
                                    </label>
                                </div>
                            @endif

                            @if (!$user->revisor)
                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="perfil" id="m-revisor"
                                        value="revisor">
                                    <label class="role-label w-100 text-start p-2" for="m-revisor">
                                        <div class="fw-bold mb-1">🔍 Revisor</div>
                                        <small class="text-muted">Avalie artigos submetidos.</small>
                                        <span class="badge bg-warning text-dark mt-1">Requer aprovação</span>
                                    </label>
                                </div>
                            @endif
                        </div>

                        {{-- Aviso revisor ── --}}
                        <div id="m-aviso-revisor" class="alert alert-warning" style="display:none;">
                            ⚠️ O perfil de Revisor requer aprovação de um administrador.
                        </div>

                        {{-- Campos extras: Autor ── --}}
                        <div class="modal-extra-fields" id="m-fields-autor">
                            <hr>
                            <p class="section-divider">Dados acadêmicos</p>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">URL do Lattes</label>
                                    <input type="url" class="form-control" name="lattes_url"
                                        placeholder="http://lattes.cnpq.br/...">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">ORCID</label>
                                    <input type="text" class="form-control" name="orcid"
                                        placeholder="0000-0000-0000-0000">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Instituição de vínculo</label>
                                <input type="text" class="form-control" name="instituicao"
                                    placeholder="Ex.: Universidade Federal do Rio Grande do Sul">
                            </div>
                        </div>

                        {{-- Campos extras: Revisor ── --}}
                        <div class="modal-extra-fields" id="m-fields-revisor">
                            <hr>
                            <p class="section-divider">Dados acadêmicos</p>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Titulação</label>
                                    <select class="form-control" name="titulacao">
                                        <option value="">Selecione...</option>
                                        <option value="Especialista">Especialista</option>
                                        <option value="Mestre">Mestre</option>
                                        <option value="Doutor">Doutor</option>
                                        <option value="Pós-Doutor">Pós-Doutor</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">URL do Lattes</label>
                                    <input type="url" class="form-control" name="lattes_url"
                                        placeholder="http://lattes.cnpq.br/...">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">ORCID</label>
                                    <input type="text" class="form-control" name="orcid"
                                        placeholder="0000-0000-0000-0000">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Instituição</label>
                                    <input type="text" class="form-control" name="instituicao"
                                        placeholder="Universidade...">
                                </div>
                            </div>
                        </div>

                        {{-- Temas ── --}}
                        @if ($temas->isNotEmpty())
                            <hr>
                            <p class="section-divider">Temas de interesse</p>
                            <div>
                                @foreach ($temas as $tema)
                                    <input type="checkbox" class="tema-checkbox" name="temas[]"
                                        id="m-tema-{{ $tema->id }}" value="{{ $tema->id }}">
                                    <label for="m-tema-{{ $tema->id }}" class="tema-pill">
                                        {{ $tema->nome }}
                                    </label>
                                @endforeach
                            </div>
                        @endif

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            Adicionar Função
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <script>
        (() => {
            // ── Modal: campos dinâmicos por função selecionada ──
            const mFieldsAutor = document.getElementById('m-fields-autor');
            const mFieldsRevisor = document.getElementById('m-fields-revisor');
            const mAvisoRevisor = document.getElementById('m-aviso-revisor');

            function updateModalFields() {
                const val = document.querySelector('input[name="perfil"]:checked')?.value;

                mFieldsAutor?.classList.remove('visible');
                mFieldsRevisor?.classList.remove('visible');
                if (mAvisoRevisor) mAvisoRevisor.style.display = 'none';

                if (val === 'autor') mFieldsAutor?.classList.add('visible');
                if (val === 'revisor') {
                    mFieldsRevisor?.classList.add('visible');
                    if (mAvisoRevisor) mAvisoRevisor.style.display = 'block';
                }
            }

            document.querySelectorAll('input[name="perfil"]').forEach(r => {
                r.addEventListener('change', updateModalFields);
            });

            // Reset modal ao fechar
            document.getElementById('modalAdicionarFuncao')?.addEventListener('hidden.bs.modal', () => {
                document.querySelectorAll('input[name="perfil"]').forEach(r => r.checked = false);
                document.querySelectorAll('.tema-checkbox').forEach(c => c.checked = false);
                mFieldsAutor?.classList.remove('visible');
                mFieldsRevisor?.classList.remove('visible');
                if (mAvisoRevisor) mAvisoRevisor.style.display = 'none';
            });

        })();
    </script>

</body>

</html>
