@extends('layouts.app')

<?php
use Illuminate\Support\Facades\DB;
?>

@extends('layouts.app')

@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="col-md-12">
                    <h3 class="text-center">Atribuição de Avaliações para Avaliadores</h3>
                    <hr>
                    <div class="pagination justify-content-center" style="color: black;">
                        {{ $avaliadores->links('pagination::bootstrap-4') }}
                    </div>

                    @if (Session::has('message'))
                        <p style="color: green;" class="">{{ Session::get('message') }}</p>
                    @elseif (Session::has('error'))
                    <p style="color:red;">{{ Session::get('error') }}
                    </p>
                    @endif

                    @if (Session::has('fail_msg'))
                    <p style="color: red;" class="">{{ Session::get('fail_msg') }}</p>
                    @endif


                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <th scope="col">Avaliador</th>
                                <th scope="col">Área de preferência</th>
                                <th scope="col">Atribuir Artigo</th>
                            </thead>
                            <tr scope="row" class="align-middle">
                                <tbody>
                                    @foreach ($avaliadores as $avaliador)
                                        <tr scope="row">
                                            <td>{{ $avaliador->user->name }}</td>
                                            <td>{{ $avaliador->area->descricaoArea }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-primary" id="artigos-modal" value="{{ $avaliador->id }}"
                                                    data-bs-toggle="modal" data-bs-target="#artigos-{{ $avaliador->id }}">
                                                    <i class="fa fa-address-book" aria-hidden="true"></i>
                                                </a>

                                                <!-- Modal -->
                                                <div class="modal fade" id="artigos-{{ $avaliador->id }}" tabindex="-1"
                                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Artigos
                                                                    disponíveis</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form
                                                                action="{{ route('atribuir.avaliacao', $avaliador->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                <select name="artigo" id="artigo">
                                                                    <?php

                                                                    $artigos = DB::table('artigos')->get();
                                                                    foreach ($artigos as $artigo) {
                                                                        echo '<option value=' . $artigo->id . '>' . $artigo->tituloArtigo . '</option>';
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <input name="id" value="{{ $avaliador->id }}" type="text" style="display: none;">
                                                                <div class="col form-group">
                                                                    <input type="submit" id="salvar"
                                                                        class="btn btn-success btn-md col-6"
                                                                        style="color:white;" value="Salvar">
                                                                </div>
                                                                <br>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
@endsection
