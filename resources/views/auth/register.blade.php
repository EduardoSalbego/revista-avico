<!DOCTYPE html>
<html lang="pt-br">

@include('layouts/head')

<body id="page-top">

    @include('layouts/topbar')

    <main id="content" style="margin-bottom: -90px;">
        <section class="page-section">
            <div class="col-md-5 col-md-offset-4 container">
                <form action="{{ route('register') }}" method="POST">
                    @csrf  
                    <h3 class="text-center mb-4">Crie sua conta</h3>

                    <div class="form-group mb-3">
                        <label class="form-label" for="nameInput">Nome completo</label>
                        <input class="form-control @error('name') is-invalid @enderror"
                            name="name" id="nameInput" type="text"
                            placeholder="Digite seu nome"
                            value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="form-group mb-3">
                        <label class="form-label" for="emailInput">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror"
                            name="email" id="emailInput" type="email"
                            placeholder="Digite seu email"
                            value="{{ old('email') }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mb-3">
                            <label class="form-label" for="passwordInput">Senha</label>
                            <input class="form-control @error('password') is-invalid @enderror"
                                name="password" id="passwordInput" type="password"
                                placeholder="Crie uma senha" required>
                        </div>
                        <div class="col-md-6 form-group mb-4">
                            <label class="form-label" for="confirmPasswordInput">Confirmar senha</label>
                            <input class="form-control"
                                name="password_confirmation" id="confirmPasswordInput"
                                type="password" placeholder="Repita sua senha" required>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label fw-semibold">Tipo de conta</label>
                        <div class="row g-2 mt-1">

                            <div class="col-3">
                                <input type="radio" class="btn-check" name="role" id="role_leitor"
                                    value="leitor" {{ old('role', 'leitor') === 'leitor' ? 'checked' : '' }} required>
                                <label class="role-label w-100 text-start p-2" for="role_leitor">
                                    <div class="fw-bold mb-1">👤 Leitor</div>
                                    <small class="text-muted">Acesse e comente as edições.</small>
                                </label>
                            </div>

                            <div class="col-3">
                                <input type="radio" class="btn-check" name="role" id="role_autor"
                                    value="autor" {{ old('role') === 'autor' ? 'checked' : '' }}>
                                <label class="role-label w-100 text-start p-2" for="role_autor">
                                    <div class="fw-bold mb-1">✍️ Autor</div>
                                    <small class="text-muted">Submeta artigos para publicação.</small>
                                </label>
                            </div>

                            <div class="col-3">
                                <input type="radio" class="btn-check" name="role" id="role_revisor"
                                    value="revisor" {{ old('role') === 'revisor' ? 'checked' : '' }}>
                                <label class="role-label w-100 text-start p-2" for="role_revisor">
                                    <div class="fw-bold mb-1">🔍 Revisor</div>
                                    <small class="text-muted">Revise artigos submetidos.</small>
                                    <span class="badge bg-warning text-dark mt-1">Requer aprovação</span>
                                </label>
                            </div>

                            <div class="col-3">
                                <input type="radio" class="btn-check" name="role" id="role_editor"
                                    value="editor" {{ old('role') === 'editor' ? 'checked' : '' }}>
                                <label class="role-label w-100 text-start p-2" for="role_editor">
                                    <div class="fw-bold mb-1">📝 Editor</div>
                                    <small class="text-muted">Gerencie edições e conteúdos.</small>
                                    <span class="badge bg-warning text-dark mt-1">Requer aprovação</span>
                                </label>
                            </div>

                        </div>

                        {{-- Aviso dinâmico para perfis que precisam de aprovação --}}
                        <div id="aviso-aprovacao" class="alert alert-warning mt-3 mb-0" style="display:none;">
                            ⚠️ Este perfil requer aprovação de um administrador. Sua conta ficará
                            <strong>pendente</strong> até ser aprovada.
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-primary mb-2" type="submit">Cadastrar</button>
                    </div>

                    <div class="text-center">
                        <a href="/login" class="btn btn-outline-secondary">Já tem uma conta? Faça login</a>
                    </div>
                </form>

                @if ($errors->any())
                    <div class="alert alert-danger mt-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </section>
    </main>

    @include('layouts/footer')

    <script>
        const rolesComAprovacao = ['revisor', 'editor'];
        const aviso = document.getElementById('aviso-aprovacao');

        document.querySelectorAll('input[name="role"]').forEach(radio => {
            radio.addEventListener('change', () => {
                aviso.style.display = rolesComAprovacao.includes(radio.value) ? 'block' : 'none';
            });
        });

        // Dispara no carregamento caso old('role') já seja revisor/editor
        const selecionado = document.querySelector('input[name="role"]:checked');
        if (selecionado && rolesComAprovacao.includes(selecionado.value)) {
            aviso.style.display = 'block';
        }
    </script>
</body>
</html>