@extends('layouts.app')
@section('content')

<div class="container pt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <form action="{{ route('store.edicao', $revista->id) }}" class="form" method="POST">
                    @csrf
                    <h3 class="text-center">Cadastrar nova edição da revista {{$revista->tituloRevista}}</h3>
                    <div class="form-group ms-3 mb-2">Dê um título para a edição
                        <div class="ms-3 my-2">
                            <input type="text" class="form-control" name="titulo">
                        </div>
                    </div>
                    <div class="form-group ms-3 mb-2">Selecione os artigos que irão compor a revista
                        @forelse($arr as $artigo)
                        <div class="form-check ms-3 my-2">
                            <input class="form-check-input" type="checkbox" name="artigo[]" id="flexCheck{{$artigo}}" value="{{$artigo->id}}">
                            <label class="form-check-label" for="flexCheck{{$artigo}}">{{$artigo->tituloArtigo}} [Média: {{$notas[$loop->index]}}]</label>
                        </div>
                        @empty
                        <div class="container w-50 mt-3">
                            <div class="alert alert-danger text-center">
                                Não há artigos
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <div class="row">
                        <div class="col-3 form-group mt-2">
                            <input type="submit" name="submit" id="btnSubmit" class="btn btn-success btn-md" style="color:white;" value="Cadastrar nova edição">
                        </div>
                    </div>

                    @if(session()->has('no_articles_selected'))
                    <div class="container w-50 mt-3">
                        <div class="alert alert-danger text-center">
                            {{ session()->get('no_articles_selected') }}
                        </div>
                    </div>
                    @endif

                    @if(session()->has('fail_msg'))
                    <div class="container w-50 mt-3">
                        <div class="alert alert-danger text-center">
                            {{ session()->get('fail_msg') }}
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
<x-footer />

@endsection