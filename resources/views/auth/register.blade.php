<?php

use Illuminate\Support\Facades\DB;
?>

@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-10">
                <div class="card-header">{{ __('Registrar Usuário') }}</div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="ms-3 col-md-4 col-form-label text-md-right">{{ __('Name') }}<span id="obrigatorio">*</span> </label>

                        <div class="">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label for="email" class="ms-3 col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}<span id="obrigatorio">*</span></label>

                        <div class="">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col form-group mt-2">
                            <label for="password" class="ms-3 col-form-label text-md-right">{{ __('Password') }}<span id="obrigatorio">*</span></label>

                            <div class="">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                A senha deve conter no mínimo 8 caracteres
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col form-group mt-2">
                            <label for="password-confirm" class="ms-3 col-form-label text-md-right">{{ __('Confirm Password') }}<span id="obrigatorio">*</span></label>

                            <div class="">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="off">
                            </div>
                        </div>
                    </div>


                    <input type="text" name="role" id="role" class="form-control" hidden>

                    <div class="card-header mt-5 mb-3 d-flex justify-content-between">
                        <div class="btn-group">
                            <span>Escolha um tipo de usuário<span id="obrigatorio">*</span>&nbsp;&nbsp;</span>
                            <button class="btn btn-dark btn-sm dropdown-toggle" id="btnUsuario" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" onclick="select(this.id)" data-bs-toggle="collapse" data-bs-target="#" id="avaliador">Avaliador</a></li>
                                <li><a class="dropdown-item" onclick="select(this.id)" id="autor">Autor</a></li>
                                <li><a class="dropdown-item" onclick="select(this.id)" id="editor">Editor</a></li>
                            </ul>
                        </div>
                        {{ __('Dados Pessoais') }}

                    </div>
                    <!-- AUTOR -->
                    <div class="form-group mb-2 mt-4" hidden="true" id="autor_modal">
                        <label for="orcid" class="ms-3 mb-1">ORCID<span id="obrigatorio">*</span></label>
                        <input type="text" maxlength="12" name="orcid" id="orcid" class="form-control mb-2">

                        <label for="" class="ms-3 mb-1">Instituição</label>
                        @error('instituicao') {{$message}} @enderror
                        <input type="text" name="instituicao" id="instituicao" class="form-control mb-2">

                        <label for="" class="ms-3 mb-1">Área de preferência<span id="obrigatorio">*</span></label>
                        @error('area_pref') {{$message}} @enderror
                        <select class="form-control mb-2" name="area_pref" id="area">
                            <option value="" disabled>-</option>
                            <?php
                            $areas = DB::table('areas')->get();
                            foreach ($areas as $a) {
                                echo '<option value=' . $a->id . '>' . $a->descricaoArea . '</option>';
                            }
                            ?>
                        </select>

                    </div>
                    <!-- FIM AUTOR -->

                    <!-- EDITOR -->
                    <div class="form-group mt-4" hidden="true" id="editor_modal">
                        <label for="" class="ms-3 mb-1">Área de preferência<span id="obrigatorio">*</span></label> <br />
                        <select class="form-control" name="especialidade" id="area"> <br />
                            <option value="" disabled>-</option>
                            <?php
                            $areas = DB::table('areas')->get();
                            foreach ($areas as $a) {
                                echo '<option value=' . $a->id . '>' . $a->descricaoArea . '</option>';
                            }
                            ?>
                            <p style="color: red" ;>@error('area_pref') {{$message}} @enderror
                        </select>

                        <label for="" class="ms-3 mb-1 mt-2">Data de Contratação<span id="obrigatorio">*</span></label> <br />
                        <input type="date" class="form-control mb-0" placeholder="2001/06/01" name="dataContratacao">
                        <p style="color: red" ;>@error('dataContratacao') {{$message}} @enderror
                    </div>
                    <!-- FIM EDITOR -->

                    <!--AVALIADOR INICIO -->
                    <div class="form-group mt-4" hidden="true" id="avaliador_modal">
                        <label for="" class="ms-3 mb-1">Área de preferência<span id="obrigatorio">*</span></label> <br />
                        <select class="form-control" name="especialidade" id="area"> <br />
                            <option value="" disabled>-</option>
                            <?php
                            $areas = DB::table('areas')->get();
                            foreach ($areas as $a) {
                                echo '<option value=' . $a->id . '>' . $a->descricaoArea . '</option>';
                            }
                            ?>
                            <p style="color: red" ;>@error('area_pref') {{$message}} @enderror
                        </select>
                    </div>
                    <!-- FIM AVALIADOR -->

                    <div class="form-group">
                        <label for="endereco" class="ms-3 mb-1">Endereço<span id="obrigatorio">*</span></label><br>
                        <input type="address" name="endereco" id="endereco" class="form-control" required>
                    </div>
                    <p style="color: red" ;>@error('endereco') {{$message}} @enderror

                    <div class="form-group">
                        <label class="ms-3 mb-1" for="">País de origem<span id="obrigatorio">*</span></label> <br />
                        <select class="form-control" name="pais_id" id="pais"> <br />
                            <option value="" disabled>-</option>
                            <?php
                            $paises = DB::table('paises')->get();
                            foreach ($paises as $p) {
                                echo '<option value=' . $p->id . '>' . $p->nomePais . '</option>';
                            }
                            ?>
                        </select>
                        <p style="color: red" ;>@error('pais') {{$message}} @enderror
                    </div>

                    <div class="form-group ">
                        <label class="ms-3 mb-1" for="">Telefone<span id="obrigatorio">*</span></label> <br />
                        <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Ex.: 5551999999999"> <br />
                        <p style="color: red">@error('telefone') {{$message}} @enderror
                    </div>

                    <div class="form-group row mb-5 mt-4">
                        <div class="col-3 form-group pt-2">
                            <input type="submit" name="submit" id="btnRegister" class="btn btn-success btn-md" style="color:white;" value="Register">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function select(role) {
        var x = document.getElementById('role').value = role;

        var autor = document.getElementById('autor_modal');
        var editor = document.getElementById('editor_modal');
        var avaliador = document.getElementById('avaliador_modal');


        document.getElementById(role + '_modal').hidden = false;
        document.getElementById(role + '_modal').required = true;
        document.getElementById(role + '_modal').disabled = false;


        switch (role) {
            case 'autor':
                disable(editor);
                disable(avaliador);
                break;
            case 'editor':
                disable(autor);
                disable(avaliador)
                break;
            case 'avaliador':
                disable(autor);
                disable(editor);
        }

    }

    function disable(modal) {
        modal.setAttribute('hidden', 'true');
        modal.setAttribute('required', 'false');
        modal.setAttribute('disabled', 'true');
    }
</script>


@endsection
