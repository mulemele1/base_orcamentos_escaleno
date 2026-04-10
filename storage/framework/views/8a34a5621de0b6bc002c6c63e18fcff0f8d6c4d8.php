<?php $__env->startSection('title', $projeto->nome); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-building text-primary mr-2"></i>
        <?php echo e($projeto->nome); ?>

    </h1>
    <div>
        <a href="<?php echo e(route('projetos.edit', $projeto->id)); ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="<?php echo e(route('projetos.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3><?php echo e($componentesMedidos); ?>/<?php echo e($totalComponentes); ?></h3>
                <p>Componentes Medidos</p>
            </div>
            <div class="icon">
                <i class="fas fa-ruler-combined"></i>
            </div>
            <div class="small-box-footer">
                <div class="progress" style="height: 3px;">
                    <div class="progress-bar" style="width: <?php echo e($progresso); ?>%"></div>
                </div>
                <small><?php echo e($progresso); ?>% completo</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3><?php echo e($projeto->medicoes()->count()); ?></h3>
                <p>Medições Realizadas</p>
            </div>
            <div class="icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3><?php echo e($projeto->orcamentos()->count()); ?></h3>
                <p>Orçamentos Gerados</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3><?php echo e($projeto->status_formatado); ?></h3>
                <p>Status do Projeto</p>
            </div>
            <div class="icon">
                <i class="fas fa-flag-checkered"></i>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Informações do Projeto
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 150px;">Nome</th>
                        <td><strong><?php echo e($projeto->nome); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Cliente</th>
                        <td><?php echo e($projeto->cliente ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Localização</th>
                        <td><?php echo e($projeto->localizacao ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Data de Início</th>
                        <td><?php echo e($projeto->data_inicio ? $projeto->data_inicio->format('d/m/Y') : '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Data de Fim</th>
                        <td><?php echo e($projeto->data_fim ? $projeto->data_fim->format('d/m/Y') : '—'); ?></td>
                    </tr>
                    <tr>
                        <th>Descrição</th>
                        <td><?php echo e($projeto->descricao ?? '—'); ?></td>
                    </tr>
                    <tr>
                        <th>IVA</th>
                        <td><?php echo e($projeto->iva); ?>%</td>
                    </tr>
                    <tr>
                        <th>Contingência</th>
                        <td><?php echo e($projeto->contingencia); ?>%</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i> Ações Rápidas
                </h3>
            </div>
            <div class="card-body">
                <?php if($projeto->status == 'rascunho' || $projeto->status == 'medicao'): ?>
                    <a href="<?php echo e(route('medicoes.dashboard', $projeto->id)); ?>" class="btn btn-success btn-block mb-2">
                        <i class="fas fa-ruler-combined"></i> Iniciar Medição
                    </a>
                <?php endif; ?>
                
                <?php if($projeto->status == 'medicao' && $componentesMedidos == $totalComponentes && $totalComponentes > 0): ?>
                    <form action="<?php echo e(route('medicoes.finalizar', $projeto->id)); ?>" method="POST" class="d-inline w-100">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <button type="submit" class="btn btn-warning btn-block mb-2" onclick="return confirm('Finalizar medição?')">
                            <i class="fas fa-check-circle"></i> Finalizar Medição
                        </button>
                    </form>
                <?php endif; ?>
                
                <?php if($projeto->status == 'orcamento' && $projeto->orcamentos->isEmpty()): ?>
                    <a href="<?php echo e(route('orcamentos.gerar', $projeto->id)); ?>" class="btn btn-info btn-block mb-2">
                        <i class="fas fa-chart-line"></i> Gerar Orçamento
                    </a>
                <?php endif; ?>
                
                <?php if($projeto->orcamentos->isNotEmpty()): ?>
                    <?php
                        $ultimoOrcamento = $projeto->orcamentos()->latest()->first();
                    ?>
                    <a href="<?php echo e(route('orcamentos.show', [$projeto->id, $ultimoOrcamento->id])); ?>" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-eye"></i> Ver Último Orçamento
                    </a>
                <?php endif; ?>
                
                <form action="<?php echo e(route('projetos.nova-versao', $projeto->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-outline-secondary btn-block">
                        <i class="fas fa-copy"></i> Duplicar Projeto
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php if($medicoes->isNotEmpty()): ?>
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clipboard-list"></i> Medições Realizadas
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Componente</th>
                                <th>Dimensões</th>
                                <th>NPI</th>
                                <th>Quantidade</th>
                                <th>Unidade</th>
                                <th>Origem</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $medicoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medicao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <strong><?php echo e($medicao->componente->nome ?? '—'); ?></strong>
                                    <br>
                                    <small class="text-muted"><?php echo e($medicao->componente->formula_calculo ?? '—'); ?></small>
                                </td>
                                <td>
                                    <?php if($medicao->comprimento): ?> <?php echo e($medicao->comprimento); ?>m <?php endif; ?>
                                    <?php if($medicao->largura): ?> × <?php echo e($medicao->largura); ?>m <?php endif; ?>
                                    <?php if($medicao->altura): ?> × <?php echo e($medicao->altura); ?>m <?php endif; ?>
                                    <?php if(!$medicao->comprimento && !$medicao->largura && !$medicao->altura): ?>
                                        —
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($medicao->npi); ?></td>
                                <td class="text-right">
                                    <strong><?php echo e(number_format($medicao->quantidade, 2)); ?></strong>
                                </td>
                                <td><?php echo e($medicao->componente->unidade ?? '—'); ?></td>
                                <td>
                                    <?php if($medicao->origem == 'desenho'): ?>
                                        <span class="badge badge-info">
                                            <i class="fas fa-drafting-compass"></i> Desenho
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-success">
                                            <i class="fas fa-hard-hat"></i> Campo
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('medicoes.edit', [$projeto->id, $medicao->id])); ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('medicoes.destroy', [$projeto->id, $medicao->id])); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remover medição?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-center py-4">
                <i class="fas fa-clipboard-list fa-3x mb-3 text-muted"></i>
                <p>Nenhuma medição realizada ainda.</p>
<?php if($projeto->status == 'rascunho' || $projeto->status == 'medicao'): ?>
    <a href="<?php echo e(route('medicoes.dashboard', ['projeto' => $projeto->id])); ?>" class="btn btn-success btn-block mb-2">
        <i class="fas fa-ruler-combined"></i> Iniciar Medição
    </a>
<?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<?php if($projeto->orcamentos->isNotEmpty()): ?>
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line"></i> Orçamentos Gerados
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data</th>
                                <th>Subtotal</th>
                                <th>IVA</th>
                                <th>Total</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $projeto->orcamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orcamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($orcamento->nome); ?></td>
                                <td><?php echo e($orcamento->data_orcamento->format('d/m/Y')); ?></td>
                                <td class="text-right">MT <?php echo e(number_format($orcamento->subtotal, 2, ',', '.')); ?></td>
                                <td class="text-right">MT <?php echo e(number_format($orcamento->iva, 2, ',', '.')); ?></td>
                                <td class="text-right">
                                    <strong>MT <?php echo e(number_format($orcamento->total_geral, 2, ',', '.')); ?></strong>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('orcamentos.show', [$projeto->id, $orcamento->id])); ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('orcamentos.pdf', [$projeto->id, $orcamento->id])); ?>" class="btn btn-sm btn-danger">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Alvaro_Martins\Escaleno\base_orcamentos_escaleno\resources\views/projetos/show.blade.php ENDPATH**/ ?>