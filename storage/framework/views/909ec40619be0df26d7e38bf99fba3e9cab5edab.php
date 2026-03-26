

<?php $__env->startSection('title', 'Form Fornecedor'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Cabeçalho -->
    <div class="row mb-4">
        <div class="col">
            <h2>Fornecedores</h2>
            <p class="text-muted">Gestão de fornecedores de materiais de construção</p>
        </div>
        <div class="col text-end">
            <a href="<?php echo e(route('fornecedores.create')); ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Novo Fornecedor
            </a>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Fornecedores</h5>
                    <h3><?php echo e($totalFornecedores); ?></h3>
                </div>
            </div>
        </div>
        <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-2">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <h6 class="card-title"><?php echo e(ucfirst($tipo->tipo)); ?></h6>
                    <h4><?php echo e($tipo->total); ?></h4>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Filtros e Busca -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('fornecedores.list')); ?>">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Buscar</label>
                            <input type="text" name="search" class="form-control" 
                                   value="<?php echo e(request('search')); ?>" 
                                   placeholder="Nome, localização ou tipo...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo</label>
                            <select name="tipo" class="form-control">
                                <option value="">Todos</option>
                                <?php $__currentLoopData = ['ferragem', 'betoneira', 'construcao', 'madeira', 'agregados', 'eletrico', 'hidraulico', 'diversos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tipo); ?>" <?php echo e(request('tipo') == $tipo ? 'selected' : ''); ?>>
                                        <?php echo e(ucfirst($tipo)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">Todos</option>
                                <option value="ativo" <?php echo e(request('status') == 'ativo' ? 'selected' : ''); ?>>Ativo</option>
                                <option value="inativo" <?php echo e(request('status') == 'inativo' ? 'selected' : ''); ?>>Inativo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filtrar
                                </button>
                                <a href="<?php echo e(route('fornecedores.list')); ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Fornecedores -->
    <div class="card">
        <div class="card-header">
            <h5>Lista de Fornecedores</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Localização</th>
                            <th>Tipo</th>
                            <th>Contacto</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Preços</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $fornecedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fornecedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($fornecedor->id); ?></td>
                            <td>
                                <strong><?php echo e($fornecedor->nome); ?></strong>
                                <?php if($fornecedor->nuit): ?>
                                    <br><small class="text-muted">NUIT: <?php echo e($fornecedor->nuit); ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($fornecedor->localizacao ?? '-'); ?></td>
                            <td>
                                <span class="badge bg-info"><?php echo e(ucfirst($fornecedor->tipo)); ?></span>
                            </td>
                            <td><?php echo e($fornecedor->contacto ?? '-'); ?></td>
                            <td><?php echo e($fornecedor->email ?? '-'); ?></td>
                            <td>
                                <?php if($fornecedor->status == 'ativo'): ?>
                                    <span class="badge bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary"><?php echo e($fornecedor->precos->count()); ?></span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?php echo e(route('fornecedores.show', $fornecedor->id)); ?>" 
                                       class="btn btn-sm btn-info" title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('fornecedores.edit', $fornecedor->id)); ?>" 
                                       class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('fornecedores.destroy', $fornecedor->id)); ?>" 
                                          method="POST" class="d-inline" 
                                          onsubmit="return confirm('Tem certeza que deseja excluir este fornecedor?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="9" class="text-center">Nenhum fornecedor encontrado</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                <?php echo e($fornecedores->appends(request()->query())->links()); ?>

            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        <?php if(session('success')): ?>
            Swal.fire('Sucesso!', '<?php echo e(session('success')); ?>', 'success');
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            Swal.fire('Erro!', '<?php echo e(session('error')); ?>', 'error');
        <?php endif; ?>
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/fornecedores/list.blade.php ENDPATH**/ ?>