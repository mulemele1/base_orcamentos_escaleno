

<?php $__env->startSection('title', 'Orçamentos'); ?>

<?php $__env->startSection('content_header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-file-invoice-dollar mr-2"></i>Orçamentos</h1>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Orçamentos</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    60d
                        <th>Código</th>
                        <th>Projeto</th>
                        <th>Cliente</th>
                        <th>Data Emissão</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $orcamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orcamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($orcamento->codigo); ?></td>
                        <td><?php echo e($orcamento->nome_projeto); ?></td>
                        <td><?php echo e($orcamento->cliente); ?></td>
                        <td><?php echo e($orcamento->data_emissao->format('d/m/Y')); ?></td>
                        <td>
                            <span class="badge badge-secondary"><?php echo e($orcamento->status); ?></span>
                        </td>
                        <td class="text-right">MT <?php echo e(number_format($orcamento->grand_total, 2, ',', '.')); ?></td>
                        <td>
                            <a href="<?php echo e(route('orcamentos.show', $orcamento->id)); ?>" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo e(route('orcamentos.pdf', $orcamento->id)); ?>" class="btn btn-sm btn-danger">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                            <p>Nenhum orçamento cadastrado.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <?php echo e($orcamentos->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/orcamentos/index.blade.php ENDPATH**/ ?>