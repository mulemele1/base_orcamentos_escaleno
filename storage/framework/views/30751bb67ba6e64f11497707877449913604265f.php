
<div class="componente-item <?php echo e($medicao ? 'componente-medido' : ''); ?>">
    <div class="d-flex justify-content-between align-items-center">
        <div class="flex-grow-1">
            <div class="d-flex align-items-center">
                <?php if($medicao): ?>
                    <i class="fas fa-check-circle text-success mr-2"></i>
                <?php else: ?>
                    <i class="fas fa-cube text-secondary mr-2"></i>
                <?php endif; ?>
                <strong><?php echo e($componente->nome); ?></strong>
                <span class="badge badge-light ml-2">
                    <?php echo e($componente->unidade); ?>

                </span>
                <?php if($componente->formula_calculo): ?>
                    <span class="badge badge-info ml-2">
                        <i class="fas fa-calculator"></i> 
                        <?php switch($componente->formula_calculo):
                            case ('volume'): ?>
                                C×L×H
                                <?php break; ?>
                            <?php case ('area'): ?>
                                C×L
                                <?php break; ?>
                            <?php case ('area_parede'): ?>
                                C×H
                                <?php break; ?>
                            <?php case ('area_lateral'): ?>
                                L×H
                                <?php break; ?>
                            <?php case ('comprimento'): ?>
                                C
                                <?php break; ?>
                            <?php case ('valor_fixo'): ?>
                                Fixo
                                <?php break; ?>
                            <?php default: ?>
                                <?php echo e($componente->formula_calculo); ?>

                        <?php endswitch; ?>
                    </span>
                <?php endif; ?>
                <?php if($componente->perda_padrao > 0): ?>
                    <span class="badge badge-warning ml-2">
                        <i class="fas fa-percent"></i> Perda: <?php echo e($componente->perda_padrao); ?>%
                    </span>
                <?php endif; ?>
            </div>
            <?php if($medicao): ?>
                <div class="small text-muted mt-1">
                    <i class="fas fa-chart-line"></i> 
                    <?php echo e($medicao->npi); ?> × 
                    <?php if($medicao->comprimento): ?> <?php echo e($medicao->comprimento); ?>m <?php endif; ?>
                    <?php if($medicao->largura): ?> × <?php echo e($medicao->largura); ?>m <?php endif; ?>
                    <?php if($medicao->altura): ?> × <?php echo e($medicao->altura); ?>m <?php endif; ?>
                    = <strong class="text-success"><?php echo e(number_format($medicao->quantidade, 2)); ?> <?php echo e($componente->unidade); ?></strong>
                    <?php if($medicao->perda > 0): ?>
                        <span class="text-warning">(+<?php echo e($medicao->perda); ?>% perda)</span>
                    <?php endif; ?>
                    <br>
                    <i class="fas fa-map-marker-alt"></i> Origem: <?php echo e($medicao->origem == 'desenho' ? 'Desenho' : 'Campo'); ?>

                    <?php if($medicao->prancha): ?>
                        | Prancha: <?php echo e($medicao->prancha); ?>

                    <?php endif; ?>
                    <?php if($medicao->data_medicao): ?>
                        | Data: <?php echo e(\Carbon\Carbon::parse($medicao->data_medicao)->format('d/m/Y')); ?>

                    <?php endif; ?>
                    <?php if($medicao->observacoes): ?>
                        <br><i class="fas fa-comment"></i> <?php echo e(Str::limit($medicao->observacoes, 50)); ?>

                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="small text-muted mt-1">
                    <i class="fas fa-info-circle"></i> Aguardando medição
                </div>
            <?php endif; ?>
        </div>
        <div class="ml-3">
            <?php if($medicao): ?>
                <a href="<?php echo e(route('medicoes.edit', [$projeto, $medicao])); ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <form action="<?php echo e(route('medicoes.destroy', [$projeto, $medicao])); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remover esta medição?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            <?php else: ?>
                <a href="<?php echo e(route('medicoes.create', $projeto)); ?>?componente_id=<?php echo e($componente->id); ?>" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Medir
                </a>
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/medicoes/partials/componente-item.blade.php ENDPATH**/ ?>