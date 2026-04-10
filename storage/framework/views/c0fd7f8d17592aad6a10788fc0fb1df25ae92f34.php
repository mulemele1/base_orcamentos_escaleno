<?php $__env->startSection('admin-content'); ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <?php if(isset($capitulo)): ?>
                        <i class="fas fa-edit"></i> Editar Capítulo
                    <?php else: ?>
                        <i class="fas fa-plus"></i> Novo Capítulo
                    <?php endif; ?>
                </h3>
            </div>
            <div class="card-body">
                <?php if(isset($capitulo)): ?>
                    <form action="<?php echo e(route('admin.estrutura.capitulo.update', $capitulo->id)); ?>" method="POST">
                    <?php echo method_field('PUT'); ?>
                <?php else: ?>
                    <form action="<?php echo e(route('admin.estrutura.capitulo.store')); ?>" method="POST">
                <?php endif; ?>
                    <?php echo csrf_field(); ?>
                    
                    <div class="form-group">
                        <label for="modulo_id">Módulo <span class="text-danger">*</span></label>
                        <select name="modulo_id" id="modulo_id" class="form-control <?php $__errorArgs = ['modulo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">Selecione um módulo...</option>
                            <?php $__currentLoopData = $modulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($mod->id); ?>" 
                                    <?php echo e(old('modulo_id', isset($capitulo) ? $capitulo->modulo_id : (isset($moduloSelecionado) ? $moduloSelecionado->id : '')) == $mod->id ? 'selected' : ''); ?>>
                                    <?php echo e($mod->ordem); ?>. <?php echo e($mod->nome); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['modulo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="nome">Nome do Capítulo <span class="text-danger">*</span></label>
                        <input type="text" name="nome" id="nome" 
                               class="form-control <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('nome', $capitulo->nome ?? '')); ?>" 
                               placeholder="Ex: Betões" required>
                        <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="ordem">Ordem <span class="text-danger">*</span></label>
                        <input type="number" name="ordem" id="ordem" 
                               class="form-control <?php $__errorArgs = ['ordem'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('ordem', $capitulo->ordem ?? 0)); ?>" 
                               min="1" required>
                        <small class="form-text text-muted">Define a posição de exibição dentro do módulo (1, 2, 3...)</small>
                        <?php $__errorArgs = ['ordem'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea name="descricao" id="descricao" 
                                  class="form-control <?php $__errorArgs = ['descricao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  rows="3"><?php echo e(old('descricao', $capitulo->descricao ?? '')); ?></textarea>
                        <?php $__errorArgs = ['descricao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                        <a href="<?php echo e(route('admin.estrutura.capitulos', isset($moduloSelecionado) ? $moduloSelecionado->id : (isset($capitulo) ? $capitulo->modulo_id : ''))); ?>" class="btn btn-secondary">
    <i class="fas fa-times"></i> Cancelar
</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Informações
                </h3>
            </div>
            <div class="card-body">
                <h5>O que é um Capítulo?</h5>
                <p>O capítulo é o segundo nível da hierarquia. Agrupa actividades relacionadas dentro de um módulo.</p>
                
                <h5 class="mt-3">Exemplos no Módulo "4. BETÕES, AÇOS E COFRAGEM":</h5>
                <ul>
                    <li>Betões</li>
                    <li>Aços</li>
                    <li>Cofragem</li>
                </ul>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-lightbulb"></i>
                    <small>A ordem define a sequência de exibição dentro do módulo.</small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Alvaro_Martins\Escaleno\base_orcamentos_escaleno\resources\views/admin/estrutura/capitulo-form.blade.php ENDPATH**/ ?>