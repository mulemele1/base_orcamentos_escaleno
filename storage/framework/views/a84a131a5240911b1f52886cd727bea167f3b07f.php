

<?php $__env->startSection('title', 'Editar Material'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .card-secondary.card-outline {
        border-top-color: #6c757d;
    }
    .card-header {
        background-color: #6c757d;
        color: white;
    }
    .card-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }
    .card-header i {
        margin-right: 5px;
    }
    .required-field::after {
        content: " *";
        color: red;
        font-weight: bold;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card card-secondary mt-3">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    Editar Material: <?php echo e($material->nome); ?>

                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="<?php echo e(route('materiais.update', $material->id)); ?>" method="post">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <?php echo $__env->make('materiais.partials.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </form>
        </div>
        <!-- /.card -->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/materiais/edit.blade.php ENDPATH**/ ?>