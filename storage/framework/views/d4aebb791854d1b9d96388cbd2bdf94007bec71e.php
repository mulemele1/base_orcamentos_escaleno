

<div class="card-body">
    <?php echo $__env->make('materiais.partials.validations', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="codigo" class="required-field">Código</label>
                <input type="text" 
                       name="codigo" 
                       value="<?php echo e(old('codigo', $material->codigo ?? '')); ?>" 
                       class="form-control <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                       id="codigo"
                       placeholder="Ex: 1.1, 2.3, 3.1.4" 
                       required>
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
                <small class="text-muted">Formato recomendado: número com pontos (ex: 1.1, 2.3.1)</small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="categoria" class="required-field">Categoria</label>
                <select class="form-control <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                        id="categoria" 
                        name="categoria" 
                        required>
                    <option value="">Selecione uma categoria</option>
                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($categoria); ?>" 
                            <?php echo e(old('categoria', $material->categoria ?? '') == $categoria ? 'selected' : ''); ?>>
                            <?php echo e($categoria); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['categoria'];
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

    <div class="form-group">
        <label for="nome" class="required-field">Nome do Material</label>
        <input type="text" 
               name="nome" 
               value="<?php echo e(old('nome', $material->nome ?? '')); ?>" 
               class="form-control <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
               id="nome"
               placeholder="Ex: Cimento portland normal 42.5N" 
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

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="unidade" class="required-field">Unidade</label>
                <select class="form-control <?php $__errorArgs = ['unidade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                        id="unidade" 
                        name="unidade" 
                        required>
                    <option value="">Selecione...</option>
                    <?php $__currentLoopData = $unidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $unidade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>" 
                            <?php echo e(old('unidade', $material->unidade ?? '') == $key ? 'selected' : ''); ?>>
                            <?php echo e($unidade); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
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

        <div class="col-md-4">
            <div class="form-group">
                <label for="valor_compra" class="required-field">Valor de Compra (MT)</label>
                <input type="number" 
                       step="0.01" 
                       min="0" 
                       name="valor_compra" 
                       value="<?php echo e(old('valor_compra', $material->valor_compra ?? '')); ?>" 
                       class="form-control <?php $__errorArgs = ['valor_compra'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                       id="valor_compra"
                       placeholder="0.00" 
                       required>
                <?php $__errorArgs = ['valor_compra'];
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

        <div class="col-md-4">
            <div class="form-group">
                <label for="rendimento" class="required-field">Rendimento</label>
                <input type="number" 
                       step="0.01" 
                       min="0" 
                       name="rendimento" 
                       value="<?php echo e(old('rendimento', $material->rendimento ?? '1')); ?>" 
                       class="form-control <?php $__errorArgs = ['rendimento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                       id="rendimento"
                       placeholder="Ex: 50, 5.8" 
                       required>
                <?php $__errorArgs = ['rendimento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="invalid-feedback"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <small class="text-muted">Quantidade por unidade (ex: kg por m², metros por barra)</small>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea class="form-control <?php $__errorArgs = ['descricao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                  id="descricao" 
                  name="descricao" 
                  rows="3"
                  placeholder="Descrição detalhada do material (opcional)"><?php echo e(old('descricao', $material->descricao ?? '')); ?></textarea>
        <?php $__errorArgs = ['descricao'];
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

    <div class="form-group">
        <label for="observacoes">Observações</label>
        <textarea class="form-control <?php $__errorArgs = ['observacoes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                  id="observacoes" 
                  name="observacoes" 
                  rows="2"
                  placeholder="Informações adicionais, notas sobre fornecedores, etc. (opcional)"><?php echo e(old('observacoes', $material->observacoes ?? '')); ?></textarea>
        <?php $__errorArgs = ['observacoes'];
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

    <!-- Preview de cálculo -->
    <div class="preview-calculo" id="previewCalculo" style="display: none;">
        <strong><i class="fas fa-calculator mr-2"></i>Pré-visualização do cálculo:</strong><br>
        <span id="previewTexto"></span>
    </div>

    <!-- Informações do sistema (apenas para edição) -->
    <?php if(isset($material) && $material->id): ?>
        <div class="alert alert-secondary mt-3">
            <div class="row">
                <div class="col-md-6">
                    <small>
                        <i class="far fa-calendar-alt mr-1"></i>
                        <strong>Criado em:</strong> <?php echo e($material->created_at->format('d/m/Y H:i')); ?>

                    </small>
                </div>
                <div class="col-md-6">
                    <small>
                        <i class="far fa-clock mr-1"></i>
                        <strong>Última atualização:</strong> <?php echo e($material->updated_at->format('d/m/Y H:i')); ?>

                    </small>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<!-- /.card-body -->

<div class="card-footer">
    <button type="submit" class="btn btn-secondary">
        <i class="fas fa-save mr-1"></i> <?php echo e(isset($material) ? 'Atualizar' : 'Salvar'); ?>

    </button>
    <a href="<?php echo e(route('materiais.list')); ?>" class="btn btn-default">
        <i class="fas fa-times mr-1"></i> Cancelar
    </a>
</div>

<?php $__env->startPush('js'); ?>
<script>
    // Preview do cálculo baseado no rendimento
    document.addEventListener('DOMContentLoaded', function() {
        const valorInput = document.getElementById('valor_compra');
        const rendimentoInput = document.getElementById('rendimento');
        const unidadeSelect = document.getElementById('unidade');
        
        if (valorInput && rendimentoInput && unidadeSelect) {
            valorInput.addEventListener('input', updatePreview);
            rendimentoInput.addEventListener('input', updatePreview);
            unidadeSelect.addEventListener('change', updatePreview);
            
            // Chamar preview ao carregar a página
            updatePreview();
        }
    });

    function updatePreview() {
        const valor = parseFloat(document.getElementById('valor_compra').value) || 0;
        const rendimento = parseFloat(document.getElementById('rendimento').value) || 1;
        const unidadeSelect = document.getElementById('unidade');
        const unidadeText = unidadeSelect.options[unidadeSelect.selectedIndex]?.text.split(' ')[0] || 'un';
        
        const previewDiv = document.getElementById('previewCalculo');
        const previewTexto = document.getElementById('previewTexto');
        
        if (valor > 0 && rendimento > 0) {
            const custoPorUnidade = valor / rendimento;
            previewTexto.innerHTML = `
                <span class="font-weight-bold">MT ${custoPorUnidade.toFixed(2)}</span> por ${unidadeText}<br>
                <small class="text-muted">(Valor: MT ${valor.toFixed(2)} ÷ Rendimento: ${rendimento.toFixed(2)})</small>
            `;
            previewDiv.style.display = 'block';
        } else {
            previewDiv.style.display = 'none';
        }
    }

    // Confirmar saída se houver mudanças não salvas
    let formChanged = false;
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        input.addEventListener('change', () => formChanged = true);
        input.addEventListener('keyup', () => formChanged = true);
    });

    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Marcar formulário como salvo ao submit
    form.addEventListener('submit', function() {
        formChanged = false;
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/materiais/partials/form.blade.php ENDPATH**/ ?>