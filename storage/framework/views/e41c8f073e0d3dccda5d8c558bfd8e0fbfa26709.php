<li id="list-tree" class="list-group-item border-0">
    <a class="" data-bs-toggle="collapse" id="Revista" href="#revistas" role="button" aria-expanded="false" aria-controls="collapseExample">
        Revistas
    </a>
    <ul class="list-group border-0 collapse" id="revistas">
        <li id="list-tree" class="list-group-item  border-0"><a href="<?php echo e(route('create.revista.view')); ?>" id="cadastrarRevista">Cadastrar</a></li>
        <li id="list-tree" class="list-group-item  border-0"><a href="<?php echo e(route('list.revista.mgmt')); ?>" id="gerenciarRevista">Gerenciar</a></li>
    </ul>
</li>

<li id="list-tree" class="list-group-item border-0">
    <a class="" data-bs-toggle="collapse" id="Autor" href="#autores" role="button" aria-expanded="false" aria-controls="collapseExample">
        Autores
    </a>
    <ul class="list-group-item border-0 collapse" id="autores">
        <li id="list-tree" class="list-group-item  border-0"><a href="<?php echo e(route('list.autor.mgmt')); ?>" id="gerenciarAutor">Gerenciar</a></li>
    </ul>
</li>

<li id="list-tree" class="list-group-item border-0">
    <a class="" data-bs-toggle="collapse" id="Avaliador" href="#avaliadores" role="button" aria-expanded="false" aria-controls="collapseExample">
        Avaliadores
    </a>
    <ul class="list-group-item border-0 collapse" id="avaliadores">
        <li id="list-tree" class="list-group-item  border-0"><a href="<?php echo e(route('listaAvaliadores')); ?>" id="gerenciarAvaliador">Gerenciar</a></li>
    </ul>
</li>

<li id="list-tree" class="list-group-item border-0">
    <a class="" data-bs-toggle="collapse" id="Editor" href="#editores" role="button" aria-expanded="false" aria-controls="collapseExample">
        Editores
    </a>
    <ul class="list-group-item border-0 collapse" id="editores">
        <li id="list-tree" class="list-group-item  border-0"><a href="<?php echo e(route('lista_editores')); ?>" id="gerenciarEditor">Gerenciar</a></li>
    </ul>
</li>
<?php /**PATH C:\Users\rafae\OneDrive\Documentos\rp4-revista\rp4-revista\resources\views/components/sidebar_lists/editor-chefe_list.blade.php ENDPATH**/ ?>