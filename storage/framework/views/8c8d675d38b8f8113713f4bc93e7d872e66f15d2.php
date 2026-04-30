<!DOCTYPE html>
<html lang="pt-br">
<?php echo $__env->make('layouts.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body id="page-top">
    <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="container py-5" style="margin-top: 80px; min-height: 80vh;">

        <div class="mb-4">
            <h2 class="mb-0">Minha Fila de Revisão</h2>
            <p class="text-muted">Artigos atribuídos a você para avaliação.</p>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <?php if($pareceres->isEmpty()): ?>
            <div class="text-center py-5 text-muted">
                <p class="fs-5">Nenhum artigo atribuído a você no momento.</p>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-4">
                <?php $__currentLoopData = $pareceres; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parecer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $submissao = $parecer->submissao; ?>

                    <div class="card p-4 mb-4">

                        
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                            <div>
                                <h5 class="mb-1">
                                    <?php echo e($submissao->titulo); ?>

                                    
                                    <?php if($submissao->arquivo_pdf_revisado): ?>
                                        <span class="badge bg-warning text-dark ms-1" style="font-size: 0.7rem;">
                                            🔄 Resubmissão
                                        </span>
                                    <?php endif; ?>
                                </h5>
                                <small class="text-muted">
                                    Autor: <strong><?php echo e($submissao->autor->name); ?></strong>
                                    · Submetido em <?php echo e($submissao->created_at->format('d/m/Y')); ?>

                                </small>

                                
                                <?php if($submissao->arquivo_pdf_revisado): ?>
                                    <div class="alert alert-warning py-2 mt-2 mb-0" style="font-size: 0.85rem;">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Este artigo passou por uma rodada anterior de revisão e o autor incorporou
                                        as correções solicitadas. Por favor, avalie o PDF revisado abaixo.
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                
                                <?php if(is_null($parecer->aceito_tarefa)): ?>
                                    <span class="badge bg-warning text-dark">Aguardando sua resposta</span>
                                <?php elseif(!$parecer->aceito_tarefa): ?>
                                    <span class="badge bg-secondary">Declinado</span>
                                <?php elseif($parecer->decisao): ?>
                                    <?php echo $parecer->badgeDecisao(); ?>

                                <?php else: ?>
                                    <span class="badge bg-primary">Em avaliação</span>
                                <?php endif; ?>

                                
                                <?php if($parecer->aceito_tarefa): ?>
                                    
                                    
                                    <?php if($submissao->arquivo_pdf_revisado): ?>
                                        <a href="<?php echo e(asset('storage/' . $submissao->arquivo_pdf_revisado)); ?>" download
                                            class="btn btn-sm btn-warning text-dark fw-semibold">
                                            📥 PDF Revisado
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php echo e(asset('storage/' . $submissao->arquivo_pdf)); ?>" download
                                        class="btn btn-sm btn-outline-secondary">
                                        📥 PDF Original
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <p class="text-muted mb-3" style="font-size:0.95rem;">
                            <?php echo e(Str::limit($submissao->resumo, 300)); ?>

                        </p>

                        
                        <?php if($parecer->comentario && $parecer->decisao): ?>
                            <div class="alert alert-light border py-2 mb-3">
                                <small class="fw-semibold">Seu parecer registrado:</small>
                                <p class="mb-0 small mt-1"><?php echo e($parecer->comentario); ?></p>
                            </div>
                        <?php endif; ?>

                        
                        <?php if(is_null($parecer->aceito_tarefa)): ?>
                            <div class="border-top pt-3 mt-2">
                                <p class="fw-semibold small mb-3">
                                    Você aceita revisar este artigo?
                                </p>
                                <div class="d-flex gap-2">
                                    <form action="<?php echo e(route('revisor.pareceres.responderTarefa', $parecer->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="aceito_tarefa" value="1">
                                        <button type="submit" class="btn btn-success btn-sm px-4">
                                            ✅ Aceitar tarefa
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('revisor.pareceres.responderTarefa', $parecer->id)); ?>" method="POST"
                                        onsubmit="return confirm('Declinar esta tarefa? O editor será notificado para atribuir um substituto.')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="aceito_tarefa" value="0">
                                        <button type="submit" class="btn btn-outline-danger btn-sm px-4">
                                            ❌ Declinar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>

                        
                        <?php if($parecer->aceito_tarefa && !$parecer->decisao): ?>
                            <div class="border-top pt-3 mt-2">
                                <p class="fw-semibold small mb-3">Emitir Parecer</p>

                                <form action="<?php echo e(route('revisor.pareceres.emitir', $parecer->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Decisão</label>
                                        <div class="d-flex flex-wrap gap-2">

                                            <div class="form-check">
                                                <input class="form-check-input decisao-radio" type="radio" name="decisao"
                                                    id="d_aceito_<?php echo e($parecer->id); ?>" value="aceito" required>
                                                <label class="form-check-label" for="d_aceito_<?php echo e($parecer->id); ?>">
                                                    ✅ Aceite
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input decisao-radio" type="radio" name="decisao"
                                                    id="d_rejeitado_<?php echo e($parecer->id); ?>" value="rejeitado">
                                                <label class="form-check-label" for="d_rejeitado_<?php echo e($parecer->id); ?>">
                                                    ❌ Decline
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input decisao-radio" type="radio" name="decisao"
                                                    id="d_major_<?php echo e($parecer->id); ?>" value="major_review">
                                                <label class="form-check-label" for="d_major_<?php echo e($parecer->id); ?>">
                                                    🔄 Major Review
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input decisao-radio" type="radio" name="decisao"
                                                    id="d_pontual_<?php echo e($parecer->id); ?>" value="revisao_pontual">
                                                <label class="form-check-label" for="d_pontual_<?php echo e($parecer->id); ?>">
                                                    📝 Revisão Pontual
                                                </label>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="mb-3" id="comentario_wrap_<?php echo e($parecer->id); ?>">
                                        <label class="form-label small fw-semibold">
                                            Comentários
                                            <span id="comentario_obrigatorio_<?php echo e($parecer->id); ?>" class="text-danger"
                                                style="display:none;">
                                                * obrigatório para esta decisão
                                            </span>
                                        </label>
                                        <textarea name="comentario" class="form-control" rows="5" id="comentario_<?php echo e($parecer->id); ?>"
                                            placeholder="Descreva sua avaliação, pontos a melhorar, justificativa..."></textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-sm px-4">
                                        Enviar Parecer
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

    </main>

    <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        // Torna comentário obrigatório para major_review, rejeitado e revisao_pontual
        document.querySelectorAll('.decisao-radio').forEach(radio => {
            radio.addEventListener('change', function () {
                const parecerId = this.id.split('_').pop();
                const comentario = document.getElementById(`comentario_${parecerId}`);
                const aviso = document.getElementById(`comentario_obrigatorio_${parecerId}`);
                const obrigatorio = ['rejeitado', 'major_review', 'revisao_pontual'].includes(this.value);

                comentario.required = obrigatorio;
                aviso.style.display = obrigatorio ? 'inline' : 'none';
            });
        });
    </script>
</body>

</html><?php /**PATH /var/www/html/resources/views/revisor/parecer.blade.php ENDPATH**/ ?>