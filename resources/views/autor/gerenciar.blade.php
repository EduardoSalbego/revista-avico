@extends('layouts.app')
@section('content')
<div class="container mt-3">
    <h3>Gerenciamento de Autores</h3>
    <hr>
    <div class="container" style="margin-bottom: 100px;">
        <table class="table table-borderless table-hover">
            <thead class="table-dark">
                <th scope="col">Id</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Endereço</th>
                <th scope="col">Telefone</th>
                <th scope="col">Data de criação</th>
                <th scope="col">Data de atualização</th>
                <th class="" scope="col">Editar</th>
                <th class="" scope="col">Deletar</th>
            </thead>
            <tbody>
                @foreach($autor as $autor)
                <tr scope="row">
                    <td>{{ $autor->orcid }}</td>
                    <td>{{ $autor->user->name }}</td>
                    <td>{{ $autor->user->email }}</td>
                    <td>{{ $autor->user->endereco }}</td>
                    <td>{{ $autor->user->telefone }}</td>
                    <td>{{ $autor->created_at }}</td>
                    <td>{{ $autor->updated_at }}</td>
                    <td class="text-center">
                        <a class="btn btn-primary" id="editarAutor" href="{{ route('edicao_autor', $autor->orcid) }}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>            
                        </a>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-danger" id="removerAutor" data-bs-toggle="modal" data-bs-target="#del-modal-{{ $autor->orcid }}">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                    <!-- Modal -->
                    <div class="modal fade" id="del-modal-{{ $autor->orcid }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Deseja mesmo deletar esse usuário?</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                {{ $autor->orcid }} - {{ $autor->user->name }}  <!-- SE TIVER PROBLEMAS COMENTAR ESSA LINHA -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" >
                                    <a href="{{ route('exclusao_autor_modal', $autor->orcid) }}" style="color: white;text-decoration: none;">
                                    Sim
                                    </a>    
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>

    <x-footer/>
</div>
@endsection