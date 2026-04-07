<?php $__env->startSection('title', 'Meus Projetos'); ?>

<?php $__env->startSection('content_header'); ?>
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <i class="fas fa-project-diagram text-primary mr-2"></i>
            Meus Projetos
        </h1>
        <a href="<?php echo e(route('projetos.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Projeto
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if($projetos->isEmpty()): ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-folder-open fa-4x mb-3 text-muted"></i>
                <h5>Nenhum projeto cadastrado</h5>
                <p class="text-muted">Clique no botão abaixo para criar seu primeiro projeto</p>
                <a href="<?php echo e(route('projetos.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Criar Projeto
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <?php $__currentLoopData = $projetos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $projeto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-building text-primary"></i>
                                    <?php echo e(Str::limit($projeto->nome, 30)); ?>

                                </h5>
                                <span class="badge badge-<?php echo e($projeto->status == 'concluido' ? 'success' : ($projeto->status == 'orcamento' ? 'warning' : ($projeto->status == 'medicao' ? 'info' : 'secondary'))); ?>">
                                    <?php echo e($projeto->status_formatado); ?>

                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if($projeto->cliente): ?>
                                <p class="mb-1">
                                    <i class="fas fa-user text-muted"></i>
                                    <small><?php echo e($projeto->cliente); ?></small>
                                </p>
                            <?php endif; ?>
                            <?php if($projeto->localizacao): ?>
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt text-muted"></i>
                                    <small><?php echo e(Str::limit($projeto->localizacao, 40)); ?></small>
                                </p>
                            <?php endif; ?>
                            
                            <div class="mt-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Progresso da Medição</small>
                                    <small class="text-primary"><?php echo e($projeto->progresso_medicao); ?>%</small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar progress-bar-striped bg-success" 
                                         style="width: <?php echo e($projeto->progresso_medicao); ?>%"></div>
                                </div>
                            </div>
                            
                            <?php if($projeto->valor_total > 0): ?>
                                <div class="mt-3 pt-2 border-top">
                                    <div class="text-right">
                                        <small class="text-muted">Valor Total</small>
                                        <h5 class="mb-0 text-success">
                                            MT <?php echo e(number_format($projeto->valor_total, 2, ',', '.')); ?>

                                        </h5>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="btn-group btn-group-sm w-100">
                                <a href="<?php echo e(route('projetos.show', $projeto)); ?>" class="btn btn-info" title="Ver detalhes">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="<?php echo e(route('projetos.edit', $projeto)); ?>" class="btn btn-primary" title="Editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
<?php if($projeto->status == 'rascunho' || $projeto->status == 'medicao'): ?>
    <a href="<?php echo e(route('medicoes.dashboard', ['projeto' => $projeto->id])); ?>" class="btn btn-success" title="Iniciar Medição">
        <i class="fas fa-ruler-combined"></i> Medir
    </a>
<?php endif; ?>
                                <?php if($projeto->status == 'orcamento' && $projeto->orcamentos->isEmpty()): ?>
                                    <a href="<?php echo e(route('orcamentos.gerar', $projeto)); ?>" class="btn btn-warning" title="Gerar Orçamento">
                                        <i class="fas fa-chart-line"></i> Orçar
                                    </a>
                                <?php endif; ?>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-<?php echo e($projeto->id); ?>" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="modal fade" id="modal-delete-<?php echo e($projeto->id); ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirmar exclusão</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Tem certeza que deseja excluir o projeto <strong><?php echo e($projeto->nome); ?></strong>?</p>
                                <p class="text-danger">Esta ação não poderá ser desfeita.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <form action="<?php echo e(route('projetos.destroy', $projeto)); ?>" method="POST" class="d-inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="mt-3">
            <?php echo e($projetos->links()); ?>

        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/projetos/index.blade.php ENDPATH**/ ?>