
<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5><i class="icon fas fa-ban"></i> Erros encontrados:</h5>
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5><i class="icon fas fa-check"></i> Sucesso!</h5>
        <p><?php echo e(session('success')); ?></p>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> Erro!</h5>
        <p><?php echo e(session('error')); ?></p>
    </div>
<?php endif; ?>

<?php if(session('info')): ?>
    <div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5><i class="icon fas fa-info-circle"></i> Informação</h5>
        <p><?php echo e(session('info')); ?></p>
    </div>
<?php endif; ?>

<?php if(session('warning')): ?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção</h5>
        <p><?php echo e(session('warning')); ?></p>
    </div>
<?php endif; ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/materiais/partials/validations.blade.php ENDPATH**/ ?>