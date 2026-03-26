<?php $__env->startSection('content_header'); ?>
    <h1><i class="fas fa-edit mr-2"></i>Editar Projeto: <?php echo e($projeto->nome); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('projetos.update', $projeto->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome">Nome do Projeto *</label>
                            <input type="text" name="nome" id="nome" 
                                class="form-control <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                value="<?php echo e(old('nome', $projeto->nome)); ?>" required>
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cliente">Cliente *</label>
                            <input type="text" name="cliente" id="cliente" 
                                class="form-control <?php $__errorArgs = ['cliente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                value="<?php echo e(old('cliente', $projeto->cliente)); ?>" required>
                            <?php $__errorArgs = ['cliente'];
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
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="localizacao">Localização *</label>
                            <input type="text" name="localizacao" id="localizacao" 
                                class="form-control <?php $__errorArgs = ['localizacao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                value="<?php echo e(old('localizacao', $projeto->localizacao)); ?>" required>
                            <?php $__errorArgs = ['localizacao'];
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
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="data_inicio">Data de Início</label>
                            <input type="date" name="data_inicio" id="data_inicio" 
                                class="form-control" 
                                value="<?php echo e(old('data_inicio', $projeto->data_inicio ? $projeto->data_inicio->format('Y-m-d') : '')); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="data_fim">Data de Fim</label>
                            <input type="date" name="data_fim" id="data_fim" 
                                class="form-control" 
                                value="<?php echo e(old('data_fim', $projeto->data_fim ? $projeto->data_fim->format('Y-m-d') : '')); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="planeamento" <?php echo e(old('status', $projeto->status) == 'planeamento' ? 'selected' : ''); ?>>Em Planeamento</option>
                                <option value="em_andamento" <?php echo e(old('status', $projeto->status) == 'em_andamento' ? 'selected' : ''); ?>>Em Andamento</option>
                                <option value="concluido" <?php echo e(old('status', $projeto->status) == 'concluido' ? 'selected' : ''); ?>>Concluído</option>
                                <option value="suspenso" <?php echo e(old('status', $projeto->status) == 'suspenso' ? 'selected' : ''); ?>>Suspenso</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Atualizar Projeto</button>
                    <a href="<?php echo e(route('projetos.show', $projeto->id)); ?>" class="btn btn-default">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/projetos/edit.blade.php ENDPATH**/ ?>