

<?php $__env->startSection('title', 'Actividades'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-list-alt mr-2"></i>Actividades</h1>
    <a href="<?php echo e(route('subatividades.create', ['atividade_id' => request('atividade_id')])); ?>" class="btn btn-success">
        <i class="fas fa-plus mr-1"></i> Nova Actividade
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title">
                            <?php if(request('atividade_id') && isset($atividadeSelecionada)): ?>
                                <span class="badge bg-info">
                                    Actividade: <?php echo e($atividadeSelecionada->categoriaObra->codigo); ?>.<?php echo e($atividadeSelecionada->codigo); ?> - <?php echo e($atividadeSelecionada->nome); ?>

                                </span>
                            <?php else: ?>
                                Lista de Actividades
                            <?php endif; ?>
                        </h3>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="<?php echo e(route('subatividades.index')); ?>" class="form-inline justify-content-end">
                            <div class="form-group mr-2">
                                <select name="atividade_id" class="form-control" id="atividadeSelect" style="min-width: 300px;">
                                    <option value="">Todas as Atividades</option>
                                    <?php $__currentLoopData = $atividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($atividade->id); ?>" <?php echo e(request('atividade_id') == $atividade->id ? 'selected' : ''); ?>>
                                            <?php echo e($atividade->categoriaObra->codigo); ?>.<?php echo e($atividade->codigo); ?> - <?php echo e($atividade->nome); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php if(request('atividade_id')): ?>
                                <a href="<?php echo e(route('subatividades.index')); ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Limpar
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        60d
                            <th width="80">Código</th>
                            <th>Nome</th>
                            <th width="80">Unidade</th>
                            <th width="120">Quant. Proposta</th>
                            <th width="220">Ações</th>
                        </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $subatividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><span class="badge bg-primary"><?php echo e($sub->codigo); ?></span></td>
                            <td><?php echo e(Str::limit($sub->nome, 50)); ?></td>
                            <td><?php echo e($sub->unidade); ?></td>
                            
                            <td class="text-right"><strong><?php echo e(number_format($sub->quantidade_proposta, 2, ',', '.')); ?></strong></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('subatividades.show', $sub->id)); ?>" 
                                       class="btn btn-sm btn-info" 
                                       title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('subatividades.edit', $sub->id)); ?>" 
                                       class="btn btn-sm btn-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo e(route('composicoes.index', ['subatividade_id' => $sub->id])); ?>" 
                                       class="btn btn-sm btn-primary" 
                                       title="Composição de custos">
                                        <i class="fas fa-cubes"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete(<?php echo e($sub->id); ?>, '<?php echo e(addslashes($sub->nome)); ?>')"
                                            title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-<?php echo e($sub->id); ?>" 
                                      action="<?php echo e(route('subatividades.destroy', $sub->id)); ?>" 
                                      method="POST" 
                                      style="display: none;">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle mr-1"></i>
                                Nenhuma subatividade encontrada.
                                <?php if(request('atividade_id')): ?>
                                    <a href="<?php echo e(route('subatividades.index')); ?>" class="btn btn-sm btn-primary ml-2">
                                        <i class="fas fa-times"></i> Limpar filtro
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($subatividades->hasPages()): ?>
            <div class="card-footer clearfix">
                <div class="float-right">
                    <?php echo e($subatividades->appends(request()->query())->links()); ?>

                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
function confirmDelete(id, nome) {
    if (confirm('Tem certeza que deseja excluir a subatividade "' + nome + '"?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// FILTRO AUTOMÁTICO AO SELECIONAR
document.getElementById('atividadeSelect').addEventListener('change', function() {
    const url = new URL(window.location.href);
    if (this.value) {
        url.searchParams.set('atividade_id', this.value);
    } else {
        url.searchParams.delete('atividade_id');
    }
    window.location.href = url.toString();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/subatividades/index.blade.php ENDPATH**/ ?>