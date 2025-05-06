<!-- Scripts -->
<script src="{{ asset('js/search.js') }}" defer></script>

<!-- Styles -->
<link href="{{ asset('css/select.css') }}" rel="stylesheet" type="text/css">
<?php

use Illuminate\Support\Facades\DB; ?>

@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <form class="form" action="{{ route('submit.artigo')}}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <h3 class="text-center">Submeter Artigos</h3>

                    <div class="form-group mb-2">
                        <label for="editor" class="ms-3">Revista<span id="obrigatorio">*</span></label><br>
                        <select class="form-control" name="revista_id" id="revista_id" onchange="updateOptions(this.value)"> <br />
                            <option value="" selected></option>
                            <?php
                            $revistas = DB::table('revistas')->get();
                            foreach ($revistas as $r) {
                                echo '<option value=' . $r->id . '>' . $r->tituloRevista . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="editor" class="ms-3">Período de Chamada<span id="obrigatorio">*</span> <small>(Data Inicio - Data Final)</small><br></label>
                        <select class="form-control" name="periodo_id" id="periodo_id">

                        </select>
                    </div>
                    <div class="form-group mb-2">

                        <label for="autores" class="ms-3" m>Autores<span id="obrigatorio">* <small>{!! session()->get('erro002') !!}</small></span></label><br>

                        <ul id="author" class="list-group list-group-horizontal"></ul>
                        <input autocomplete="off" type="text" id="autores" class="form-control mt-2" onkeyup="searchAuthor(this.value)">

                        <ul class="list-group ms-4 me-4 col col-11" id="autor"></ul>
                    </div>


                    <h6 class="text-center" id="obrigatorio"><small>{!! session()->get('erro001') !!}</small></h6>

                    <table id="artigos-table" style="transition:none !important;" class="table table-sm table-borderless">
                        <thead class="table-dark">
                            <th class="" scope="col">Artigo<span id="obrigatorio">* </span>
                            </th>
                            <th class="" scope="col">Título<span id="obrigatorio">*</span></th>
                            <th class="" scope="col">

                                <a type="button" class="btn btn-success btn-sm" onclick="add()">
                                    <i class="fa fa-plus fa-1x" style="transition:none !important;" aria-hidden="true"></i>
                                </a>
                            </th>
                            <th class="" scope="col">
                                <a class="btn btn-danger btn-sm" onclick="del()">
                                    <i class="fa fa-minus fa-1x" style="transition:none !important;" aria-hidden="true"></i>
                                </a>
                            </th>
                        </thead>
                        <tbody>
                            <tr scope="row">

                                <td><input name="artigo[]" style="border-style:none;" id="file" class="form-control form-control-sm" type="file" accept="application/pdf" required></td>
                                <td><input name="tituloArtigo[]" style="border-radius: 0% !important;
                                                  border-color: transparent !important;
                                                  border-bottom: solid 2px black !important;" id="tituloArtigo" class="form-control form-control-sm" type="text" required></td>
                                <td></td>
                                <td></td>
                            </tr>


                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-3 form-group pt-2">
                            <input type="submit" name="submit" id="Submit" class="btn btn-success btn-md" style="color:white;" value="Submeter">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function updateOptions(revista_id) {
        var arr = [],
            xmlhttp = new XMLHttpRequest(),
            select = document.getElementById('periodo_id');
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log("200 " + revista_id)

                arr = eval(this.responseText);
                if (arr.length > 0) {

                    select.innerHTML = '';

                    for (let i = 0; i < arr.length; i++) {

                        var opt = document.createElement('option');
                        var periodo = dateFormatter(arr[i]['dataInicio']) + " - " + dateFormatter(arr[i]['dataFinal']);

                        opt.value = arr[i]['id'];
                        opt.innerHTML = periodo;
                        select.appendChild(opt);
                    }
                }

            }
        }
        xmlhttp.open("GET", "/get/periodochamada/" + revista_id, true);
        xmlhttp.send();

    }

    function dateFormatter(stringDate) {
        return new Date(stringDate).toLocaleDateString("pt-BR");
    }
</script>
