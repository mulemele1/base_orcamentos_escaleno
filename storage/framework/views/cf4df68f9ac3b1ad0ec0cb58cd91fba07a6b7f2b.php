<?php $__env->startSection('title', 'Medição - ' . $projeto->nome); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>
                <i class="fas fa-ruler-combined text-primary mr-2"></i>
                Medição: <?php echo e($projeto->nome); ?>

            </h1>
            <small class="text-muted">Registre as medições físicas do projeto</small>
        </div>
        <div>
            <a href="<?php echo e(route('projetos.show', $projeto)); ?>" class="btn btn-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            <?php if($componentesMedidos == $totalComponentes && $totalComponentes > 0): ?>
                <form action="<?php echo e(route('medicoes.finalizar', $projeto)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <button type="submit" class="btn btn-success" onclick="return confirm('Todas as medições foram realizadas?')">
                        <i class="fas fa-check-circle"></i> Finalizar Medição
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    
    
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-progress"></i> Progresso da Medição
            </h3>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                             style="width: <?php echo e($progresso); ?>%">
                            <?php echo e($progresso); ?>%
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <span class="badge badge-primary badge-lg p-2">
                        <i class="fas fa-check-circle"></i> <?php echo e($componentesMedidos); ?>/<?php echo e($totalComponentes); ?> componentes medidos
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-sitemap"></i> Estrutura do Projeto
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="tree-view">
                <?php $__currentLoopData = $estrutura; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="modulo mb-3">
                        <div class="modulo-header bg-light p-2 rounded" style="cursor: pointer;" onclick="toggleModulo(this)">
                            <i class="fas fa-folder-open text-primary mr-2"></i>
                            <strong><?php echo e($modulo->nome); ?></strong>
                            <span class="badge badge-info float-right">
                                <i class="fas fa-chart-line"></i> 
                                <?php echo e($modulo->capitulos->sum(function($c) { 
                                    return $c->actividades->sum(function($a) { 
                                        return $a->componentes->count() + $a->grupos->sum(function($g) { 
                                            return $g->componentes->count(); 
                                        }); 
                                    }); 
                                })); ?> componentes
                            </span>
                        </div>
                        <div class="modulo-content ml-4 mt-2" style="display: block;">
                            <?php $__currentLoopData = $modulo->capitulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $capitulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="capitulo mb-2">
                                    <div class="capitulo-header text-muted" style="cursor: pointer;" onclick="toggleCapitulo(this)">
                                        <i class="fas fa-book mr-2"></i>
                                        <strong><?php echo e($capitulo->nome); ?></strong>
                                        <span class="badge badge-secondary float-right">
                                            <?php echo e($capitulo->actividades->sum(function($a) { 
                                                return $a->componentes->count() + $a->grupos->sum(function($g) { 
                                                    return $g->componentes->count(); 
                                                }); 
                                            })); ?> itens
                                        </span>
                                    </div>
                                    <div class="capitulo-content ml-4 mt-1" style="display: block;">
                                        <?php $__currentLoopData = $capitulo->actividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="actividade mb-2">
                                                <div class="actividade-header text-info" style="cursor: pointer;" onclick="toggleActividade(this)">
                                                    <i class="fas fa-tasks mr-2"></i>
                                                    <strong><?php echo e(Str::limit($actividade->nome, 80)); ?></strong>
                                                    <span class="badge badge-light float-right">
                                                        <?php echo e($actividade->componentes->count() + $actividade->grupos->sum(function($g) { 
                                                            return $g->componentes->count(); 
                                                        })); ?> componentes
                                                    </span>
                                                </div>
                                                <div class="actividade-content ml-4 mt-1" style="display: block;">
                                                    
                                                    <?php if($actividade->grupos->isNotEmpty()): ?>
                                                        <?php $__currentLoopData = $actividade->grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="grupo mb-2">
                                                                <div class="grupo-header" style="cursor: pointer;" onclick="toggleGrupo(this)">
                                                                    <i class="fas fa-layer-group text-warning mr-2"></i>
                                                                    <strong><?php echo e($grupo->nome); ?></strong>
                                                                    <span class="badge badge-secondary float-right">
                                                                        <?php echo e($grupo->componentes->count()); ?> componentes
                                                                    </span>
                                                                </div>
                                                                <div class="grupo-content ml-4 mt-1" style="display: block;">
                                                                    <?php $__currentLoopData = $grupo->componentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $componente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php
                                                                            $medicao = $medicoesPorComponente->get($componente->id) ? $medicoesPorComponente->get($componente->id)->first() : null;
                                                                        ?>
                                                                        <?php echo $__env->make('medicoes.partials.componente-item', [
                                                                            'componente' => $componente,
                                                                            'medicao' => $medicao,
                                                                            'projeto' => $projeto
                                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                    
                                                    <?php $__currentLoopData = $actividade->componentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $componente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                            $medicao = $medicoesPorComponente->get($componente->id) ? $medicoesPorComponente->get($componente->id)->first() : null;
                                                        ?>
                                                        <?php echo $__env->make('medicoes.partials.componente-item', [
                                                            'componente' => $componente,
                                                            'medicao' => $medicao,
                                                            'projeto' => $projeto
                                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .tree-view {
        max-height: 70vh;
        overflow-y: auto;
    }
    .modulo-header, .capitulo-header, .actividade-header, .grupo-header {
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.2s;
    }
    .modulo-header:hover, .capitulo-header:hover, .actividade-header:hover, .grupo-header:hover {
        background-color: #f8f9fa;
    }
    .componente-item {
        padding: 8px 12px;
        border-left: 3px solid #dee2e6;
        margin-bottom: 5px;
        transition: all 0.2s;
        background: white;
        border-radius: 4px;
    }
    .componente-item:hover {
        background-color: #fef9e6;
        border-left-color: #ffc107;
    }
    .componente-medido {
        border-left-color: #28a745;
        background-color: #e8f5e9;
    }
    .badge-lg {
        font-size: 14px;
        padding: 8px 15px;
    }
</style>
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Alvaro_Martins\Escaleno\base_orcamentos_escaleno\resources\views/medicoes/dashboard.blade.php ENDPATH**/ ?>