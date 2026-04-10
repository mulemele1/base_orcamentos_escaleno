<?php $__env->startSection('admin-content'); ?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-tree"></i> Árvore Hierárquica Completa
        </h3>
    </div>
    <div class="card-body">
        <div class="tree-view">
            <?php $__currentLoopData = $modulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="modulo mb-3">
                    <div class="modulo-header bg-primary text-white p-2 rounded" style="cursor: pointer;" onclick="toggleModulo(this)">
                        <i class="fas fa-folder-open mr-2"></i>
                        <strong><?php echo e($modulo->ordem); ?>. <?php echo e($modulo->nome); ?></strong>
                        <span class="badge badge-light float-right"><?php echo e($modulo->capitulos->count()); ?> capítulos</span>
                    </div>
                    <div class="modulo-content ml-4 mt-2" style="display: block;">
                        <?php $__currentLoopData = $modulo->capitulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $capitulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="capitulo mb-2">
                                <div class="capitulo-header bg-secondary text-white p-2 rounded" style="cursor: pointer;" onclick="toggleCapitulo(this)">
                                    <i class="fas fa-book mr-2"></i>
                                    <strong><?php echo e($modulo->ordem); ?>.<?php echo e($capitulo->ordem); ?> - <?php echo e($capitulo->nome); ?></strong>
                                    <span class="badge badge-light float-right"><?php echo e($capitulo->actividades->count()); ?> actividades</span>
                                </div>
                                <div class="capitulo-content ml-4 mt-2" style="display: block;">
                                    <?php $__currentLoopData = $capitulo->actividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="actividade mb-2">
                                            <div class="actividade-header bg-info text-white p-2 rounded" style="cursor: pointer;" onclick="toggleActividade(this)">
                                                <i class="fas fa-tasks mr-2"></i>
                                                <strong><?php echo e($modulo->ordem); ?>.<?php echo e($capitulo->ordem); ?>.<?php echo e($actividade->ordem); ?> - <?php echo e(Str::limit($actividade->nome, 80)); ?></strong>
                                                <span class="badge badge-light float-right">
                                                    <?php echo e($actividade->componentes->count() + $actividade->grupos->sum(fn($g) => $g->componentes->count())); ?> componentes
                                                </span>
                                            </div>
                                            <div class="actividade-content ml-4 mt-2" style="display: block;">
                                                
                                                <?php if($actividade->grupos->isNotEmpty()): ?>
                                                    <?php $__currentLoopData = $actividade->grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <div class="grupo mb-2">
                                                            <div class="grupo-header bg-warning p-2 rounded" style="cursor: pointer;" onclick="toggleGrupo(this)">
                                                                <i class="fas fa-layer-group mr-2"></i>
                                                                <strong><?php echo e($modulo->ordem); ?>.<?php echo e($capitulo->ordem); ?>.<?php echo e($actividade->ordem); ?>.<?php echo e($grupo->ordem); ?> - <?php echo e($grupo->nome); ?></strong>
                                                                <span class="badge badge-dark float-right"><?php echo e($grupo->componentes->count()); ?> componentes</span>
                                                            </div>
                                                            <div class="grupo-content ml-4 mt-2" style="display: block;">
                                                                <?php $__currentLoopData = $grupo->componentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $componente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <div class="componente p-2 mb-1 border rounded">
                                                                        <div class="d-flex justify-content-between">
                                                                            <div>
                                                                                <i class="fas fa-cube text-success mr-2"></i>
                                                                                <strong><?php echo e($componente->nome); ?></strong>
                                                                                <span class="badge badge-secondary ml-2"><?php echo e($componente->unidade); ?></span>
                                                                                <span class="badge badge-info ml-1"><?php echo e($componente->formula_calculo); ?></span>
                                                                                <?php if($componente->perda_padrao > 0): ?>
                                                                                    <span class="badge badge-warning ml-1">Perda: <?php echo e($componente->perda_padrao); ?>%</span>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                            <div>
                                                                                <a href="<?php echo e(route('admin.estrutura.componente.edit', $componente->id)); ?>" class="btn btn-sm btn-primary">
                                                                                    <i class="fas fa-edit"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                                
                                                <?php $__currentLoopData = $actividade->componentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $componente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="componente p-2 mb-1 border rounded">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <i class="fas fa-cube text-success mr-2"></i>
                                                                <strong><?php echo e($componente->nome); ?></strong>
                                                                <span class="badge badge-secondary ml-2"><?php echo e($componente->unidade); ?></span>
                                                                <span class="badge badge-info ml-1"><?php echo e($componente->formula_calculo); ?></span>
                                                                <?php if($componente->perda_padrao > 0): ?>
                                                                    <span class="badge badge-warning ml-1">Perda: <?php echo e($componente->perda_padrao); ?>%</span>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div>
                                                                <a href="<?php echo e(route('admin.estrutura.componente.edit', $componente->id)); ?>" class="btn btn-sm btn-primary">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    function toggleModulo(element) {
        const content = element.nextElementSibling;
        const icon = element.querySelector('.fas');
        if (content.style.display === 'none') {
            content.style.display = 'block';
            icon.classList.remove('fa-folder');
            icon.classList.add('fa-folder-open');
        } else {
            content.style.display = 'none';
            icon.classList.remove('fa-folder-open');
            icon.classList.add('fa-folder');
        }
    }
    
    function toggleCapitulo(element) {
        const content = element.nextElementSibling;
        const icon = element.querySelector('.fas');
        if (content.style.display === 'none') {
            content.style.display = 'block';
            icon.classList.remove('fa-book');
            icon.classList.add('fa-book-open');
        } else {
            content.style.display = 'none';
            icon.classList.remove('fa-book-open');
            icon.classList.add('fa-book');
        }
    }
    
    function toggleActividade(element) {
        const content = element.nextElementSibling;
        if (content.style.display === 'none') {
            content.style.display = 'block';
        } else {
            content.style.display = 'none';
        }
    }
    
    function toggleGrupo(element) {
        const content = element.nextElementSibling;
        if (content.style.display === 'none') {
            content.style.display = 'block';
        } else {
            content.style.display = 'none';
        }
    }
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .tree-view {
        max-height: 80vh;
        overflow-y: auto;
    }
    .modulo-header, .capitulo-header, .actividade-header, .grupo-header {
        transition: all 0.2s;
        cursor: pointer;
    }
    .modulo-header:hover, .capitulo-header:hover, .actividade-header:hover, .grupo-header:hover {
        filter: brightness(0.95);
    }
    .componente {
        background-color: #f8f9fa;
        transition: all 0.2s;
    }
    .componente:hover {
        background-color: #e9ecef;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Alvaro_Martins\Escaleno\base_orcamentos_escaleno\resources\views/admin/estrutura/index.blade.php ENDPATH**/ ?>