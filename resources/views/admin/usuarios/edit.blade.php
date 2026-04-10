<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<body id="page-top" class="bg-light">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Editar Usuário: <span class="text-primary">{{ $usuario->name }}</span></h2>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Voltar para a Lista</a>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        {{-- O action aponta para o update passando o ID do usuário --}}
                        <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Nome Completo</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $usuario->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Endereço de E-mail</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $usuario->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="perfil" class="form-label fw-bold">Perfil de Acesso</label>
                                <select class="form-select" id="perfil" name="perfil" required>
                                    <option value="leitor" {{ (old('perfil', $usuario->perfil) == 'leitor') ? 'selected' : '' }}>Leitor</option>
                                    <option value="colaborador" {{ (old('perfil', $usuario->perfil) == 'colaborador') ? 'selected' : '' }}>Colaborador (Pode enviar textos)</option>
                                    <option value="admin" {{ (old('perfil', $usuario->perfil) == 'admin') ? 'selected' : '' }}>Administrador (Acesso total)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-bold text-danger">Nova Senha
                                    (Opcional)</label>
                                <input type="password" class="form-control border-danger" id="password" name="password"
                                    minlength="8">
                                <div class="form-text text-muted">Deixe em branco para não alterar a
                                    senha do usuário.</div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Atualizar Dados</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>