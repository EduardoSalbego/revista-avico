<?php use Illuminate\Support\Facades\DB; ?>

<?php $__env->startSection('content'); ?>
    <div class="container pt-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="col-md-12">
                    <h3 class="text-center">Avaliar Artigo</h3>
                    <form action="<?php echo e(route('avaliar.artigo', $artigo->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <?php if(Session::has('message')): ?>
                        <p style="color:red;" class=""><?php echo e(Session::get('message')); ?></p>
                        <?php endif; ?>

                        <?php $situa = DB::table('situacao')->where('id', $artigo->situacao_id)->first(); ?>


                        <div class="form-group mb-2">
                            <label for="" class="ms-3">Título</label><br>
                            <input type="text" name="titulo" class="form-control" value="<?php echo e($artigo->tituloArtigo); ?>"
                                disabled><br>
                        </div>
                        <div class="form-group mb-2">
                            <a target="_blank" href="<?php echo e(asset('storage/app/public/artigos/' . $artigo->caminhoArtigo)); ?>">
                                <small><p class="articles mb-1 text-center p-1"><?php echo e($artigo->tituloArtigo); ?></br></p></small>
                            </a>
                        </div>
                        <div class="form-group mb-2">
                            <label for="" class="ms-3">Status</label><br>
                            <input type="text" name="descricaoSituacao" class="form-control" disabled
                                value="<?php echo e($situa->descricaoSituacao); ?>"><br>
                        </div>

                        <div class="form-group mb-2">
                            <label for="" class="ms-3">Nota</label><br>
                            <input type="number" name="nota" class="form-control"
                                value="<?php echo e($artigo->nota); ?>"><br>
                                <p style="color: red" ;><?php $__errorArgs = ['nota'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
                        </div>
                        <div class="row mb-5">
                            <div class="col form-group pt-2 align-center text-center mb-5">
                                <input type="submit" name="submit" class="btn btn-success btn-md col-6" style="color:white;"
                                    value="Salvar">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\thiag\OneDrive\Documentos\GitHub\rp4-revista\resources\views/avaliador\avaliar_artigo.blade.php ENDPATH**/ ?>