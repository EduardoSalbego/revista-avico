<!-- Scripts -->
<script src="<?php echo e(asset('js/editorSearch.js')); ?>" defer></script>
<script src="<?php echo e(asset('js/periodoChamado.js')); ?>" defer></script>

 <!-- Styles -->
 <link href="<?php echo e(asset('css/select.css')); ?>" rel="stylesheet" type="text/css">


<?php
    use Illuminate\Support\Facades\DB;
?>



<?php $__env->startSection('content'); ?>
<div class="container pt-5" >
    <div  class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <form class="form" action="<?php echo e(route('create.revista')); ?>" method="POST">
                    
                    <?php echo csrf_field(); ?>
                    <h3 class="text-center">Cadastro de Nova Revista</h3>
                    <?php
                        if(isset($_GET['err'])){
                            echo '<h6 class="text-center" id="obrigatorio"><small>Erro ao cadastrar nova revista!</small></h6>';
                        }
                    ?>
                    <div class="form-group mb-2">
                        <label for="titulo" class="ms-3" m>Título<span id="obrigatorio">*</span></label><br>
                        <input type="text" name="titulo" id="titulo" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="editor" class="ms-3">Editor<span id="obrigatorio">*</span></label><br>
                        <input type="text" name="editor_id" id="editor_id" hidden>
                        <input type="text" name="editor" id="editor_input" class="form-control" placeholder="" onkeyup="searchEditor(this.value)" autocomplete="off" required>

                        <ul class="list-group ms-4 me-4 col col-11"  id="editor">
                    </div>
                    <div class="form-group mb-2">
                        <label for="issn" class="ms-3">ISSN<span id="obrigatorio">*</span></label><br>
                        <input type="text" name="issn" maxlength="8" id="issn" class="form-control" required>
                    </div>
                    <div class="form-group mb-2">
                        <label for="limite" class="ms-3">Limite de Artigos<span id="obrigatorio">*</span></label><br>
                        <input type="text" name="limite" id="limite" class="form-control" required>
                    </div>

                    <div class="d-flex">
                        <div class="form-group mb-2 col-5 me-5">
                            <label for="periodicidade" class="ms-3">Periodicidade<span id="obrigatorio">*</span></label><br>
                            <select class="form-control" name="periodicidade" id="periodicidade">
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
                    <hr>
                    <a type="button" class="btn btn-success btn-sm" onclick="add()" >
                        <i class="fa fa-plus fa-1x" style="transition:none !important;" aria-hidden="true"></i>            
                    </a>
                    <a class="btn btn-secondary btn-sm" onclick="del()">
                        <i class="fa fa-minus fa-1x" style="transition:none !important;" aria-hidden="true"></i>
                    </a>
                    <h6 class="text-center" id="obrigatorio"><small><?php echo session()->get('ERRO'); ?></small></h6>
                    <label class="ms-3 mb-2" scope="col">Periodo(s) de Chamado<span id="obrigatorio">* </span></label>
                    <table id="view-table" style="width: 90px !important; transition:none !important;" class="table table-sm table-borderless">
                        <thead class="table-dark">
                            <th class="" scope="col">Data Inicio</th>
                            <th class="" scope="col">Data Final</th>
                            <th class="" scope="col">Divulgação</th>
                            <th class="" scope="col">Avaliações</th>
   
                        </thead>
                        <tbody >
                            <tr scope="row" >
    
                                <td><input type="date" name="dataInicio[]" class="form-control" style="border-radius: 0% !important;
                                                  border-color: transparent !important;
                                                  border-bottom: solid 2px black !important;" required></td>    
                                <td><input type="date" name="dataFinal[]" class="form-control" style="border-radius: 0% !important;
                                                  border-color: transparent !important;
                                                  border-bottom: solid 2px black !important;" required></td>      
                                <td><input type="date" name="dataDivulgacao[]" class="form-control" style="border-radius: 0% !important;
                                                  border-color: transparent !important;
                                                  border-bottom: solid 2px black !important;" required></td>      
                                <td><input type="date" name="dataMaximaAvaliacao[]" class="form-control" style="border-radius: 0% !important;
                                                  border-color: transparent !important;
                                                  border-bottom: solid 2px black !important;" required></td>                                                                                                                                                                                
                            </tr>


                        </tbody>
                    </table>
                   
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
<?php if (isset($component)) { $__componentOriginal88b1957f21f7f49b400717e8d0a27189798132bf = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Footer::class, []); ?>
<?php $component->withName('footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88b1957f21f7f49b400717e8d0a27189798132bf)): ?>
<?php $component = $__componentOriginal88b1957f21f7f49b400717e8d0a27189798132bf; ?>
<?php unset($__componentOriginal88b1957f21f7f49b400717e8d0a27189798132bf); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Documentos\UNIPAMPA\rp4\resources\views/revista/create.blade.php ENDPATH**/ ?>