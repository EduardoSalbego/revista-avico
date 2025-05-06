@extends('layouts.app')
@section('content')
<div class="container pt-5" >
    <div  class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <form action="{{ route('cadastro_autor') }}" method="POST">
                    <h3 class="text-center">Cadastro de Autor</h3>

                    @csrf
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Nome</label><br>
                        <input type="text" name="nome" class="form-control" required><br>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Email</label><br>
                        <input type="email" name="email" class="form-control"><br>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Endereço</label><br>
                        <input type="text" name="endereco" class="form-control"><br>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Telefone</label><br>
                        <input type="number" name="telefone" class="form-control"><br>
                    </div>
                    
                    <div class="row">
                        <div class="col-3 form-group pt-2">
                            <input type="submit" name="submit" class="btn btn-success btn-md" style="color:white;" value="Cadastrar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<x-footer/>
@endsection