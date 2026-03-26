

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-tasks mr-2"></i>Gerenciar Atividades: <?php echo e($orcamento->codigo); ?></h1>
    <a href="<?php echo e(route('projetos.show', $orcamento->projeto_id)); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar ao Projeto
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus-circle"></i> Adicionar Atividade</h3>
            </div>
            <div class="card-body">
                <?php if($categorias->isEmpty()): ?>
                    <div class="alert alert-warning">
                        Nenhuma categoria cadastrada. <a href="<?php echo e(route('categorias-obra.create')); ?>">Crie uma categoria</a> primeiro.
                    </div>
                <?php else: ?>
                    <form action="<?php echo e(route('orcamentos.atividades.store', $orcamento->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="atividade_id">Selecione uma Atividade</label>
                            <select name="atividade_id" id="atividade_id" class="form-control" required>
                                <option value="">-- Escolha uma atividade --</option>
                                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($categoria->atividades->count() > 0): ?>
                                        <optgroup label="<?php echo e($categoria->codigo); ?> - <?php echo e($categoria->nome); ?>">
                                            <?php $__currentLoopData = $categoria->atividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($atividade->id); ?>">
                                                    <?php echo e($atividade->codigo); ?> - <?php echo e($atividade->nome); ?> (<?php echo e($atividade->unidade); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </optgroup>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Adicionar ao Orçamento
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list-ul"></i> Atividades no Orçamento</h3>
            </div>
            <div class="card-body p-0">
                <?php if($atividadesNoOrcamento->isEmpty()): ?>
                    <div class="text-center p-4">
                        <i class="fas fa-info-circle fa-2x mb-2 text-muted"></i>
                        <p class="text-muted">Nenhuma atividade adicionada a este orçamento.</p>
                    </div>
                <?php else: ?>
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Atividade</th>
                                <th>Categoria</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $atividadesNoOrcamento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($item->atividade->codigo); ?></td>
                                <td><strong><?php echo e($item->atividade->nome); ?></strong></td>
                                <td><?php echo e($item->categoriaObra->codigo); ?> - <?php echo e($item->categoriaObra->nome); ?></td>
                                <td>
                                    <form action="<?php echo e(route('orcamentos.atividades.destroy', [$orcamento->id, $item->atividade_id])); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja remover esta atividade?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/orcamentos/atividades.blade.php ENDPATH**/ ?>