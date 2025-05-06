<?php

use Illuminate\Support\Facades\DB;
?>

@extends('layouts.app')
@section('content')

<div class="container pt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <h3 class="text-center">Edição das informações do Editor</h3>
                <form action="{{ route('alterar_editor', $editor->id) }}" method="POST">

                    @csrf
                    <div class="form-group mb-2">
                        <label for="">Nome</label><br>
                        <input type="text" id="nome" name="nome" class="form-control" value="{{ $editor->user->name }}"><br>
                        <p style="color: red" id="erroNome";>@error('nome') {{$message}} @enderror<p>
                        <label for="">Email</label><br>
                        <input type="email" id="email" name="email" class="form-control" disabled value="{{ $editor->user->email }}"><br>
                        <label for="">Telefone</label> <br />
                        <input type="tel" id="telefone" class="form-control" name="telefone" value="{{ $editor->user->telefone }}"> <br />
                        Exemplo: 5551999999999
                        <p style="color: red" ;>@error('telefone') {{$message}} @enderror<p>
                        <label for="">Endereco</label><br>
                        <input type="text" id="endereco" name="endereco" class="form-control" value="{{ $editor->user->endereco }}"><br>
                        <p style="color: red" ;>@error('endereco') {{$message}} @enderror<p>
                        <label for="">País de origem<span id="obrigatorio">*</span></label> <br />
                        <select class="form-control" name="pais_id" id="paises" value="{{ $editor->user->pais_id}}"> <br />
                            <option value="" disabled>-</option>
                            <?php
                            $paises = DB::table('paises')->get();
                            foreach ($paises as $p) {
                                echo '<option value=' . $p->id . '>' . $p->nomePais . '</option>';
                            }
                            ?>
                        </select>
                        <label for="">Especialidade<span id="obrigatorio">*</span></label> <br />
                        <select class="form-control" name="especialidade" value="{{ $editor->pais_id}}"> <br />
                            <option value="" disabled>-</option>
                            <?php
                            $areas = DB::table('areas')->get();
                            foreach ($areas as $a) {
                                echo '<option value=' . $a->id . '>' . $a->descricaoArea . '</option>';
                            }
                            ?>
                        </select>
                        <label for="">Data de Contratação</label><br>
                        <input disabled type="date" name="dataContratacao" class="form-control" value="{{ $editor->dataContratacao }}"><br>
                        <button type="submit" id="salvar" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<x-footer />
@endsection
