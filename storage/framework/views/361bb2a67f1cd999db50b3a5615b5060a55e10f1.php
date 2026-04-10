<?php $__env->startSection('admin-content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <?php if(isset($actividade)): ?>
                        <i class="fas fa-edit"></i> Editar Actividade
                    <?php else: ?>
                        <i class="fas fa-plus"></i> Nova Actividade
                    <?php endif; ?>
                </h3>
            </div>
            <div class="card-body">
                <?php if(isset($actividade)): ?>
                    <form action="<?php echo e(route('admin.estrutura.actividade.update', $actividade->id)); ?>" method="POST">
                    <?php echo method_field('PUT'); ?>
                <?php else: ?>
                    <form action="<?php echo e(route('admin.estrutura.actividade.store')); ?>" method="POST">
                <?php endif; ?>
                    <?php echo csrf_field(); ?>
                    
                    <div class="form-group">
                        <label for="capitulo_id">Capítulo <span class="text-danger">*</span></label>
                        <select name="capitulo_id" id="capitulo_id" class="form-control <?php $__errorArgs = ['capitulo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="">Selecione um capítulo...</option>
                            <?php $__currentLoopData = $capitulos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cap->id); ?>" 
                                    <?php echo e(old('capitulo_id', isset($actividade) ? $actividade->capitulo_id : (isset($capituloSelecionado) ? $capituloSelecionado->id : '')) == $cap->id ? 'selected' : ''); ?>>
                                    <?php echo e($cap->modulo->ordem); ?>.<?php echo e($cap->ordem); ?> - <?php echo e($cap->modulo->nome); ?> / <?php echo e($cap->nome); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['capitulo_id'];
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
                        <label for="nome">Nome da Actividade <span class="text-danger">*</span></label>
                        <input type="text" name="nome" id="nome" 
                               class="form-control <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('nome', $actividade->nome ?? '')); ?>" 
                               placeholder="Ex: Fornecimento e assentamento de betão estrutural" required>
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
                               value="<?php echo e(old('ordem', $actividade->ordem ?? 0)); ?>" 
                               min="1" required>
                        <small class="form-text text-muted">Define a posição de exibição dentro do capítulo</small>
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
                        <label for="descricao">Descrição Detalhada <span class="text-danger">*</span></label>
                        <textarea name="descricao" id="descricao" 
                                  class="form-control <?php $__errorArgs = ['descricao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  rows="5" required><?php echo e(old('descricao', $actividade->descricao ?? '')); ?></textarea>
                        <small class="form-text text-muted">Descreva detalhadamente o trabalho a ser executado</small>
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
                        <a href="<?php echo e(route('admin.estrutura.actividades', isset($capituloSelecionado) ? $capituloSelecionado->id : (isset($actividade) ? $actividade->capitulo_id : ''))); ?>" class="btn btn-secondary">
    <i class="fas fa-times"></i> Cancelar
</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Informações
                </h3>
            </div>
            <div class="card-body">
                <h5>O que é uma Actividade?</h5>
                <p>A actividade é o terceiro nível da hierarquia. Descreve um trabalho específico a ser executado na obra.</p>
                
                <h5 class="mt-3">Exemplo:</h5>
                <div class="alert alert-secondary">
                    <strong>Fornecimento e assentamento de betão estrutural C20/25</strong>
                    <hr class="my-2">
                    <small>Fornecimento e assentamento de betão armado do tipo B, classe C20/25 em sapatas, vigas, pilares e lajes, incluindo trabalhos complementares.</small>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-lightbulb"></i>
                    <small>A descrição deve ser clara e detalhada para evitar dúvidas na execução.</small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Alvaro_Martins\Escaleno\base_orcamentos_escaleno\resources\views/admin/estrutura/actividade-form.blade.php ENDPATH**/ ?>