<?php
    use Illuminate\Support\Facades\DB;
?>
@extends('layouts.app')
@section('content')

<div class="container mt-3" >
        <h3>Gerenciamento de Avaliadores</h3>
        <hr>
        <div class="pagination justify-content-center" style="color: black;">
            {{ $avaliador->links("pagination::bootstrap-4") }}
        </div>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <th scope="col">Id</th>
                <th scope="col">Nome</th>
                <th scope="col">Endereço</th>
                <th scope="col">Email</th>
                <th scope="col">Telefone</th>
                <th scope="col">Área de Preferência</th>
                <th class="table-borderless" scope="col">Editar</th>
                <th class="table-borderless" scope="col">Excluir</th>
            </thead>
            <tbody>
                @foreach($avaliador as $avaliador)
                <tr scope="row">

                    <td>{{ $avaliador->id }}</td>
                    <td>{{ $avaliador->user->name }}</td>
                    <td>{{ $avaliador->user->endereco }}</td>
                    <td>{{ $avaliador->user->email }}</td>
                    <td>{{ $avaliador->user->telefone }}</td>
                    <td>{{ $avaliador->area->descricaoArea }}</td>
                    <!-- <td>{{ $avaliador->pais_origem }}</td>
                    <td>{{ $avaliador->area_pref }}</td> -->

                    <td class="text-center">
                        <a class="btn btn-primary" id="editarAvaliador" href="{{ route('editarAvaliador', $avaliador->id) }}">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-danger" id="removerAvaliador" data-bs-toggle="modal" data-bs-target="#del-modal">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
                <!-- Modal -->
                <div class="modal fade" id="del-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Deseja mesmo deletar esse Avaliador?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{ $avaliador->user->name }}  <!-- SE TIVER PROBLEMAS COMENTAR ESSA LINHA -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" >
                                <a href="{{ route('deletarAvaliador', $avaliador->id) }}" style="color: white;text-decoration: none;">
                                Sim
                                </a>
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                        </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-footer/>
</div>
@endsection


