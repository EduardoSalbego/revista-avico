<link href="<?php echo e(asset('css/sidebar.css')); ?>" rel="stylesheet" type="text/css">
<script src="<?php echo e(asset('js/sidebar.js')); ?>" defer></script>

<div class="">
    <!-- It is quality rather than quantity that matters. - Lucius Annaeus Seneca -->
    <div class="d-flex align-items-stretch " style="height: 94vh; width: 190px; background-color:white; ">
        <ul class="list-group " style="width: 190px; border-radius: 0; ">
            <?php if(auth()->check() && auth()->user()->hasRole('editor-chefe')): ?> 
                <?php echo $__env->make('components.sidebar_lists.editor-chefe_list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <?php if(auth()->check() && auth()->user()->hasRole('autor')): ?>
                <?php echo $__env->make('components.sidebar_lists.autor_list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>           
        </ul>
    </div>
</div><?php /**PATH D:\Documentos\UNIPAMPA\rp4\resources\views/components/sidebar.blade.php ENDPATH**/ ?>