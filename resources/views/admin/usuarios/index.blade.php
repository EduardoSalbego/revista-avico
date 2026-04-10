<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<body id="page-top">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gerenciar Usuários</h2>
            <a href="{{ route('usuarios.create') }}" class="btn btn-success">+ Novo Usuário</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Role</th>
                            <th>Data de Cadastro</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($user->role == 'colaborador')
                                        <span class="badge bg-primary">Colaborador</span>
                                    @else
                                        <span class="badge bg-secondary">Leitor</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('usuarios.edit', $user->id) }}"
                                        class="btn btn-sm btn-outline-primary">Editar</a>

                                    <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>