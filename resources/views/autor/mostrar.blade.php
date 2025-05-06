@extends('layouts.app')
@section('content')
<div class="container pt-5" >
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <label for="" class="ms-3">Nome</label><br>
                <input type="text" name="nome" value="{{ $autor->nome }}" class="form-control"><br>
                <label for="" class="ms-3">Email</label><br>
                <input type="email" name="email" value="{{ $autor->email }}" class="form-control"><br>
                <label for="" class="ms-3">Endereço</label><br>
                <input type="text" name="endereco" value="{{ $autor->endereco }}" class="form-control"><br>
                <label for="" class="ms-3">Telefone</label><br>
                <input type="number" name="telefone" value="{{ $autor->telefone }}" class="form-control"><br>
            </div>
        </div>
    </div>
</div>

<x-footer/>
@endsection