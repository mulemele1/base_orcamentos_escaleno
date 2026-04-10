<?php $__env->startSection('admin-content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-layer-group"></i> Grupos
            <?php if($actividade): ?>
                <small class="text-muted">da actividade: <?php echo e($actividade->nome); ?></small>
            <?php endif; ?>
        </h3>
        <div class="card-tools">
            <a href="<?php echo e(route('admin.estrutura.grupo.create', $actividade ? $actividade->id : '')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Grupo
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px">Ordem</th>
                        <th>Nome</th>
                        <th>Actividade</th>
                        <th>Unidade Padrão</th>
                        <th>Componentes</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center">
                            <span class="badge badge-secondary"><?php echo e($grupo->ordem); ?></span>
                        </td>
                        <td>
                            <strong><?php echo e($grupo->nome); ?></strong>
                        </td>
                        <td>
                            <span class="badge badge-info"><?php echo e(Str::limit($grupo->actividade->nome, 40)); ?></span>
                            <br><small class="text-muted"><?php echo e($grupo->actividade->capitulo->modulo->nome ?? ''); ?></small>
                        </td>
                        <td>
                            <span class="badge badge-success"><?php echo e($grupo->unidade_padrao); ?></span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-warning"><?php echo e($grupo->componentes()->count()); ?></span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                
                                <a href="<?php echo e(route('admin.estrutura.componentes.por-grupo', $grupo->id)); ?>" class="btn btn-success" title="Ver componentes">
                                    <i class="fas fa-cube"></i>
                                </a>
                                
                                <a href="<?php echo e(route('admin.estrutura.grupo.edit', $grupo->id)); ?>" class="btn btn-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="<?php echo e(route('admin.estrutura.grupo.destroy', $grupo->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger" title="Excluir" onclick="return confirm('Excluir este grupo?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-layer-group fa-3x mb-3 text-muted"></i>
                            <p>Nenhum grupo cadastrado.</p>
                            <a href="<?php echo e(route('admin.estrutura.grupo.create', $actividade ? $actividade->id : '')); ?>" class="btn btn-primary">Criar primeiro grupo</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Alvaro_Martins\Escaleno\base_orcamentos_escaleno\resources\views/admin/estrutura/grupos.blade.php ENDPATH**/ ?>