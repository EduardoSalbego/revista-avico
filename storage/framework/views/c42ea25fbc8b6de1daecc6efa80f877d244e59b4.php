<!-- Scripts -->
<script src="<?php echo e(asset('js/search.js')); ?>" defer></script>

 <!-- Styles -->
 <link href="<?php echo e(asset('css/select.css')); ?>" rel="stylesheet" type="text/css">


<?php $__env->startSection('content'); ?>


<div class="container pt-5" >
    <div  class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <form class="form" action="<?php echo e(route('submit.artigo')); ?>" method="POST" enctype="multipart/form-data">
                    
                    <?php echo csrf_field(); ?>
                    <h3 class="text-center">Submeter Artigos</h3>

                    <div class="form-group mb-2">
                        <label for="editor" class="ms-3">Revista<span id="obrigatorio">*</span></label><br>
                        <input type="text" name="revista_id" id="revista_id" hidden>
                        <input autocomplete="off" type="text" name="titulo" id="pesq" class="form-control" onkeyup="search(this.value)" required>
                       
                        <ul class="list-group ms-4 me-4 col col-11"  id="revista">

                        </ul>
                    </div>

                    <div class="form-group mb-2">
                     
                        <label for="autores" class="ms-3" m>Autores<span id="obrigatorio">* <small><?php echo session()->get('erro002'); ?></small></span></label><br>
                        
                        <ul id="author" class="list-group list-group-horizontal"></ul>
                        <input autocomplete="off" type="text" id="autores" class="form-control mt-2" onkeyup="searchAuthor(this.value)">

                        <ul class="list-group ms-4 me-4 col col-11"  id="autor"></ul>
                    </div>
                    
                    
                    <h6 class="text-center" id="obrigatorio"><small><?php echo session()->get('erro001'); ?></small></h6>
                   
                    <table id="artigos-table" style="transition:none !important;" class="table table-sm table-borderless">
                        <thead class="table-dark">
                            <th class="" scope="col">Artigo<span id="obrigatorio">* </span> < <small id="obrigatorio">50MB</small></th>
                            <th class="" scope="col">Título<span id="obrigatorio">*</span></th>
                            <th class="" scope="col">
                                
                                <a type="button" class="btn btn-success btn-sm" onclick="add()" >
                                    <i class="fa fa-plus fa-1x" style="transition:none !important;" aria-hidden="true"></i>            
                                </a>
                            </th>
                            <th class="" scope="col">
                                <a class="btn btn-danger btn-sm" onclick="del()">
                                    <i class="fa fa-minus fa-1x" style="transition:none !important;" aria-hidden="true"></i>
                                </a>
                            </th>
                        </thead>
                        <tbody >
                            <tr scope="row" >
    
                                <td><input name="artigo[]" style="border-style:none;" class="form-control form-control-sm" type="file" accept="application/pdf" required></td>
                                <td><input name="tituloArtigo[]" style="border-radius: 0% !important;
                                                  border-color: transparent !important;
                                                  border-bottom: solid 2px black !important;" class="form-control form-control-sm" type="text" required></td>    
                                <td></td>
                                <td></td>
                            </tr>


                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-3 form-group pt-2">
                            <input type="submit" name="submit" class="btn btn-success btn-md" style="color:white;" value="Submeter">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\rp\rp4\resources\views/artigo/submeter.blade.php ENDPATH**/ ?>