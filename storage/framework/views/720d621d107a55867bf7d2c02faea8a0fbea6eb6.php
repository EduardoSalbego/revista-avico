<?php

use Illuminate\Support\Facades\DB;
?>


<?php $__env->startSection('content'); ?>

<div class="container pt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <h3 class="text-center">Edição das informações do Editor</h3>
                <form action="<?php echo e(route('alterar_editor', $editor->id)); ?>" method="POST">

                    <?php echo csrf_field(); ?>
                    <div class="form-group mb-2">
                        <label for="">Nome</label><br>
                        <input type="text" name="nome" class="form-control" value="<?php echo e($editor->user->name); ?>"><br>
                        <p style="color: red" ;><?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
                        <label for="">Email</label><br>
                        <input type="email" name="email" class="form-control" disabled value="<?php echo e($editor->user->email); ?>"><br>
                        <label for="">Telefone</label> <br />
                        <input type="tel" class="form-control" name="telefone" value="<?php echo e($editor->user->telefone); ?>"> <br />
                        <p style="color: red" ;><?php $__errorArgs = ['telefone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
                        <label for="">Endereco</label><br>
                        <input type="text" name="endereco" class="form-control" value="<?php echo e($editor->user->endereco); ?>"><br>
                        <p style="color: red" ;><?php $__errorArgs = ['endereco'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
                        <label for="">País de origem<span id="obrigatorio">*</span></label> <br />
                        <select class="form-control" name="pais_id" id="paises" value="<?php echo e($editor->user->pais_id); ?>"> <br />
                            <option value="" disabled>-</option>
                            <?php
                            $paises = DB::table('paises')->get();
                            foreach ($paises as $p) {
                                echo '<option value=' . $p->id . '>' . $p->nomePais . '</option>';
                            }
                            ?>
                        </select>
                        <label for="">Especialidade<span id="obrigatorio">*</span></label> <br />
                        <select class="form-control" name="especialidade" value="<?php echo e($editor->pais_id); ?>"> <br />
                            <option value="" disabled>-</option>
                            <?php
                            $areas = DB::table('areas')->get();
                            foreach ($areas as $a) {
                                echo '<option value=' . $a->id . '>' . $a->descricaoArea . '</option>';
                            }
                            ?>
                        </select>
                        <label for="">Data de Contratação</label><br>
                        <input disabled type="date" name="dataContratacao" class="form-control" value="<?php echo e($editor->dataContratacao); ?>"><br>
                        <button type="submit" class="btn btn-primary">Salvar</button>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\rp\rp4\resources\views/editores\edit.blade.php ENDPATH**/ ?>