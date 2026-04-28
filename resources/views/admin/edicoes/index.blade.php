<!DOCTYPE html>
<html lang="pt-br">
@include('layouts.head')

<body id="page-top" class="bg-light">
    @include('layouts.topbar')

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Gerenciar Edições</h2>
            <a href="{{ route('edicoes.create') }}" class="btn btn-success">+ Nova Edição</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Capa</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Capítulos</th>
                            <th>Status</th>
                            <th>Data de Publicação</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($edicoes as $edicao)
                            <tr>
                                <td>#{{ $edicao->id }}</td>
                                <td>
                                    <img src="{{ asset($edicao->imagem_capa) }}" alt="Capa"
                                        style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px;">
                                </td>
                                <td style="max-width: 250px;" class="text-truncate" title="{{ $edicao->titulo }}">
                                    {{ $edicao->titulo }}
                                </td>
                                <td>{{ $edicao->autor }}</td>
                                <td>ㅤㅤ{{ $edicao->capitulos()->count() }}</td>
                                <td>{!! $edicao->getStatusBadgeHtmlAttribute() !!}</td>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($edicao->created_at)->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('edicoes.show', $edicao->id) }}" target="_blank"
                                        class="btn btn-sm btn-outline-secondary" title="Visualizar">
                                        Ver
                                    </a>

                                    <a href="{{ route('admin.edicoes.edit', $edicao->id) }}" target="_blank"
                                        class="btn btn-sm btn-outline-secondary" title="Editar">
                                        Editar
                                    </a>

                                    <form action="{{ route('admin.edicoes.destroy', $edicao->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('ATENÇÃO: Tem certeza que deseja excluir a edição #{{ $edicao->id }}? Esta ação não pode ser desfeita.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            title="Excluir">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Nenhuma edição publicada ainda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $edicoes->links() }}
                </div>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>