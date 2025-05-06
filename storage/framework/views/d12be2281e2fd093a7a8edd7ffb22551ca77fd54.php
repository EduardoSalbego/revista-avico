<?php
    use Illuminate\Support\Facades\DB;
?>


<?php $__env->startSection('content'); ?>

<div class="container pt-5" >
    <div  class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <h3 class="text-center">Edição das informações do Avaliador</h3>
                <form action="<?php echo e(route('editarAvaliador', $avaliador->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group mb-2">
        <label for="">Nome<span id="obrigatorio">*</span></label><br>
        <input type="text" name="nome" class="form-control" value="<?php echo e($avaliador->user->name); ?>"><br>
        <p style="color: red";><?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
        <label for="">Email<span id="obrigatorio">*</span></label><br>
        <input type="email" name="email" class="form-control" disabled value="<?php echo e($avaliador->user->email); ?>"><br>
        <p style="color: red";><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
        <label for="">Endereço<span id="obrigatorio">*</span></label><br>
        <input type="text" name="endereco" class="form-control" value="<?php echo e($avaliador->user->endereco); ?>"><br>
        <p style="color: red";><?php $__errorArgs = ['endereco'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
        <label for="" >Telefone<span id="obrigatorio">*</span></label><br>
        <input type="number" name="telefone" class="form-control" value="<?php echo e($avaliador->user->telefone); ?>"><br>
        <p style="color: red";><?php $__errorArgs = ['telefone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
        <label for="">País de origem<span id="obrigatorio">*</span></label> <br />
            <select class="form-control" name="pais_origem" id="paises" value="<?php echo e($avaliador->user->pais_origem); ?>"> <br />
            <option value="" disabled>-</option>
            <?php
                            $paises = DB::table('paises')->get();
                            foreach ($paises as $p) {
                                echo '<option value=' . $p->id . '>' . $p->nomePais . '</option>';
                            }
                            ?>
            </select>
        </div>
        <p style="color: red";><?php $__errorArgs = ['pais_origem'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
        <label for="">Área de interesse<span id="obrigatorio">*</span></label> <br />
            <select class="from-control" name="area_pref" id="areasPref" value = " <?php echo e($avaliador->area->descricaoArea); ?>"  style="border: 2px solid gray;">
            <option value="" disabled>-</option>
            <?php
                            $areas = DB::table('areas')->get();
                            foreach ($areas as $a) {
                                echo '<option value=' . $a->id . '>' . $a->descricaoArea . '</option>';
                            }
                            ?>
            </select>
        <div>
        <p style="color: red";><?php $__errorArgs = ['area_pref'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\rp\rp4\resources\views/avaliador\edit.blade.php ENDPATH**/ ?>