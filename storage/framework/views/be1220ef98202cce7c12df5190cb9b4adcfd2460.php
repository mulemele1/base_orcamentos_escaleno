

<?php $__env->startSection('title', 'Atividades'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-tasks mr-2"></i>Atividades</h1>
    <a href="<?php echo e(route('atividades.create', ['categoria_id' => request('categoria_id')])); ?>" class="btn btn-success">
        <i class="fas fa-plus mr-1"></i> Nova Atividade
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
                        <h3 class="card-title">Lista de Atividades</h3>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="<?php echo e(route('atividades.index')); ?>" class="form-inline justify-content-end">
                            <div class="form-group mr-2">
                                <select name="categoria_id" class="form-control" id="categoriaSelect" style="min-width: 250px;">
                                    <option value="">Todas as Categorias</option>
                                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($categoria->id); ?>" 
                                            <?php echo e(request('categoria_id') == $categoria->id ? 'selected' : ''); ?>>
                                            <?php echo e($categoria->codigo); ?> - <?php echo e($categoria->nome); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php if(request('categoria_id')): ?>
                                <a href="<?php echo e(route('atividades.index')); ?>" class="btn btn-secondary">
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
                            <th>Nome da Atividade</th>
                            <th width="100">Unidade</th>
                            <th width="80">NPI</th>
                            <th width="200">Categoria</th>
                            <th width="120">Subatividades</th>
                            <th width="80">Ordem</th>
                            <th width="250">Ações</th>
                        </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $atividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        2d
                            <td><span class="badge bg-primary"><?php echo e($atividade->codigo); ?></span></td>
                            <td><?php echo e($atividade->nome); ?></td>
                            <td><?php echo e($atividade->unidade ?: 'Vg'); ?></td>
                            <td class="text-center"><?php echo e($atividade->npi ?: 1); ?></td>
                            <td>
                                <?php if($atividade->categoriaObra): ?>
                                    <span class="badge bg-info">
                                        <?php echo e($atividade->categoriaObra->codigo); ?> - <?php echo e($atividade->categoriaObra->nome); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Sem categoria</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success"><?php echo e($atividade->subatividades_count); ?></span>
                            </td>
                            <td class="text-center"><?php echo e($atividade->ordem ?: '-'); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?php echo e(route('atividades.show', $atividade->id)); ?>" 
                                       class="btn btn-sm btn-info" 
                                       title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('atividades.edit', $atividade->id)); ?>" 
                                       class="btn btn-sm btn-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo e(route('subatividades.index', ['atividade_id' => $atividade->id])); ?>" 
                                       class="btn btn-sm btn-primary" 
                                       title="Ver subatividades">
                                        <i class="fas fa-list"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete(<?php echo e($atividade->id); ?>, '<?php echo e(addslashes($atividade->nome)); ?>')"
                                            title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-<?php echo e($atividade->id); ?>" 
                                      action="<?php echo e(route('atividades.destroy', $atividade->id)); ?>" 
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
                                Nenhuma atividade encontrada.
                                <?php if(request('categoria_id')): ?>
                                    <a href="<?php echo e(route('atividades.index')); ?>" class="btn btn-sm btn-primary ml-2">
                                        <i class="fas fa-times"></i> Limpar filtro
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($atividades->hasPages()): ?>
            <div class="card-footer clearfix">
                <div class="float-right">
                    <?php echo e($atividades->appends(request()->query())->links()); ?>

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
    if (confirm('Tem certeza que deseja excluir a atividade "' + nome + '"?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// FILTRO AUTOMÁTICO AO SELECIONAR
document.getElementById('categoriaSelect').addEventListener('change', function() {
    const url = new URL(window.location.href);
    if (this.value) {
        url.searchParams.set('categoria_id', this.value);
    } else {
        url.searchParams.delete('categoria_id');
    }
    window.location.href = url.toString();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/atividades/index.blade.php ENDPATH**/ ?>