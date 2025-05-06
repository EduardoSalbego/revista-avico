<?php
    use Illuminate\Support\Facades\DB;
?>

@extends('layouts.app')
@section('content')

<div class="container pt-5" >
    <div  class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <h3 class="text-center">Edição das informações do Avaliador</h3>
                <form action="{{ route('editarAvaliador', $avaliador->id) }}" method="POST">
        @csrf
        <div class="form-group mb-2">
        <label for="">Nome<span id="obrigatorio">*</span></label><br>
        <input type="text" id="nome" name="nome" class="form-control" value="{{ $avaliador->user->name }}"><br>
        <p style="color: red" id="erroNome";>@error('nome') {{$message}} @enderror<p>
        <label for="">Email<span id="obrigatorio">*</span></label><br>
        <input type="email" id="email" name="email" class="form-control" disabled value="{{ $avaliador->user->email }}"><br>
        <p style="color: red";>@error('email') {{$message}} @enderror<p>
        <label for="">Endereço<span id="obrigatorio">*</span></label><br>
        <input type="text" id="endereco" name="endereco" class="form-control" value="{{ $avaliador->user->endereco }}"><br>
        <p style="color: red";>@error('endereco') {{$message}} @enderror<p>
        <label for="" >Telefone<span id="obrigatorio">*</span></label><br>
        <input type="number" id="telefone" name="telefone" class="form-control" value="{{ $avaliador->user->telefone }}"><br>
        Exemplo: 5551999999999
        <p style="color: red";>@error('telefone') {{$message}} @enderror<p>
        <label for="">País de origem<span id="obrigatorio">*</span></label> <br />
            <select class="form-control" name="pais_origem" id="paises" value="{{ $avaliador->user->pais_origem }}"> <br />
            <option value="" disabled>-</option>
            <?php
                            $paises = DB::table('paises')->get();
                            foreach ($paises as $p) {
                                echo '<option value=' . $p->id . '>' . $p->nomePais . '</option>';
                            }
                            ?>
            </select>
        </div>
        <p style="color: red";>@error('pais_origem') {{$message}} @enderror<p>
        <label for="">Área de interesse<span id="obrigatorio">*</span></label> <br />
            <select class="from-control" name="area_pref" id="areasPref" value = " {{ $avaliador->area->descricaoArea }}"  style="border: 2px solid gray;">
            <option value="" disabled>-</option>
            <?php
                            $areas = DB::table('areas')->get();
                            foreach ($areas as $a) {
                                echo '<option value=' . $a->id . '>' . $a->descricaoArea . '</option>';
                            }
                            ?>
            </select>
        <div>
        <p style="color: red";>@error('area_pref') {{$message}} @enderror<p>
        <button type="submit" id="salvar" class="btn btn-primary">Salvar</button>
    </form>
            </div>
        </div>
    </div>
</div>

@endsection
