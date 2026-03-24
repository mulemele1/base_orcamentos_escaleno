

<?php $__env->startSection('title', 'Configurações do Sistema'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1><i class="fas fa-cog mr-2"></i>Configurações do Sistema</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Parâmetros Gerais</h3>
            </div>
            <form action="<?php echo e(route('configuracoes.update')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="row mb-4">
                            <div class="col-12">
                                <h4 class="text-primary"><?php echo e(ucfirst($grupo)); ?></h4>
                                <hr>
                            </div>
                            <?php $__currentLoopData = $configuracoes->where('grupo', $grupo); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $config): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label><?php echo e($config->nome); ?>:</label>
                                        <?php if($config->tipo == 'text'): ?>
                                            <input type="text" name="<?php echo e($config->chave); ?>" 
                                                   value="<?php echo e($config->valor); ?>" 
                                                   class="form-control">
                                        <?php elseif($config->tipo == 'number'): ?>
                                            <input type="number" name="<?php echo e($config->chave); ?>" 
                                                   value="<?php echo e($config->valor); ?>" 
                                                   class="form-control" step="0.01">
                                        <?php elseif($config->tipo == 'textarea'): ?>
                                            <textarea name="<?php echo e($config->chave); ?>" 
                                                      class="form-control" rows="3"><?php echo e($config->valor); ?></textarea>
                                        <?php elseif($config->tipo == 'boolean'): ?>
                                            <select name="<?php echo e($config->chave); ?>" class="form-control">
                                                <option value="1" <?php echo e($config->valor == '1' ? 'selected' : ''); ?>>Sim</option>
                                                <option value="0" <?php echo e($config->valor == '0' ? 'selected' : ''); ?>>Não</option>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Salvar Configurações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/configuracoes/index.blade.php ENDPATH**/ ?>