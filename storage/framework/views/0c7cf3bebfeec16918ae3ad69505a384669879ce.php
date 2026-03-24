

<?php $__env->startSection('title', 'Composição de Custos'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-cubes mr-2"></i>Composição de Custos</h1>
    <a href="<?php echo e(route('composicoes.create', ['subatividade_id' => $subatividadeId])); ?>" class="btn btn-success">
        <i class="fas fa-plus mr-1"></i> Adicionar Material
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <form method="GET" action="<?php echo e(route('composicoes.index')); ?>" class="form-inline">
                        <div class="input-group mr-2" style="width: 500px;">
                            <select name="subatividade_id" class="form-control">
                                <option value="">Todas as Subatividades</option>
                                <?php $__currentLoopData = $subatividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($sub->id); ?>" <?php echo e($subatividadeId == $sub->id ? 'selected' : ''); ?>>
                                        <?php echo e($sub->atividade->categoriaObra->codigo); ?>.<?php echo e($sub->atividade->codigo); ?>.<?php echo e($sub->codigo); ?> - <?php echo e($sub->nome); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Subatividade</th>
                            <th>Material</th>
                            <th width="100">Quantidade</th>
                            <th width="80">Unidade</th>
                            <th width="120">Custo Unit. (MT)</th>
                            <th width="120">Custo Total (MT)</th>
                            <th width="100">Tipo</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $composicoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td>
                                <small class="text-muted">
                                    <?php echo e($comp->subatividade->atividade->categoriaObra->codigo); ?>.
                                    <?php echo e($comp->subatividade->atividade->codigo); ?>.
                                    <?php echo e($comp->subatividade->codigo); ?>

                                </small>
                                <br>
                                <span class="badge bg-info"><?php echo e(Str::limit($comp->subatividade->nome, 30)); ?></span>
                            </td>
                            <td>
                                <strong><?php echo e($comp->material->nome ?? 'N/A'); ?></strong>
                                <br>
                                <small class="text-muted">Cód: <?php echo e($comp->material->codigo ?? '-'); ?></small>
                            </td>
                            <td class="text-right"><?php echo e(number_format($comp->quantidade, 3, ',', '.')); ?></td>
                            <td><?php echo e($comp->unidade); ?></td>
                            <td class="text-right">MT <?php echo e(number_format($comp->custo_unitario, 2, ',', '.')); ?></td>
                            <td class="text-right"><strong>MT <?php echo e(number_format($comp->custo_total, 2, ',', '.')); ?></strong></td>
                            <td>
                                <?php if($comp->tipo == 'material'): ?>
                                    <span class="badge bg-primary">Material</span>
                                <?php elseif($comp->tipo == 'mao_obra'): ?>
                                    <span class="badge bg-success">Mão de Obra</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Equipamento</span>
                                <?php endif; ?>
                                <?php if($comp->tipo == 'material' && $comp->mao_obra_percentual > 0): ?>
                                    <br><small class="text-muted">Mão obra: <?php echo e($comp->mao_obra_percentual); ?>%</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('composicoes.edit', $comp->id)); ?>" 
                                       class="btn btn-sm btn-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete(<?php echo e($comp->id); ?>)"
                                            title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-<?php echo e($comp->id); ?>" 
                                      action="<?php echo e(route('composicoes.destroy', $comp->id)); ?>" 
                                      method="POST" 
                                      style="display: none;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle mr-1"></i>
                                Nenhum material vinculado.
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($composicoes->hasPages()): ?>
            <div class="card-footer clearfix">
                <div class="float-right">
                    <?php echo e($composicoes->appends(request()->query())->links()); ?>

                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if($subatividadeId): ?>
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success">
                <h3 class="card-title">Resumo da Subatividade</h3>
            </div>
            <div class="card-body">
                <?php
                    $sub = $subatividades->find($subatividadeId);
                ?>
                <?php if($sub): ?>
                <table class="table">
                    <tr>
                        <th>Subatividade:</th>
                        <td><?php echo e($sub->codigo); ?> - <?php echo e($sub->nome); ?></td>
                    </tr>
                    <tr>
                        <th>Quantidade Proposta:</th>
                        <td><?php echo e(number_format($sub->quantidade_proposta, 2, ',', '.')); ?> <?php echo e($sub->unidade); ?></td>
                    </tr>
                    <tr>
                        <th>Total Materiais:</th>
                        <td>MT <?php echo e(number_format($sub->total_materiais, 2, ',', '.')); ?></td>
                    </tr>
                    <tr>
                        <th>Total Mão Obra:</th>
                        <td>MT <?php echo e(number_format($sub->total_mao_obra, 2, ',', '.')); ?></td>
                    </tr>
                    <tr class="bg-light">
                        <th>Preço Unitário:</th>
                        <td><strong>MT <?php echo e(number_format($sub->preco_unitario, 2, ',', '.')); ?></strong></td>
                    </tr>
                    <tr class="bg-success text-white">
                        <th>TOTAL:</th>
                        <td><strong>MT <?php echo e(number_format($sub->total, 2, ',', '.')); ?></strong></td>
                    </tr>
                </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
function confirmDelete(id) {
    if (confirm('Tem certeza que deseja remover este material da composição?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/composicoes/index.blade.php ENDPATH**/ ?>