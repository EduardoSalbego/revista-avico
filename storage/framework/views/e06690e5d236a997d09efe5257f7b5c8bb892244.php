<?php use Illuminate\Support\Facades\DB; ?>

<?php $__env->startSection('content'); ?>
<div class="container pt-5" >
    <div  class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-12">
                <h3 class="text-center">Edição de autor</h3>
                <form action="<?php echo e(route('edit.autor', $autor->orcid)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Nome</label><span id="obrigatorio">*</span><br>
                        <input type="text" name="nome" class="form-control" value="<?php echo e($autor->user->name); ?>" required><br>
                        <p style="color: red" ;><?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Email</label><span id="obrigatorio">*</span><br>
                        <input type="email" name="email" class="form-control" disabled value="<?php echo e($autor->user->email); ?>" required><br>
                        <p style="color: red" ;><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
                    </div>
                    <!-- <div class="form-group mb-2">
                        <label for="" class="ms-3">Senha</label><span id="obrigatorio">*</span><br>
                        <input type="password" name="password" value="<?php echo e($autor->password); ?>" disabled class="form-control"><br>
                    </div> -->
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Endereço</label><br>
                        <input type="text" name="endereco" value="<?php echo e($autor->user->endereco); ?>" class="form-control"><br>
                        <p style="color: red" ;><?php $__errorArgs = ['endereco'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Telefone</label><br>
                        <input type="text" name="telefone" value="<?php echo e($autor->user->telefone); ?>" class="form-control"><br>
                        <p style="color: red" ;><?php $__errorArgs = ['telefone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="ms-3 mb-1">Área de preferência<span id="obrigatorio">*</span></label>
                        <?php $__errorArgs = ['area_pref'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <select class="form-control mb-2" name="area_pref" id="area">
                            <option value="<?php echo e($autor->area->descricaoArea); ?>" disabled><?php echo e($autor->area->descricaoArea); ?></option>
                            <?php
                            $areas = DB::table('areas')->get();
                            foreach ($areas as $a) {
                                echo '<option value=' . $a->id . '>' . $a->descricaoArea . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="ms-3">Instituição</label><br>
                        <p style="color: red" ;><?php $__errorArgs = ['instituicao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
                        <input type="text" name="instituicao" value="<?php echo e($autor->instituicao); ?>" class="form-control"><br>                        
                    </div>
                    <div class="form-group mb-2 col-5 me-5">
                        <label for="">País de origem<span id="obrigatorio">*</span></label> <br />
                        <p style="color: red" ;><?php $__errorArgs = ['pais_origem'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><p>
                        <select class="form-control" name="pais_origem" id="paises"> <br />
                            <option value="" disabled>-</option>
                            <?php
                            $paises = DB::table('paises')->get();
                            foreach ($paises as $p) {
                                echo '<option value=' . $p->id . '>' . $p->nomePais . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="row mb-5">
                        <div class="col form-group pt-2 align-center text-center mb-5">
                            <input type="submit" name="submit" class="btn btn-success btn-md col-6" style="color:white;" value="Salvar">
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\rp\rp4\resources\views/autor\editar.blade.php ENDPATH**/ ?>