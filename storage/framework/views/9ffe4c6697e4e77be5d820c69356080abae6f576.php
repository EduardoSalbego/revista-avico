<?php

use Illuminate\Support\Facades\DB;
?>



<?php $__env->startSection('content'); ?>
<div class="container pt-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6">
            <div class="col-md-10">
                <div class="card-header"><?php echo e(__('Registrar Usuário')); ?></div>
                <form method="POST" action="<?php echo e(route('register')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="name" class="ms-3 col-md-4 col-form-label text-md-right"><?php echo e(__('Name')); ?><span id="obrigatorio">*</span> </label>

                        <div class="">
                            <input id="name" type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name')); ?>" autocomplete="name" autofocus>

                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label for="email" class="ms-3 col-md-4 col-form-label text-md-right"><?php echo e(__('E-Mail Address')); ?><span id="obrigatorio">*</span></label>

                        <div class="">
                            <input id="email" type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email')); ?>" autocomplete="email">

                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <strong><?php echo e($message); ?></strong>
                            </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col form-group mt-2">
                            <label for="password" class="ms-3 col-form-label text-md-right"><?php echo e(__('Password')); ?><span id="obrigatorio">*</span></label>

                            <div class="">
                                <input id="password" type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" autocomplete="new-password">

                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col form-group mt-2">
                            <label for="password-confirm" class="ms-3 col-form-label text-md-right"><?php echo e(__('Confirm Password')); ?><span id="obrigatorio">*</span></label>

                            <div class="">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="off">
                            </div>
                        </div>
                    </div>


                    <input type="text" name="role" id="role" class="form-control" hidden>

                    <div class="card-header mt-5 mb-3 d-flex justify-content-between">
                        <div class="btn-group">
                            <span>Escolha um tipo de usuário<span id="obrigatorio">*</span>&nbsp;&nbsp;</span>
                            <button class="btn btn-dark btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" onclick="select(this.id)" data-bs-toggle="collapse" data-bs-target="#" id="avaliador">Avaliador</a></li>
                                <li><a class="dropdown-item" onclick="select(this.id)" id="autor">Autor</a></li>
                                <li><a class="dropdown-item" onclick="select(this.id)" id="editor">Editor</a></li>
                            </ul>
                        </div>
                        <?php echo e(__('Dados Pessoais')); ?>


                    </div>
                    <!-- AUTOR -->
                    <div class="form-group mb-2 mt-4" hidden="true" id="autor_modal">
                        <label for="orcid" class="ms-3 mb-1">ORCID<span id="obrigatorio">*</span></label>
                        <input type="text" maxlength="12" name="orcid" id="orcid" class="form-control mb-2">

                        <label for="" class="ms-3 mb-1">Instituição</label>
                        <?php $__errorArgs = ['instituicao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <input type="text" name="instituicao" class="form-control mb-2">

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
                            <option value="" disabled>-</option>
                            <?php
                            $areas = DB::table('areas')->get();
                            foreach ($areas as $a) {
                                echo '<option value=' . $a->id . '>' . $a->descricaoArea . '</option>';
                            }
                            ?>
                        </select>

                    </div>
                    <!-- FIM AUTOR -->

                    <!-- EDITOR -->
                    <div class="form-group mt-4" hidden="true" id="editor_modal">
                        <label for="" class="ms-3 mb-1">Área de preferência<span id="obrigatorio">*</span></label> <br />
                        <select class="form-control" name="especialidade" id="area"> <br />
                            <option value="" disabled>-</option>
                            <?php
                            $areas = DB::table('areas')->get();
                            foreach ($areas as $a) {
                                echo '<option value=' . $a->id . '>' . $a->descricaoArea . '</option>';
                            }
                            ?>
                            <p style="color: red" ;><?php $__errorArgs = ['area_pref'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </select>

                        <label for="" class="ms-3 mb-1 mt-2">Data de Contratação<span id="obrigatorio">*</span></label> <br />
                        <input type="date" class="form-control mb-0" placeholder="2001/06/01" name="dataContratacao">
                        <p style="color: red" ;><?php $__errorArgs = ['dataContratacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <!-- FIM EDITOR -->

                    <!--AVALIADOR INICIO -->
                    <div class="form-group mt-4" hidden="true" id="avaliador_modal">
                        <label for="" class="ms-3 mb-1">Área de preferência<span id="obrigatorio">*</span></label> <br />
                        <select class="form-control" name="especialidade" id="area"> <br />
                            <option value="" disabled>-</option>
                            <?php
                            $areas = DB::table('areas')->get();
                            foreach ($areas as $a) {
                                echo '<option value=' . $a->id . '>' . $a->descricaoArea . '</option>';
                            }
                            ?>
                            <p style="color: red" ;><?php $__errorArgs = ['area_pref'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </select>
                    </div>
                    <!-- FIM AVALIADOR -->

                    <div class="form-group">
                        <label for="endereco" class="ms-3 mb-1">Endereço<span id="obrigatorio">*</span></label><br>
                        <input type="address" name="endereco" id="endereco" class="form-control" required>
                    </div>
                    <p style="color: red" ;><?php $__errorArgs = ['endereco'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <div class="form-group">
                        <label class="ms-3 mb-1" for="">País de origem<span id="obrigatorio">*</span></label> <br />
                        <select class="form-control" name="pais_id" id="pais"> <br />
                            <option value="" disabled>-</option>
                            <?php
                            $paises = DB::table('paises')->get();
                            foreach ($paises as $p) {
                                echo '<option value=' . $p->id . '>' . $p->nomePais . '</option>';
                            }
                            ?>
                        </select>
                        <p style="color: red" ;><?php $__errorArgs = ['pais'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group ">
                        <label class="ms-3 mb-1" for="">Telefone<span id="obrigatorio">*</span></label> <br />
                        <input type="text" class="form-control" name="telefone"> <br />
                        <p style="color: red"><?php $__errorArgs = ['telefone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <?php echo e($message); ?> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group row mb-5 mt-4">
                        <div class="col-3 form-group pt-2">
                            <input type="submit" name="submit" class="btn btn-success btn-md" style="color:white;" value="Register">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function select(role) {
        var x = document.getElementById('role').value = role;

        var autor = document.getElementById('autor_modal');
        var editor = document.getElementById('editor_modal');
        var avaliador = document.getElementById('avaliador_modal');


        document.getElementById(role + '_modal').hidden = false;
        document.getElementById(role + '_modal').required = true;
        document.getElementById(role + '_modal').disabled = false;


        switch (role) {
            case 'autor':
                disable(editor);
                disable(avaliador);
                break;
            case 'editor':
                disable(autor);
                disable(avaliador)
                break;
            case 'avaliador':
                disable(autor);
                disable(editor);
        }

    }

    function disable(modal) {
        modal.setAttribute('hidden', 'true');
        modal.setAttribute('required', 'false');
        modal.setAttribute('disabled', 'true');
    }
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\rp\rp4\resources\views/auth/register.blade.php ENDPATH**/ ?>