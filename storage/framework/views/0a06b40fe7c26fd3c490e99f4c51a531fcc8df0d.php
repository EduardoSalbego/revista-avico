<!DOCTYPE html>
<html lang="pt-br">
<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="page-top">
    <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0">Minhas Submissões</h2>
                <p class="text-muted mb-0">Acompanhe o status dos seus artigos enviados.</p>
            </div>
            <a href="<?php echo e(route('autor.submissoes.create')); ?>" class="btn btn-primary">
                + Submeter Artigo
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php if($submissoes->isEmpty()): ?>
            <div class="text-center py-5">
                <p class="fs-6 text-secondary">Você não submeteu um artigo.</p>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-3">
                <?php $__currentLoopData = $submissoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submissao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card p-4 mb-2 <?php echo e($submissao->status === 'major_review' ? 'border-warning border-2' : ''); ?>">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                            <div>
                                <h5 class="mb-1"><?php echo e($submissao->titulo); ?></h5>
                                <small class="text-muted">
                                    Enviado em <?php echo e($submissao->created_at->format('d/m/Y')); ?>

                                </small>

                                
                                <?php if($submissao->arquivo_pdf_revisado): ?>
                                    <span class="badge bg-warning text-dark ms-2">
                                        🔄 Resubmissão após Major Review
                                    </span>
                                <?php endif; ?>
                            </div>
                            <?php echo $submissao->badgeStatus(); ?>

                        </div>

                        <p class="text-muted mt-3 mb-2" style="font-size: 0.95rem;">
                            <?php echo e(Str::limit($submissao->resumo, 200)); ?>

                        </p>

                        
                        <?php if($submissao->revisoresSugeridos->isNotEmpty()): ?>
                            <div class="mb-2">
                                <small class="text-muted fw-semibold">Revisores sugeridos: </small>
                                <?php $__currentLoopData = $submissao->revisoresSugeridos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $revisor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="badge bg-light text-dark border"><?php echo e($revisor->name); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>

                        
                        <?php if($submissao->observacoes): ?>
                            <div class="alert alert-info py-2 mt-3 mb-2">
                                <strong>Observação do editor:</strong> <?php echo e($submissao->observacoes); ?>

                            </div>
                        <?php endif; ?>

                        
                        <?php if($submissao->status === 'major_review'): ?>
                            <div class="alert alert-warning mt-3 mb-0 border-warning">
                                <div class="d-flex align-items-start gap-2 mb-3">
                                    <span style="font-size: 1.4rem;">🔄</span>
                                    <div>
                                        <strong>Revisão Maior Solicitada</strong><br>
                                        <span class="small">
                                            Os revisores solicitaram correções significativas antes da aprovação.
                                            Corrija seu artigo conforme o feedback acima e reenvie o PDF revisado.
                                            O artigo voltará para os revisores.
                                        </span>
                                    </div>
                                </div>

                                <form action="<?php echo e(route('autor.submissoes.resubmeter', $submissao->id)); ?>" method="POST"
                                    enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="d-flex gap-2 align-items-start flex-wrap">
                                        <div class="flex-grow-1">
                                            <input type="file"
                                                class="form-control form-control-sm <?php $__errorArgs = ['arquivo_pdf_revisado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                name="arquivo_pdf_revisado" accept="application/pdf" required>
                                            <div class="form-text">Apenas PDF. Máximo 20MB.</div>
                                            <?php $__errorArgs = ['arquivo_pdf_revisado'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <button type="submit" class="btn btn-warning btn-sm px-4 fw-semibold"
                                            onclick="return confirm('Enviar o PDF revisado? Os revisores serão notificados para uma nova rodada.')">
                                            Enviar PDF Revisado
                                        </button>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>

                        
                        <?php if($submissao->status === 'revisao_pontual' && !$submissao->arquivo_docx): ?>
                            <div class="alert alert-info mt-3 mb-0">
                                <div class="d-flex align-items-start gap-2 mb-3">
                                    <span style="font-size: 1.4rem;">📝</span>
                                    <div>
                                        <strong>Revisões Pontuais Solicitadas</strong><br>
                                        <span class="small">
                                            Seu artigo foi aceito! Leia o feedback do editor, faça os
                                            ajustes pontuais indicados e envie a versão final em DOCX.
                                        </span>
                                    </div>
                                </div>
                                <form action="<?php echo e(route('autor.submissoes.docx', $submissao->id)); ?>" method="POST"
                                    enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="d-flex gap-2 align-items-start flex-wrap">
                                        <div class="flex-grow-1">
                                            <input type="file" class="form-control form-control-sm" name="arquivo_docx"
                                                accept=".docx,.doc" required>
                                            <div class="form-text">Formato .docx ou .doc. Máximo 20MB.</div>
                                        </div>
                                        <button type="submit" class="btn btn-info btn-sm px-4 fw-semibold text-dark">
                                            Enviar DOCX Final
                                        </button>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>

                        
                        <?php if($submissao->isAceito() && !$submissao->arquivo_docx): ?>
                            <div class="alert alert-success mt-3 mb-0">
                                <div class="d-flex align-items-start gap-2 mb-3">
                                    <span style="font-size: 1.4rem;">🎉</span>
                                    <div>
                                        <strong>Artigo Aceito!</strong><br>
                                        <span class="small">
                                            Parabéns! Envie agora a versão final em DOCX
                                            para o editor incorporar na próxima edição da revista.
                                        </span>
                                    </div>
                                </div>
                                <form action="<?php echo e(route('autor.submissoes.docx', $submissao->id)); ?>" method="POST"
                                    enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="d-flex gap-2 align-items-start flex-wrap">
                                        <div class="flex-grow-1">
                                            <input type="file" class="form-control form-control-sm" name="arquivo_docx"
                                                accept=".docx,.doc" required>
                                            <div class="form-text">Formato .docx ou .doc. Máximo 20MB.</div>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-sm px-4 fw-semibold">
                                            Enviar DOCX Final
                                        </button>
                                    </div>
                                </form>
                            </div>
                        <?php elseif($submissao->isAceito() && $submissao->arquivo_docx): ?>
                            <div class="alert alert-success py-2 mt-3 mb-0">
                                ✅ Versão final em DOCX enviada. Aguardando incorporação pelo editor.
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="mt-4">
                <?php echo e($submissoes->links()); ?>

            </div>
        <?php endif; ?>

    </main>

    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH /var/www/html/resources/views/autor/submissoes/index.blade.php ENDPATH**/ ?>