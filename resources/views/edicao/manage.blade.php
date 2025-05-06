<?php

use Illuminate\Support\Facades\DB;
?>
<!-- Scripts -->
<script src="{{ asset('js/search.js') }}" defer></script>

<!-- Styles -->
<link href="{{ asset('css/select.css') }}" rel="stylesheet" type="text/css">
@extends('layouts.app')

@section('content')
<?php $periodos_de_chamado = ""; ?>
<div class="container mt-3">
    @if(session()->has('success_msg'))
    <div class="container w-50 mt-3">
        <div class="alert alert-success text-center">
            {{ session()->get('success_msg') }}
        </div>
    </div>
    @endif
    <h3>Edições da revista: {{$revista->tituloRevista}}</h3>
    <hr>
    <div class="pagination justify-content-center" style="color: black;">
        {{ $edicoes->links("pagination::bootstrap-4") }}
    </div>
    <div class="container" style="margin-bottom: 100px;">
        <table style="transition:none !important;" class="table table-borderless table-hover">
            <thead class="table-dark">
                <th scope="col">Número da Edicao</th>
                <th scope="col">Título da edição</th>
                <th scope="col">Artigos</th>
            </thead>
            <tbody>
                @foreach($edicoes as $edicao)
                @if($edicao->revista_id == $revista->id)
                <tr scope="row">
                    <td>{{ $edicao->id }}</td>
                    <td>{{ $edicao->titulo }}</td>
                    <td class="col col-3">

                        <?php
                        $artigos = DB::table('artigos')->where('edicao_id', $edicao->id)->get();
                        ?>
                        @foreach($artigos as $artigo)
                        <a target="_blank" href="{{ asset('storage/' . $artigo->caminhoArtigo); }}">
                            <small>
                                <p class="articles mb-1 text-center p-1">{{ $artigo->tituloArtigo }}</br></p>
                            </small>
                        </a>
                        @endforeach
                    </td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>

    </div>
    <x-footer />
</div>
@endsection