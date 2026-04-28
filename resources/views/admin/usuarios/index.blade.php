<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<body id="page-top">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gerenciar Usuários</h2>
            <a href="{{ route('admin.usuarios.create') }}" class="btn btn-success">+ Novo Usuário</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Seção de contas pendentes (só aparece se houver) --}}
        @if($pendentes->isNotEmpty())
            <div class="card border-warning shadow-sm mb-5">
                <div class="card-header bg-warning text-dark fw-bold">
                    ⏳ Contas Aguardando Aprovação ({{ $pendentes->count() }})
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Perfil</th>
                                <th>Cadastro</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendentes as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{!! $user->role_badge_html !!}</td>
                                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        {{-- Aprovar --}}
                                        <form action="{{ route('admin.usuarios.aprovar', $user->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success">
                                                ✅ Aprovar
                                            </button>
                                        </form>

                                        {{-- Rejeitar (exclui o usuário) --}}
                                        <form action="{{ route('admin.usuarios.destroy', $user->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Rejeitar e excluir esta conta?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                ❌ Rejeitar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Tabela de usuários ativos --}}
        <div class="card shadow-sm">
            <div class="card-header fw-bold bg-light">
                Usuários Ativos
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Perfil</th>
                            <th>Cadastro</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{!! $user->role_badge_html !!}</td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.usuarios.edit', $user->id) }}"
                                        class="btn btn-sm btn-outline-primary">Editar</a>

                                    <form action="{{ route('admin.usuarios.destroy', $user->id) }}" method="POST"
                                        class="d-inline"
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

                <div class="p-3">
                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>