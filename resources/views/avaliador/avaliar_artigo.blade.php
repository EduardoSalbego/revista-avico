<?php use Illuminate\Support\Facades\DB; ?>
@extends('layouts.app')
@section('content')
    <div class="container pt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="col-md-12">
                    <h3 class="text-center">Avaliar Artigo</h3>
                    <form action="{{ route('avaliar.artigo', $artigo->id) }}" method="POST">
                        @csrf

                        @if (Session::has('message'))
                            <p style="color:green;">{{ Session::get('message') }}
                            </p>
                        @endif

                        <?php $situa = DB::table('situacao')
                            ->where('id', $artigo->situacao_id)
                            ->first(); ?>


                        <div class="form-group mb-2">
                            <label for="" class="ms-3">Título</label><br>
                            <input type="text" name="titulo" class="form-control" value="{{ $artigo->tituloArtigo }}"
                                disabled><br>
                        </div>
                        <div class="form-group mb-2">
                            <a target="_blank" href="{{ $artigo->caminhoArtigo }}">
                                <small>
                                    <p class="articles mb-1 text-center p-1">{{ $artigo->tituloArtigo }}</br></p>
                                </small>
                            </a>
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="ms-1">Status</label><br>
                            <input type="text" name="descricaoSituacao" class="form-control" disabled
                                value="{{ $situa->descricaoSituacao }}"><br>
                        </div>

                        <div class="form-group mb-2">
                            <label for="" class="ms-3">Nota</label><br>
                            <input type="number" name="nota" class="form-control"><br>
                            <small>A nota deve ser de 1 até 10</small>
                            <p style="color: red" ;>@error('nota') {{ $message }} @enderror
                            </p>
                        </div>


                        <div class="form-group mb-2">
                            <label for="" class="ms-3">Comentários</label><br>
                            <textarea name="comentarios" placeholder="Escreva seus comentários aqui" class="form-control"
                                rows="10" cols="35" maxlength="300"></textarea>
                        </div>
                        <div class="row mb-5">
                            <div class="col form-group pt-2 align-center text-center mb-5">
                                <input type="submit" name="submit" class="btn btn-success btn-md col-6" style="color:white;"
                                    value="Salvar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-footer />
@endsection
