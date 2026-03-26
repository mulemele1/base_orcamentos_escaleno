<?php $__env->startSection('content_header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-project-diagram mr-2"></i>Projetos</h1>
        <a href="<?php echo e(route('projetos.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Projeto
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Projetos</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cliente</th>
                        <th>Localização</th>
                        <th>Status</th>
                        <th>Valor Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projeto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($projeto->id); ?></td>
                        <td>
                            <strong><?php echo e($projeto->nome); ?></strong>
                            <?php if($projeto->template): ?>
                                <br><small class="text-muted">Template: <?php echo e($projeto->template->nome); ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($projeto->cliente); ?></td>
                        <td><?php echo e($projeto->localizacao); ?></td>
                        <td>
                            <?php
                                $statusColors = [
                                    'planeamento' => 'info',
                                    'em_andamento' => 'warning',
                                    'concluido' => 'success',
                                    'suspenso' => 'danger',
                                ];
                            ?>
                            <span class="badge badge-<?php echo e($statusColors[$projeto->status]); ?>">
                                <?php echo e($projeto->status_formatado); ?>

                            </span>
                        </td>
                        <td class="text-right">
                            <strong>MT <?php echo e(number_format($projeto->valor_total, 2, ',', '.')); ?></strong>
                        </td>
                        <td>
                            <a href="<?php echo e(route('projetos.show', $projeto->id)); ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('projetos.edit', $projeto->id)); ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="<?php echo e(route('projetos.destroy', $projeto->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                            <p>Nenhum projeto cadastrado.</p>
                            <a href="<?php echo e(route('projetos.create')); ?>" class="btn btn-primary">Criar primeiro projeto</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <?php echo e($projetos->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/projetos/index.blade.php ENDPATH**/ ?>