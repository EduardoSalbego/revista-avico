<!DOCTYPE html>
<html lang="pt-br">

@include('layouts/head')

<link rel="stylesheet" href="{{ asset('css/register.css') }}">

<body id="page-top">

    @include('layouts/topbar')

    <main id="content" style="margin-bottom: -90px;">
        <section class="page-section">
            <div class="col-md-5 col-md-offset-4 container">

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" id="form-register">
                    @csrf

                    <h3 class="text-center mb-4">Crie sua conta</h3>

                    {{-- Progress ── --}}
                    <div class="wizard-steps">
                        <div class="ws-item active" id="prog-1">
                            <div class="ws-dot">1</div>
                            <div class="ws-label">Acesso</div>
                        </div>
                        <div class="ws-line" id="line-1"></div>
                        <div class="ws-item" id="prog-2">
                            <div class="ws-dot">2</div>
                            <div class="ws-label">Perfil</div>
                        </div>
                    </div>

                    {{-- ══════════════════════════
                    STEP 1 — Dados de acesso
                    ══════════════════════════ --}}
                    <div class="step-panel active" id="step-1">

                        <div class="form-group mb-3">
                            <label class="form-label" for="nameInput">Nome completo</label>
                            <input class="form-control @error('name') is-invalid @enderror" name="name" id="nameInput"
                                type="text" placeholder="Digite seu nome" value="{{ old('name') }}" autofocus>
                            @error('name')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label" for="emailInput">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" name="email"
                                id="emailInput" type="email" placeholder="Digite seu email" value="{{ old('email') }}">
                            @error('email')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="form-label" for="passwordInput">Senha</label>
                                <input class="form-control @error('password') is-invalid @enderror" name="password"
                                    id="passwordInput" type="password" placeholder="Mínimo 8 caracteres">
                                @error('password')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-4">
                                <label class="form-label" for="confirmPasswordInput">Confirmar senha</label>
                                <input class="form-control" name="password_confirmation" id="confirmPasswordInput"
                                    type="password" placeholder="Repita sua senha">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary mb-2" id="btn-to-step2">
                                Continuar →
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                                Já tem uma conta? Faça login
                            </a>
                        </div>

                    </div>{{-- /step-1 --}}

                    {{-- ══════════════════════════
                    STEP 2 — Perfil
                    ══════════════════════════ --}}
                    <div class="step-panel" id="step-2">

                        <div class="form-group mb-3">
                            <label class="form-label fw-semibold">Tipo de conta</label>

                            <div class="row g-2 mt-1">

                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="perfil"
                                        id="p-leitor" value="leitor"
                                        {{ old('perfil', 'leitor') === 'leitor' ? 'checked' : '' }}>
                                    <label class="role-label w-100 text-start p-2" for="p-leitor">
                                        <div class="fw-bold mb-1">📖 Leitor</div>
                                        <small class="text-muted">Acesse e comente as edições.</small>
                                    </label>
                                </div>

                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="perfil"
                                        id="p-autor" value="autor"
                                        {{ old('perfil') === 'autor' ? 'checked' : '' }}>
                                    <label class="role-label w-100 text-start p-2" for="p-autor">
                                        <div class="fw-bold mb-1">✍️ Autor</div>
                                        <small class="text-muted">Submeta artigos para publicação.</small>
                                    </label>
                                </div>

                                <div class="col-4">
                                    <input type="radio" class="btn-check" name="perfil"
                                        id="p-revisor" value="revisor"
                                        {{ old('perfil') === 'revisor' ? 'checked' : '' }}>
                                    <label class="role-label w-100 text-start p-2" for="p-revisor">
                                        <div class="fw-bold mb-1">🔍 Revisor</div>
                                        <small class="text-muted">Revise artigos submetidos.</small>
                                        <span class="badge bg-warning text-dark mt-1">Requer aprovação</span>
                                    </label>
                                </div>

                            </div>

                            @error('perfil')
                                <span class="field-error mt-1">{{ $message }}</span>
                            @enderror

                            <div id="aviso-aprovacao" class="alert alert-warning mt-3 mb-0" style="display:none;">
                                ⚠️ Este perfil requer aprovação de um administrador. Sua conta ficará
                                <strong>pendente</strong> até ser aprovada.
                            </div>
                        </div>

                        {{-- Campos extras: Autor ── --}}
                        <div class="extra-fields" id="fields-autor">
                            <hr class="my-3">
                            <p class="text-muted small fw-semibold text-uppercase mb-3" style="letter-spacing:.06em;">
                                Dados acadêmicos
                            </p>
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="lattes_url">URL do Lattes</label>
                                    <input class="form-control @error('lattes_url') is-invalid @enderror" type="url"
                                        id="lattes_url" name="lattes_url" placeholder="http://lattes.cnpq.br/..."
                                        value="{{ old('lattes_url') }}">
                                    @error('lattes_url')
                                        <span class="field-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="orcid">ORCID</label>
                                    <input class="form-control @error('orcid') is-invalid @enderror" type="text"
                                        id="orcid" name="orcid" placeholder="0000-0000-0000-0000"
                                        value="{{ old('orcid') }}">
                                    @error('orcid')
                                        <span class="field-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-label" for="instituicao">Instituição de vínculo</label>
                                <input class="form-control @error('instituicao') is-invalid @enderror" type="text"
                                    id="instituicao" name="instituicao"
                                    placeholder="Ex.: Universidade Federal do Rio Grande do Sul"
                                    value="{{ old('instituicao') }}">
                                @error('instituicao')
                                    <span class="field-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Campos extras: Revisor ── --}}
                        <div class="extra-fields" id="fields-revisor">
                            <hr class="my-3">
                            <p class="text-muted small fw-semibold text-uppercase mb-3" style="letter-spacing:.06em;">
                                Dados acadêmicos
                            </p>
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="titulacao">Titulação</label>
                                    <select class="form-control @error('titulacao') is-invalid @enderror" id="titulacao"
                                        name="titulacao">
                                        <option value="">Selecione...</option>
                                        <option value="Especialista" {{ old('titulacao') === 'Especialista' ? 'selected' : '' }}>Especialista</option>
                                        <option value="Mestre" {{ old('titulacao') === 'Mestre' ? 'selected' : '' }}>
                                            Mestre</option>
                                        <option value="Doutor" {{ old('titulacao') === 'Doutor' ? 'selected' : '' }}>
                                            Doutor</option>
                                        <option value="Pós-Doutor" {{ old('titulacao') === 'Pós-Doutor' ? 'selected' : '' }}>Pós-Doutor</option>
                                    </select>
                                    @error('titulacao')
                                        <span class="field-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="lattes_url_rev">URL do Lattes</label>
                                    <input class="form-control" type="url" id="lattes_url_rev" name="lattes_url"
                                        placeholder="http://lattes.cnpq.br/..." value="{{ old('lattes_url') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="orcid_rev">ORCID</label>
                                    <input class="form-control" type="text" id="orcid_rev" name="orcid"
                                        placeholder="0000-0000-0000-0000" value="{{ old('orcid') }}">
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label class="form-label" for="instituicao_rev">Instituição</label>
                                    <input class="form-control" type="text" id="instituicao_rev" name="instituicao"
                                        placeholder="Universidade..." value="{{ old('instituicao') }}">
                                </div>
                            </div>
                        </div>

                        {{-- Temas de interesse ── --}}
                        @if($temas->isNotEmpty())
                            <hr class="my-3">
                            <p class="text-muted small fw-semibold text-uppercase mb-2" style="letter-spacing:.06em;">
                                Temas de interesse
                            </p>
                            <div class="mb-3">
                                @foreach ($temas as $tema)
                                    <input type="checkbox" class="tema-checkbox" name="temas[]" id="tema-{{ $tema->id }}"
                                        value="{{ $tema->id }}" {{ in_array($tema->id, old('temas', [])) ? 'checked' : '' }}>
                                    <label for="tema-{{ $tema->id }}" class="tema-pill">
                                        {{ $tema->nome }}
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        <div class="wizard-nav mt-2 mb-3">
                            <button type="button" class="btn btn-outline-secondary" id="btn-to-step1">
                                ← Voltar
                            </button>
                            <button type="submit" class="btn btn-primary" id="btn-submit">
                                Cadastrar
                            </button>
                        </div>

                    </div>{{-- /step-2 --}}

                </form>

            </div>
        </section>
    </main>

    @include('layouts/footer')

    <script>
        (() => {
            const step1 = document.getElementById('step-1');
            const step2 = document.getElementById('step-2');
            const prog1 = document.getElementById('prog-1');
            const prog2 = document.getElementById('prog-2');
            const line1 = document.getElementById('line-1');
            const btnNext = document.getElementById('btn-to-step2');
            const btnBack = document.getElementById('btn-to-step1');
            const btnSub = document.getElementById('btn-submit');

            // Se voltou com erro do servidor e perfil já foi escolhido → abre step 2
            const hasError = {{ $errors->any() ? 'true' : 'false' }};
            const oldPerfil = '{{ old("perfil") }}';

            if (hasError && oldPerfil) goToStep(2);

            // ── Navegação ──
            btnNext.addEventListener('click', () => { if (validateStep1()) goToStep(2); });
            btnBack.addEventListener('click', () => goToStep(1));

            function goToStep(n) {
                if (n === 1) {
                    step1.classList.add('active');
                    step2.classList.remove('active');
                    prog1.classList.add('active');
                    prog1.classList.remove('done');
                    prog2.classList.remove('active', 'done');
                    line1.classList.remove('done');
                } else {
                    step1.classList.remove('active');
                    step2.classList.add('active');
                    prog1.classList.remove('active');
                    prog1.classList.add('done');
                    prog2.classList.add('active');
                    line1.classList.add('done');
                }
            }

            // ── Validação client-side step 1 ──
            function validateStep1() {
                const fields = {
                    name: document.getElementById('nameInput'),
                    email: document.getElementById('emailInput'),
                    pass: document.getElementById('passwordInput'),
                    confirm: document.getElementById('confirmPasswordInput'),
                };
                let ok = true;

                Object.values(fields).forEach(f => {
                    f.classList.remove('is-invalid');
                    f.parentElement.querySelector('.client-error')?.remove();
                });

                if (!fields.name.value.trim()) {
                    markError(fields.name, 'Informe seu nome completo.');
                    ok = false;
                }
                if (!fields.email.value.includes('@')) {
                    markError(fields.email, 'Informe um e-mail válido.');
                    ok = false;
                }
                if (fields.pass.value.length < 8) {
                    markError(fields.pass, 'A senha deve ter pelo menos 8 caracteres.');
                    ok = false;
                }
                if (fields.pass.value !== fields.confirm.value) {
                    markError(fields.confirm, 'As senhas não coincidem.');
                    ok = false;
                }

                return ok;
            }

            function markError(input, msg) {
                input.classList.add('is-invalid');
                const span = document.createElement('span');
                span.className = 'field-error client-error';
                span.textContent = msg;
                input.insertAdjacentElement('afterend', span);
            }

            // ── Campos dinâmicos por perfil ──
            const fieldsAutor = document.getElementById('fields-autor');
            const fieldsRevisor = document.getElementById('fields-revisor');
            const avisoAprov = document.getElementById('aviso-aprovacao');

            function updatePerfil() {
                const val = document.querySelector('input[name="perfil"]:checked')?.value;
                fieldsAutor.classList.remove('visible');
                fieldsRevisor.classList.remove('visible');
                avisoAprov.style.display = 'none';

                if (val === 'autor') fieldsAutor.classList.add('visible');
                if (val === 'revisor') {
                    fieldsRevisor.classList.add('visible');
                    avisoAprov.style.display = 'block';
                }
            }

            document.querySelectorAll('input[name="perfil"]').forEach(r => {
                r.addEventListener('change', updatePerfil);
            });

            updatePerfil();

            // ── Previne double-submit ──
            document.getElementById('form-register').addEventListener('submit', () => {
                btnSub.disabled = true;
                btnSub.textContent = 'Cadastrando...';
            });

        })();
    </script>

</body>

</html>