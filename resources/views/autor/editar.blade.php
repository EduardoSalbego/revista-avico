<?php use Illuminate\Support\Facades\DB; ?>
@extends('layouts.app')
@section('content')
<div class="container pt-5" >
    <div  class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <h3 class="text-center">Edição de autor</h3>
                <form action="{{ route('edit.autor', $autor->orcid) }}" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Nome</label><span id="obrigatorio">*</span><br>
                        <input type="text" name="nome" id="nome" class="form-control" value="{{ $autor->user->name }}" required><br>
                        <p style="color: red" id="erroNome" ;>@error('nome') {{$message}} @enderror<p>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Email</label><span id="obrigatorio">*</span><br>
                        <input type="email" name="email" id="email" class="form-control" disabled value="{{ $autor->user->email }}" required><br>
                        <p style="color: red" ;>@error('email') {{$message}} @enderror<p>
                    </div>
                    <!-- <div class="form-group mb-2">
                        <label for="" class="ms-3">Senha</label><span id="obrigatorio">*</span><br>
                        <input type="password" name="password" value="{{ $autor->password }}" disabled class="form-control"><br>
                    </div> -->
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Endereço</label><br>
                        <input type="text" name="endereco" id="endereco" value="{{ $autor->user->endereco }}" class="form-control"><br>
                        <p style="color: red" ;>@error('endereco') {{$message}} @enderror<p>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Telefone</label><br>
                        <input type="text" name="telefone" id="telefone" value="{{ $autor->user->telefone }}" class="form-control"><br>
                        Exemplo: 5551999999999
                        <p style="color: red" ;>@error('telefone') {{$message}} @enderror<p>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="ms-3 mb-1">Área de preferência<span id="obrigatorio">*</span></label>
                        @error('area_pref') {{$message}} @enderror
                        <select class="form-control mb-2" name="area_pref" id="area">
                            <option value="{{ $autor->area->descricaoArea }}" disabled>{{ $autor->area->descricaoArea }}</option>
                            <?php
                            $areas = DB::table('areas')->get();
                            foreach ($areas as $a) {
                                echo '<option value=' . $a->id . '>' . $a->descricaoArea . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Instituição</label><br>
                        <p style="color: red" ;>@error('instituicao') {{$message}} @enderror<p>
                        <input type="text" name="instituicao" id="instituicao" value="{{ $autor->instituicao }}" class="form-control"><br>                        
                    </div>
                    <div class="form-group mb-2 col-5 me-5">
                        <label for="">País de origem<span id="obrigatorio">*</span></label> <br />
                        <p style="color: red" ;>@error('pais_origem') {{$message}} @enderror<p>
                        <select class="form-control" name="pais_origem" id="paises"> <br />
                            <option value="" disabled>-</option>
                            <?php
                            $paises = DB::table('paises')->get();
                            foreach ($paises as $p) {
                                echo '<option value=' . $p->id . '>' . $p->nomePais . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row mb-5">
                        <div class="col form-group pt-2 align-center text-center mb-5">
                            <input type="submit" name="submit" id="salvar" class="btn btn-success btn-md col-6" style="color:white;" value="Salvar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<x-footer/>
@endsection