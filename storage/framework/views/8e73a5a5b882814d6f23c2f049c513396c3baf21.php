

<?php $__env->startSection('title', 'Detalhes da Atividade'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-info-circle mr-2"></i>Detalhes do Capitulo</h1>
    <div>
        <a href="<?php echo e(route('atividades.edit', $atividade->id)); ?>" class="btn btn-warning">
            <i class="fas fa-edit mr-1"></i> Editar
        </a>
        <a href="<?php echo e(route('atividades.index', ['categoria_id' => $atividade->categoria_obra_id])); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Voltar
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <!--<div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-1"></i> Informações do Capitulo
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="150">Código:</th>
                        <td><span class="badge bg-primary"><?php echo e($atividade->codigo); ?></span></td>
                    </tr>
                    <tr>
                        <th>Nome do Capitulo:</th>
                        <td><?php echo e($atividade->nome); ?></td>
                    </tr>
                    <tr>
                        <th>Modulo:</th>
                        <td>
                            <span class="badge bg-info">
                                <?php echo e($atividade->categoriaObra->codigo); ?> - <?php echo e($atividade->categoriaObra->nome); ?>

                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Unidade:</th>
                        <td><?php echo e($atividade->unidade); ?></td>
                    </tr>
                    <tr>
                        <th>NPI:</th>
                        <td><?php echo e($atividade->npi); ?></td>
                    </tr>
                    <tr>
                        <th>Ordem:</th>
                        <td><?php echo e($atividade->ordem ?? 'Não definida'); ?></td>
                    </tr>
                    <tr>
                        <th>Criado em:</th>
                        <td><?php echo e($atividade->created_at ? $atividade->created_at->format('d/m/Y H:i:s') : '-'); ?></td>
                    </tr>
                    <tr>
                        <th>Atualizado em:</th>
                        <td><?php echo e($atividade->updated_at ? $atividade->updated_at->format('d/m/Y H:i:s') : '-'); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>-->

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="card-title">
                    <i class="fas fa-list mr-1"></i> Atividade
                </h3>
                <div class="card-tools">
                    <a href="<?php echo e(route('subatividades.create', ['atividade_id' => $atividade->id])); ?>" 
                       class="btn btn-sm btn-light">
                        <i class="fas fa-plus"></i> Nova atividade
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Designação</th>
                            <th>Unidade</th>
                            <th>Quant.</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $atividade->subatividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($sub->codigo); ?></td>
                            <td><?php echo e($sub->nome); ?></td>
                            <td><?php echo e($sub->unidade); ?></td>
                            <td class="text-right"><?php echo e(number_format($sub->quantidade_proposta, 2, ',', '.')); ?></td>
                            <td>
                                <a href="<?php echo e(route('subatividades.show', $sub->id)); ?>" class="btn btn-xs btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                            <td>
                                <a href="<?php echo e(route('subatividades.show', $sub->id)); ?>" class="btn btn-xs btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                <i class="fas fa-info-circle mr-1"></i>
                                Nenhuma subatividade cadastrada.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h3 class="card-title">
                    <i class="fas fa-calculator mr-1"></i> Resumo de Custos
                </h3>
            </div>
            <div class="card-body">
                <?php
                    $totalGeral = 0;
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-light">
                                <th>Subatividade</th>
                                <th class="text-right">Quantidade</th>
                                <th class="text-right">Total Materiais</th>
                                <th class="text-right">Total Mão Obra</th>
                                <th class="text-right">Preço Unitário</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $atividade->subatividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $totalGeral += $sub->total;
                            ?>
                            <tr>
                                <td><?php echo e($sub->codigo); ?> - <?php echo e($sub->nome); ?></td>
                                <td class="text-right"><?php echo e(number_format($sub->quantidade_proposta, 2, ',', '.')); ?> <?php echo e($sub->unidade); ?></td>
                                <td class="text-right">MT <?php echo e(number_format($sub->total_materiais, 2, ',', '.')); ?></td>
                                <td class="text-right">MT <?php echo e(number_format($sub->total_mao_obra, 2, ',', '.')); ?></td>
                                <td class="text-right">MT <?php echo e(number_format($sub->preco_unitario, 2, ',', '.')); ?></td>
                                <td class="text-right"><strong>MT <?php echo e(number_format($sub->total, 2, ',', '.')); ?></strong></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr class="bg-success text-white">
                                <th colspan="5" class="text-right">TOTAL DA ATIVIDADE:</th>
                                <th class="text-right">MT <?php echo e(number_format($totalGeral, 2, ',', '.')); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/atividades/show.blade.php ENDPATH**/ ?>