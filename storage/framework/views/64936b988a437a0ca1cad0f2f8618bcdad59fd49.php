

<?php $__env->startSection('title', 'Nova Atividade'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-plus-circle mr-2"></i>Nova Atividade</h1>
    <a href="<?php echo e(route('atividades.index', ['categoria_id' => $categoriaId])); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Voltar
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informações da Atividade</h3>
            </div>
            <form action="<?php echo e(route('atividades.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="codigo">Código <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="codigo" 
                                       name="codigo" 
                                       value="<?php echo e(old('codigo')); ?>" 
                                       placeholder="Ex: 1, 2, 3..."
                                       required>
                                <small class="text-muted">Código numérico da atividade</small>
                                <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nome">Nome da Atividade <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="nome" 
                                       name="nome" 
                                       value="<?php echo e(old('nome')); ?>" 
                                       placeholder="Ex: TRABALHOS PRELIMINARES"
                                       required>
                                <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="categoria_obra_id">Módulo <span class="text-danger">*</span></label>
                                <select class="form-control <?php $__errorArgs = ['categoria_obra_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="categoria_obra_id" 
                                        name="categoria_obra_id" 
                                        required>
                                    <option value="">Selecione...</option>
                                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($categoria->id); ?>" 
                                            <?php echo e(old('categoria_obra_id', $categoriaId) == $categoria->id ? 'selected' : ''); ?>>
                                            <?php echo e($categoria->codigo); ?> - <?php echo e($categoria->nome); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['categoria_obra_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="unidade">Unidade</label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['unidade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="unidade" 
                                       name="unidade" 
                                       value="<?php echo e(old('unidade', 'Vg')); ?>" 
                                       placeholder="Ex: Vg, m², m³">
                                <?php $__errorArgs = ['unidade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="npi">NPI</label>
                                <input type="number" 
                                       class="form-control <?php $__errorArgs = ['npi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="npi" 
                                       name="npi" 
                                       value="<?php echo e(old('npi', 1)); ?>" 
                                       min="1"
                                       step="1">
                                <?php $__errorArgs = ['npi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ordem">Ordem</label>
                                <input type="number" 
                                       class="form-control <?php $__errorArgs = ['ordem'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="ordem" 
                                       name="ordem" 
                                       value="<?php echo e(old('ordem')); ?>" 
                                       min="0"
                                       placeholder="Auto">
                                <?php $__errorArgs = ['ordem'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Salvar Atividade
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo mr-1"></i> Limpar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-1"></i> Dicas
                </h3>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>Código:</strong> Use números sequenciais (1, 2, 3...)
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>Nome:</strong> Use letras maiúsculas para padronizar
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>Unidade:</strong> Vg (Verba Global), m², m³, Un, etc.
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>NPI:</strong> Número de vezes que a atividade se repete
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>Ordem:</strong> Define a posição na listagem
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/atividades/create.blade.php ENDPATH**/ ?>