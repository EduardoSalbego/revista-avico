<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<body id="page-top" class="bg-light">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1">
                            Novo Usuário
                        </h2>
                        <p class="text-muted mb-0">
                            Cadastre um novo usuário na plataforma
                        </p>
                    </div>

                    <a href="{{ route('admin.usuarios.index') }}"
                       class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Voltar
                    </a>
                </div>

                {{-- ERROS --}}
                @if ($errors->any())
                    <div class="alert alert-danger shadow-sm">
                        <strong>Ocorreram erros:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.usuarios.store') }}"
                      method="POST">
                    @csrf
                    <div class="row">

                        {{-- COLUNA ESQUERDA --}}
                        <div class="col-lg-8">

                            {{-- DADOS DA CONTA --}}
                            <div class="card shadow-sm border-0 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="card-title mb-4">
                                        Dados da Conta
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Nome Completo
                                        </label>
                                        <input type="text"
                                               class="form-control"
                                               name="name"
                                               value="{{ old('name') }}"
                                               required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            E-mail
                                        </label>
                                        <input type="email"
                                               class="form-control"
                                               name="email"
                                               value="{{ old('email') }}"
                                               required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Senha Inicial
                                        </label>

                                        <input type="password"
                                               class="form-control"
                                               name="password"
                                               required
                                               minlength="8">
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-bold">
                                            Confirmar Senha
                                        </label>
                                        <input type="password"
                                               class="form-control"
                                               name="password_confirmation"
                                               required>
                                    </div>
                                </div>
                            </div>

                            {{-- DADOS ACADÊMICOS --}}
                            <div class="card shadow-sm border-0 mb-4">
                                <div class="card-body p-4">
                                    <h4 class="card-title mb-4">
                                        Dados Acadêmicos
                                    </h4>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Instituição
                                        </label>
                                        <input type="text"
                                               class="form-control"
                                               name="instituicao"
                                               value="{{ old('instituicao') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            ORCID
                                        </label>
                                        <input type="text"
                                               class="form-control"
                                               name="orcid"
                                               value="{{ old('orcid') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">
                                            Currículo Lattes
                                        </label>
                                        <input type="url"
                                               class="form-control"
                                               name="lattes_url"
                                               value="{{ old('lattes_url') }}">
                                    </div>

                                    <div class="mb-0">
                                        <label class="form-label fw-bold">
                                            Titulação
                                        </label>
                                        <select class="form-select"
                                                name="titulacao">

                                            <option value="">
                                                Selecione
                                            </option>

                                            @foreach(['Especialista', 'Mestre', 'Doutor', 'Pós-Doutor'] as $titulo)
                                                <option value="{{ $titulo }}"
                                                    {{ old('titulacao') == $titulo ? 'selected' : '' }}>
                                                    {{ $titulo }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- COLUNA DIREITA --}}
                        <div class="col-lg-4">

                            {{-- PERFIL --}}
                            <div class="card shadow-sm border-0 mb-4 bg-primary text-white">
                                <div class="card-body p-4">
                                    <h4 class="card-title mb-4 border-bottom border-light pb-2">
                                        Perfil do Usuário
                                    </h4>
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">
                                            Tipo de Perfil
                                        </label>

                                        <select class="form-select"
                                                name="perfil"
                                                required>
                                            <option value="">
                                                Selecione
                                            </option>

                                            <option value="autor"
                                                {{ old('perfil') == 'autor' ? 'selected' : '' }}>
                                                Autor
                                            </option>

                                            <option value="revisor"
                                                {{ old('perfil') == 'revisor' ? 'selected' : '' }}>
                                                Revisor
                                            </option>

                                            <option value="leitor"
                                                {{ old('perfil') == 'leitor' ? 'selected' : '' }}>
                                                Leitor
                                            </option>
                                        </select>
                                    </div>

                                    {{-- ROLES ADMIN/EDITOR --}}
                                    <div class="mb-4">
                                        <h6 class="text-uppercase text-white-50 mb-3">
                                            Permissões Administrativas
                                        </h6>
                                        <div class="d-flex flex-column gap-2">

                                            {{-- ADMIN --}}
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="roles[]"
                                                       value="admin"
                                                       id="roleAdmin"
                                                    {{ in_array('admin', old('roles', [])) ? 'checked' : '' }}>

                                                <label class="form-check-label"
                                                       for="roleAdmin">
                                                    Administrador
                                                </label>
                                            </div>

                                            {{-- EDITOR --}}
                                            <div class="form-check">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="roles[]"
                                                       value="editor"
                                                       id="roleEditor"
                                                    {{ in_array('editor', old('roles', [])) ? 'checked' : '' }}>

                                                <label class="form-check-label"
                                                       for="roleEditor">
                                                    Editor
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- BOTÃO --}}
                                    <div class="d-grid mt-4">
                                        <button type="submit"
                                                class="btn btn-light fw-bold text-primary">
                                            <i class="fas fa-user-plus me-2"></i>
                                            Cadastrar Usuário
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>
</html>