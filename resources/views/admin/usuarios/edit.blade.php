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
                            Editar Usuário
                        </h2>

                        <p class="text-muted mb-0">
                            Gerencie dados, funções e permissões de
                            <strong>{{ $usuario->name }}</strong>
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

                <form action="{{ route('admin.usuarios.update', $usuario->id) }}"
                      method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        {{-- COLUNA ESQUERDA --}}
                        <div class="col-lg-8">

                            {{-- DADOS GERAIS --}}
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
                                               value="{{ old('name', $usuario->name) }}"
                                               required>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold">
                                            E-mail
                                        </label>

                                        <input type="email"
                                               class="form-control"
                                               name="email"
                                               value="{{ old('email', $usuario->email) }}"
                                               required>
                                    </div>

                                    <hr class="mb-4">
                                    <h5 class="mb-3">
                                        Segurança
                                    </h5>

                                    <div class="mb-2">
                                        <label class="form-label fw-bold text-danger">
                                            Nova Senha
                                        </label>

                                        <input type="password"
                                               class="form-control border-danger"
                                               name="password"
                                               minlength="8">

                                        <div class="form-text">
                                            Deixe em branco para manter a senha atual.
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- DADOS ACADÊMICOS --}}
                            @if($usuario->autor || $usuario->revisor)
                                @php
                                    $perfilAcademico = $usuario->revisor ?? $usuario->autor;
                                @endphp

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
                                                   value="{{ old('instituicao', $perfilAcademico->instituicao) }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                ORCID
                                            </label>

                                            <input type="text"
                                                   class="form-control"
                                                   name="orcid"
                                                   value="{{ old('orcid', $perfilAcademico->orcid) }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">
                                                Currículo Lattes
                                            </label>

                                            <input type="url"
                                                   class="form-control"
                                                   name="lattes_url"
                                                   value="{{ old('lattes_url', $perfilAcademico->lattes_url) }}">
                                        </div>

                                        @if($usuario->revisor)
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
                                                            {{ old('titulacao', $usuario->revisor->titulacao) == $titulo ? 'selected' : '' }}>
                                                            {{ $titulo }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- COLUNA DIREITA --}}
                        <div class="col-lg-4">

                            {{-- FUNÇÕES --}}
                            <div class="card shadow-sm border-0 mb-4 bg-primary text-white">
                                <div class="card-body p-4">
                                    <h4 class="card-title mb-4 border-bottom border-light pb-2">
                                        Funções e Permissões
                                    </h4>

                                    {{-- ROLES --}}
                                    <div class="mb-4">
                                        <h6 class="text-uppercase text-white-50 mb-3">
                                            Roles do Sistema
                                        </h6>

                                        <div class="d-flex flex-column gap-2">
                                            <div class="d-flex flex-column gap-2">

                                                {{-- ADMIN --}}
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                        type="checkbox"
                                                        name="roles[]"
                                                        value="admin"
                                                        id="roleAdmin"
                                                        {{ $usuario->isAdmin() ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="roleAdmin">
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
                                                        {{ $usuario->isEditor() ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="roleEditor">
                                                        Editor
                                                    </label>
                                                </div>

                                                {{-- AUTOR --}}
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                        type="checkbox"
                                                        name="roles[]"
                                                        value="autor"
                                                        id="roleAutor"
                                                        {{ $usuario->isAutor() ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="roleAutor">
                                                        Autor
                                                    </label>
                                                </div>

                                                {{-- REVISOR --}}
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                        type="checkbox"
                                                        name="roles[]"
                                                        value="revisor"
                                                        id="roleRevisor"
                                                        {{ $usuario->isRevisor() ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="roleRevisor">
                                                        Revisor
                                                    </label>
                                                </div>

                                                {{-- LEITOR --}}
                                                <div class="form-check">
                                                    <input class="form-check-input"
                                                        type="checkbox"
                                                        name="roles[]"
                                                        value="leitor"
                                                        id="roleLeitor"
                                                        {{ $usuario->isLeitor() ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="roleLeitor">
                                                        Leitor
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- PERFIS --}}
                                    <div class="mb-4">

                                        <h6 class="text-uppercase text-white-50 mb-3">
                                            Perfis Acadêmicos
                                        </h6>

                                        <div class="d-flex flex-wrap gap-2">

                                            @if($usuario->autor)
                                                <span class="badge bg-success fs-6">
                                                    <i class="fas fa-pen-nib me-1"></i>
                                                    Autor
                                                </span>
                                            @endif

                                            @if($usuario->revisor)
                                                <span class="badge bg-info text-dark fs-6">
                                                    <i class="fas fa-search me-1"></i>
                                                    Revisor
                                                </span>
                                            @endif

                                            @if($usuario->leitor)
                                                <span class="badge bg-secondary fs-6">
                                                    <i class="fas fa-book-open me-1"></i>
                                                    Leitor
                                                </span>
                                            @endif

                                        </div>

                                    </div>

                                    {{-- STATUS REVISOR --}}
                                    @if($usuario->revisor)

                                        <div class="mb-4">
                                            <h6 class="text-uppercase text-white-50 mb-2">
                                                Status do Revisor
                                            </h6>

                                            <select class="form-select"
                                                    name="status_revisor">

                                                <option value="pendente"
                                                    {{ $usuario->revisor->status == 'pendente' ? 'selected' : '' }}>
                                                    Pendente
                                                </option>

                                                <option value="aprovado"
                                                    {{ $usuario->revisor->status == 'aprovado' ? 'selected' : '' }}>
                                                    Aprovado
                                                </option>

                                                <option value="rejeitado"
                                                    {{ $usuario->revisor->status == 'rejeitado' ? 'selected' : '' }}>
                                                    Rejeitado
                                                </option>
                                            </select>
                                        </div>
                                    @endif

                                    {{-- BOTÃO --}}
                                    <div class="d-grid mt-4">

                                        <button type="submit"
                                                class="btn btn-light fw-bold text-primary">

                                            <i class="fas fa-save me-2"></i>
                                            Salvar Alterações

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