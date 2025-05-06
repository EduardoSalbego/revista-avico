<li id="list-tree" class="list-group-item border-0">
    <a class="" data-bs-toggle="collapse" href="#revistas" role="button" aria-expanded="false" aria-controls="collapseExample">
        Revistas
    </a>
    <ul class="list-group border-0 collapse" id="revistas">
        <li id="list-tree" class="list-group-item  border-0"><a href="<?php echo e(route('create.revista.view')); ?>">Cadastrar</a></li>
        <li id="list-tree" class="list-group-item  border-0"><a href="<?php echo e(route('list.revista.mgmt')); ?>">Gerenciar</a></li>
    </ul>
</li>

<li id="list-tree" class="list-group-item border-0">
    <a class="" data-bs-toggle="collapse" href="#autores" role="button" aria-expanded="false" aria-controls="collapseExample">
        Autores
    </a>
    <ul class="list-group-item border-0 collapse" id="autores">
        <li id="list-tree" class="list-group-item  border-0"><a href="<?php echo e(route('list.autor.mgmt')); ?>">Gerenciar</a></li>
    </ul>
</li>

<li id="list-tree" class="list-group-item border-0">
    <a class="" data-bs-toggle="collapse" href="#avaliadores" role="button" aria-expanded="false" aria-controls="collapseExample">
        Avaliadores
    </a>
    <ul class="list-group-item border-0 collapse" id="avaliadores">
        <li id="list-tree" class="list-group-item  border-0"><a href="<?php echo e(route('listaAvaliadores')); ?>">Gerenciar</a></li>
    </ul>
</li>

<li id="list-tree" class="list-group-item border-0">
    <a class="" data-bs-toggle="collapse" href="#editores" role="button" aria-expanded="false" aria-controls="collapseExample">
        Editores
    </a>
    <ul class="list-group-item border-0 collapse" id="editores">
        <li id="list-tree" class="list-group-item  border-0"><a href="<?php echo e(route('lista_editores')); ?>">Gerenciar</a></li>
    </ul>
</li>
<?php /**PATH C:\wamp64\www\rp\rp4\resources\views/components/sidebar_lists/editor-chefe_list.blade.php ENDPATH**/ ?>