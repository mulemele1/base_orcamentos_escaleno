<?php $__env->startSection('admin-content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-book"></i> Capítulos
            <?php if($modulo): ?>
                <small class="text-muted">do módulo: <?php echo e($modulo->nome); ?></small>
            <?php endif; ?>
        </h3>
        <div class="card-tools">
            <a href="<?php echo e(route('admin.estrutura.capitulo.create', $modulo ? $modulo->id : '')); ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Capítulo
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
                        <th>Módulo</th>
                        <th>Descrição</th>
                        <th>Actividades</th>
                        <th>Criado em</th>
                        <th style="width: 100px">Ações</th>
                    </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $capitulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $capitulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-center">
                            <span class="badge badge-secondary"><?php echo e($capitulo->ordem); ?></span>
                        </td>
                        <td>
                            <strong><?php echo e($capitulo->nome); ?></strong>
                        </td>
                        <td>
                            <span class="badge badge-info"><?php echo e($capitulo->modulo->nome ?? '—'); ?></span>
                        </td>
                        <td><?php echo e(Str::limit($capitulo->descricao, 50) ?? '—'); ?></td>
                        <td>
                            <span class="badge badge-success"><?php echo e($capitulo->actividades()->count()); ?></span>
                        </td>
                        <td><?php echo e($capitulo->created_at ? $capitulo->created_at->format('d/m/Y') : '—'); ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('admin.estrutura.actividades', $capitulo->id)); ?>" class="btn btn-info" title="Ver actividades">
                                    <i class="fas fa-tasks"></i>
                                </a>
                                <a href="<?php echo e(route('admin.estrutura.capitulo.edit', $capitulo->id)); ?>" class="btn btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('admin.estrutura.capitulo.destroy', $capitulo->id)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger" title="Excluir" onclick="return confirm('Excluir este capítulo?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-book-open fa-3x mb-3 text-muted"></i>
                            <p>Nenhum capítulo cadastrado.</p>
                            <a href="<?php echo e(route('admin.estrutura.capitulo.create', $modulo ? $modulo->id : '')); ?>" class="btn btn-primary">Criar primeiro capítulo</a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Alvaro_Martins\Escaleno\base_orcamentos_escaleno\resources\views/admin/estrutura/capitulos.blade.php ENDPATH**/ ?>