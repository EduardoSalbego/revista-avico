<!-- Scripts -->
<script src="{{ asset('js/editorSearch.js') }}" defer></script>


<?php
    use Illuminate\Support\Facades\DB;
?>

@extends('layouts.app')

@section('content')
<div class="container pt-5" >
    <div  class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <form class="form" action="{{ route('update.revista', $revista->id )}}" method="POST">
                    @csrf
                    <h3 class="text-center">Atualizando Revista {{ $revista->tituloRevista }}<nome-aqui> </h3>
                    <?php
                        if(isset($_GET['err'])){
                            echo '<h6 class="text-center" id="obrigatorio"><small>Erro ao atualizar revista!</small></h6>';
                        }
                    ?>
                    <div class="form-group mb-2">
                        <label for="titulo" class="ms-3" m>Título<span id="obrigatorio">*</span></label><br>
                        <input type="text" name="titulo" id="titulo" class="form-control" placeholder="" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="editor" class="ms-3">Editor<span id="obrigatorio">*</span></label><br>
                        <input type="text" name="editor_id" id="editor_id" hidden>
                        <input type="text" name="editor" id="editor_input" class="form-control" placeholder="" onkeyup="searchEditor(this.value)" autocomplete="off" required>

                        <ul class="list-group ms-4 me-4 col col-11"  id="editor">
                    </div>
                    <div class="form-group mb-2">
                        <label for="issn" class="ms-3">ISSN<span id="obrigatorio">*</span></label><br>
                        <input type="text" name="issn" id="issn" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="limite" class="ms-3">Limite de Artigos<span id="obrigatorio">*</span></label><br>
                        <input type="text" name="limite" id="limite" class="form-control" required>
                    </div>
                    <div class="d-flex">
                        <div class="form-group mb-2 col-5 me-5">
                            <label for="periodicidade" class="ms-3">Periodicidade<span id="obrigatorio">*</span></label><br>
                            <select class="form-control" name="periodicidades" id="periodicidades">
                            <option value="" disabled>-</option>
                            <?php
                                  $periodicidades = DB::table('periodicidades')->get();
                                  foreach($periodicidades as $p){
                                      echo '<option value='.$p->id.'>'.$p->descricaoPeriodicidade.'</option>';
                                  }
                            ?>
                        </select>
                        </div>
                        <div class="form-group mb-2 col-6 ">
                            <label for="areas" class="ms-3">Áreas</label><br>

                            <select class="form-control" name="areas" id="areas">
                                <option value="" disabled>-</option>
                                <?php
                                    $areas = DB::table('areas')->get();
                                    foreach($areas as $area){
                                        echo '<option value='.$area->id.'>'.$area->descricaoArea.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group pt-2 align-self-start text-start">
                            <input type="submit" name="submit" id="finalizar" class="btn btn-success btn-md col-6" style="color:white;" value="Finalizar">
                        </div>
                        <div class="col form-group pt-2 align-self-end text-end">
                            <a href="{{ route('list.revista.mgmt') }}" name="cancel" style="color:red; text-decoration:none;">Cancelar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('titulo').value = "{{ $revista->tituloRevista }}";
    document.getElementById('editor').value = "{{ $revista->editor->user->name }}";
    document.getElementById('issn').value = "{{ $revista->ISSNRevista }}";
    document.getElementById('limite').value = "{{ $revista->limiteArtigo }}";
    document.getElementById('periodicidade').value = "{{ $revista->periodicidade->id }}";
    document.getElementById('areas').value = "{{ $revista->area_id }}";
</script>

<x-footer/>
@endsection
