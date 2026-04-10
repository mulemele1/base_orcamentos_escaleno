<?php $__env->startSection('admin-content'); ?>

<div class="mb-3">
    <?php if($grupo): ?>
        <a href="<?php echo e(route('admin.estrutura.grupos', $grupo->actividade_id)); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar para Grupos
        </a>
    <?php elseif($actividade): ?>
        <a href="<?php echo e(route('admin.estrutura.actividades', $actividade->capitulo_id)); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar para Actividades
        </a>
    <?php else: ?>
        <a href="<?php echo e(route('admin.estrutura.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    <?php endif; ?>
</div>


<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-cube"></i> Componentes
            <?php if($grupo): ?>
                <small class="text-muted">do grupo: <strong><?php echo e($grupo->nome); ?></strong></small>
            <?php elseif($actividade): ?>
                <small class="text-muted">da actividade: <strong><?php echo e($actividade->nome); ?></strong></small>
            <?php endif; ?>
        </h3>
        <div class="card-tools">
            <?php if($grupo): ?>
                <a href="<?php echo e(route('admin.estrutura.componente.create', ['grupo_id' => $grupo->id])); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Novo Componente
                </a>
            <?php elseif($actividade): ?>
                <a href="<?php echo e(route('admin.estrutura.componente.create', ['actividade_id' => $actividade->id])); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Novo Componente
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('admin.estrutura.componente.create')); ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Novo Componente
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    60d
                        <th style="width: 50px">Ordem</th>
                        <th>Nome</th>
                        <th>Localização</th>
                        <th>Unidade</th>
                        <th>Fórmula</th>
                        <th>Perda Padrão</th>
                        <th style="width: 80px">Medições</th>
                        <th style="width: 100px">Ações</th>
                    </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $componentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $componente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    60d
                        <td class="text-center">
                            <span class="badge badge-secondary"><?php echo e($componente->ordem); ?></span>
                        </td>
                        <td>
                            <strong><?php echo e($componente->nome); ?></strong>
                            <?php if($componente->valor_padrao): ?>
                                <br><small class="text-muted">Valor padrão: <?php echo e($componente->valor_padrao); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($componente->grupo): ?>
                                <span class="badge badge-warning"><?php echo e($componente->grupo->nome); ?></span>
                                <br><small class="text-muted"><?php echo e($componente->grupo->actividade->capitulo->modulo->nome); ?></small>
                            <?php else: ?>
                                <span class="badge badge-info"><?php echo e(Str::limit($componente->actividade->nome, 35)); ?></span>
                                <br><small class="text-muted"><?php echo e($componente->actividade->capitulo->modulo->nome); ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-success"><?php echo e($componente->unidade); ?></span>
                        </td>
                        <td class="text-center">
                            <?php
                                $formulas = [
                                    'volume' => ['label' => 'Volume', 'icon' => 'fa-cube', 'desc' => 'C × L × H'],
                                    'area' => ['label' => 'Área', 'icon' => 'fa-square', 'desc' => 'C × L'],
                                    'area_parede' => ['label' => 'Área Parede', 'icon' => 'fa-layer-group', 'desc' => 'C × H'],
                                    'area_lateral' => ['label' => 'Área Lateral', 'icon' => 'fa-chart-line', 'desc' => 'L × H'],
                                    'comprimento' => ['label' => 'Comprimento', 'icon' => 'fa-ruler', 'desc' => 'C'],
                                    'largura' => ['label' => 'Largura', 'icon' => 'fa-ruler-horizontal', 'desc' => 'L'],
                                    'altura' => ['label' => 'Altura', 'icon' => 'fa-ruler-vertical', 'desc' => 'H'],
                                    'valor_fixo' => ['label' => 'Valor Fixo', 'icon' => 'fa-hashtag', 'desc' => 'NPI × H'],
                                ];
                                $formula = $formulas[$componente->formula_calculo] ?? ['label' => $componente->formula_calculo, 'icon' => 'fa-calculator', 'desc' => ''];
                            ?>
                            <span class="badge badge-info" title="<?php echo e($formula['desc']); ?>">
                                <i class="fas <?php echo e($formula['icon']); ?>"></i> <?php echo e($formula['label']); ?>

                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge <?php echo e($componente->perda_padrao > 0 ? 'badge-warning' : 'badge-secondary'); ?>">
                                <?php echo e($componente->perda_padrao); ?>%
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge <?php echo e($componente->medicoes()->count() > 0 ? 'badge-primary' : 'badge-secondary'); ?>">
                                <?php echo e($componente->medicoes()->count()); ?>

                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('admin.estrutura.componente.edit', $componente->id)); ?>" class="btn btn-warning" title="Editar componente">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if($componente->medicoes()->count() == 0): ?>
                                    <form action="<?php echo e(route('admin.estrutura.componente.destroy', $componente->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este componente?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger" title="Excluir componente">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <button type="button" class="btn btn-danger" disabled title="Não pode excluir, possui medições">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="fas fa-cube fa-4x mb-3 text-muted"></i>
                            <p class="mb-2">Nenhum componente cadastrado.</p>
                            <?php if($grupo): ?>
                                <a href="<?php echo e(route('admin.estrutura.componente.create', ['grupo_id' => $grupo->id])); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Criar primeiro componente
                                </a>
                            <?php elseif($actividade): ?>
                                <a href="<?php echo e(route('admin.estrutura.componente.create', ['actividade_id' => $actividade->id])); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Criar primeiro componente
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('admin.estrutura.componente.create')); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Criar primeiro componente
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if($componentes->count() > 0): ?>
    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <small class="text-muted">
                    <i class="fas fa-info-circle"></i> 
                    Total de componentes: <strong><?php echo e($componentes->count()); ?></strong>
                    <?php if($componentes->sum(function($c) { return $c->medicoes()->count(); }) > 0): ?>
                        | Total de medições: <strong><?php echo e($componentes->sum(function($c) { return $c->medicoes()->count(); })); ?></strong>
                    <?php endif; ?>
                </small>
            </div>
            <div class="col-md-6 text-right">
                <small class="text-muted">
                    <i class="fas fa-calculator"></i> 
                    Fórmulas: <strong>Volume</strong> (C×L×H) | <strong>Área</strong> (C×L) | <strong>Área Parede</strong> (C×H) | <strong>Fixo</strong> (NPI×H)
                </small>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Alvaro_Martins\Escaleno\base_orcamentos_escaleno\resources\views/admin/estrutura/componentes.blade.php ENDPATH**/ ?>