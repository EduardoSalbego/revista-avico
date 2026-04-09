
<?php $__env->startSection('content'); ?>

    <div class="container pt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="col-md-12">
                    <form action="" class="form" method="POST">
                        <?php echo csrf_field(); ?>
                        <h3 class="text-center">Cadastrar nova edição da revista titulo</h3>
                        <div class="form-group ms-3 mb-2">Dê um título para a edição
                            <div class="ms-3 my-2">
                                <input type="text" class="form-control" name="titulo">
                            </div>
                        </div>
                        <div class="form-group ms-3 mb-2">Selecione os artigos que irão compor a revista
                            <div class="form-check ms-3 my-2">
                                <input class="form-check-input" type="checkbox" name="artigo[]" id="" value="33">
                                <label class="form-check-label" for="">titulo do artigo [Média:
                                    <?php echo e($notas[$loop->index]); ?>]</label>
                            </div>
                            <div class="container w-50 mt-3">
                                <div class="alert alert-danger text-center">
                                    Não há artigos
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 form-group mt-2">
                                <input type="submit" name="submit" id="btnSubmit" class="btn btn-success btn-md"
                                    style="color:white;" value="Cadastrar nova edição">
                            </div>
                        </div>

                        <?php if(session()->has('no_articles_selected')): ?>
                            <div class="container w-50 mt-3">
                                <div class="alert alert-danger text-center">
                                    <?php echo e(session()->get('no_articles_selected')); ?>

                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if(session()->has('fail_msg')): ?>
                            <div class="container w-50 mt-3">
                                <div class="alert alert-danger text-center">
                                    <?php echo e(session()->get('fail_msg')); ?>

                                </div>
                            </div>
                        <?php endif; ?>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\revista-avico\resources\views/edicao/create.blade.php ENDPATH**/ ?>