


<?php $__env->startSection('admin-content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-tasks"></i> Actividades
            <?php if($capitulo): ?>
                <small class="text-muted">do capítulo: <?php echo e($capitulo->nome); ?></small>
            <?php endif; ?>
        </h3>
        <div class="card-tools">
            <a href="<?php echo e(route('admin.estrutura.actividade.create', $capitulo ? $capitulo->id : '')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Actividade
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    60d
                        <th style="width: 50px">Ordem</th>
                        <th>Nome</th>
                        <th>Capítulo</th>
                        <th>Descrição</th>
                        <th>Grupos</th>
                        <th>Componentes</th>
                        <th style="width: 150px">Ações</th>
                    </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $actividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    60d
                        <td class="text-center">
                            <span class="badge badge-secondary"><?php echo e($actividade->ordem); ?></span>
                        </td>
                        <td>
                            <strong><?php echo e($actividade->nome); ?></strong>
                        </td>
                        <td>
                            <span class="badge badge-info"><?php echo e($actividade->capitulo->nome ?? '—'); ?></span>
                            <br><small class="text-muted"><?php echo e($actividade->capitulo->modulo->nome ?? ''); ?></small>
                        </td>
                        <td><?php echo e(Str::limit($actividade->descricao, 60)); ?></td>
                        <td class="text-center">
                            <span class="badge badge-warning"><?php echo e($actividade->grupos()->count()); ?></span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-success"><?php echo e($actividade->componentes()->count() + $actividade->grupos->sum(fn($g) => $g->componentes->count())); ?></span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                
                                <?php if($actividade->grupos()->count() > 0): ?>
                                    <a href="<?php echo e(route('admin.estrutura.grupos', $actividade->id)); ?>" class="btn btn-warning" title="Ver grupos">
                                        <i class="fas fa-layer-group"></i>
                                    </a>
                                <?php endif; ?>
                                
                                
                                <a href="<?php echo e(route('admin.estrutura.componentes.por-actividade', $actividade->id)); ?>" class="btn btn-success" title="Ver componentes">
                                    <i class="fas fa-cube"></i>
                                </a>
                                
                                <a href="<?php echo e(route('admin.estrutura.actividade.edit', $actividade->id)); ?>" class="btn btn-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="<?php echo e(route('admin.estrutura.actividade.destroy', $actividade->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger" title="Excluir" onclick="return confirm('Excluir esta actividade?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-tasks fa-3x mb-3 text-muted"></i>
                            <p>Nenhuma actividade cadastrada.</p>
                            <a href="<?php echo e(route('admin.estrutura.actividade.create', $capitulo ? $capitulo->id : '')); ?>" class="btn btn-primary">Criar primeira actividade</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/admin/estrutura/actividades.blade.php ENDPATH**/ ?>