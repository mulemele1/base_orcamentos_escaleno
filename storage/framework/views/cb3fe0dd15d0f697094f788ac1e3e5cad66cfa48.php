<?php $__env->startSection('title', 'Administração - Estrutura'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-sitemap text-primary mr-2"></i>
        Administração da Estrutura
    </h1>
    <div>
        <a href="<?php echo e(route('admin.estrutura.index')); ?>" class="btn btn-info">
            <i class="fas fa-tree"></i> Árvore Completa
        </a>
        <a href="<?php echo e(route('admin.estrutura.modulos')); ?>" class="btn btn-primary">
            <i class="fas fa-layer-group"></i> Módulos
        </a>
        <a href="<?php echo e(route('admin.estrutura.capitulos')); ?>" class="btn btn-secondary">
            <i class="fas fa-book"></i> Capítulos
        </a>
        <a href="<?php echo e(route('admin.estrutura.actividades')); ?>" class="btn btn-success">
            <i class="fas fa-tasks"></i> Actividades
        </a>
        <a href="<?php echo e(route('admin.estrutura.grupos')); ?>" class="btn btn-warning">
            <i class="fas fa-layer-group"></i> Grupos
        </a>
        
        <a href="<?php echo e(route('admin.estrutura.componentes.todos')); ?>" class="btn btn-danger">
            <i class="fas fa-cube"></i> Componentes
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> <?php echo e(session('error')); ?>

                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        <?php endif; ?>
        
        <?php echo $__env->yieldContent('admin-content'); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Alvaro_Martins\Escaleno\base_orcamentos_escaleno\resources\views/admin/layouts/admin.blade.php ENDPATH**/ ?>