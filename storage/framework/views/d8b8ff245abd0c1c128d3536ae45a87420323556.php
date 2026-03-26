

<?php $__env->startSection('title', 'Editar Actividade'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-edit mr-2"></i>Editar Actividade</h1>
    <a href="<?php echo e(route('subatividades.index', ['atividade_id' => $subatividade->atividade_id])); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Voltar
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">
                    <i class="fas fa-calculator mr-1"></i> Informações e Cálculos
                </h3>
            </div>
            <form action="<?php echo e(route('subatividades.update', $subatividade->id)); ?>" method="POST" id="subatividadeForm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="atividade_id">Capítulo <span class="text-danger">*</span></label>
                                <select class="form-control <?php $__errorArgs = ['atividade_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        id="atividade_id" 
                                        name="atividade_id" 
                                        required>
                                    <option value="">Selecione...</option>
                                    <?php $__currentLoopData = $atividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atividade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($atividade->id); ?>" 
                                            <?php echo e(old('atividade_id', $subatividade->atividade_id) == $atividade->id ? 'selected' : ''); ?>>
                                            <?php echo e($atividade->categoriaObra->codigo); ?>.<?php echo e($atividade->codigo); ?> - <?php echo e($atividade->nome); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['atividade_id'];
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
                                       value="<?php echo e(old('codigo', $subatividade->codigo)); ?>" 
                                       placeholder="Ex: 1.1, 1.2"
                                       required>
                                <small class="text-muted">Ex: 1.1, 2.3</small>
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

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome">Nome da actividade <span class="text-danger">*</span></label>
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
                                       value="<?php echo e(old('nome', $subatividade->nome)); ?>" 
                                       placeholder="Descrição da subatividade"
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="unidade">Unidade <span class="text-danger">*</span></label>
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
                                    <option value="">Selecione</option>
                                    <option value="m³" <?php echo e(old('unidade', $subatividade->unidade) == 'm³' ? 'selected' : ''); ?>>m³</option>
                                    <option value="m²" <?php echo e(old('unidade', $subatividade->unidade) == 'm²' ? 'selected' : ''); ?>>m²</option>
                                    <option value="m" <?php echo e(old('unidade', $subatividade->unidade) == 'm' ? 'selected' : ''); ?>>m (metro linear)</option>
                                    <option value="Un" <?php echo e(old('unidade', $subatividade->unidade) == 'Un' ? 'selected' : ''); ?>>Un (unidade)</option>
                                    <option value="Vg" <?php echo e(old('unidade', $subatividade->unidade) == 'Vg' ? 'selected' : ''); ?>>Vg (verba global)</option>
                                    <option value="kg" <?php echo e(old('unidade', $subatividade->unidade) == 'kg' ? 'selected' : ''); ?>>kg</option>
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
                                       value="<?php echo e(old('npi', $subatividade->npi)); ?>" 
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
                                <label for="perda_percentual">Perda (%)</label>
                                <input type="number" 
                                       class="form-control <?php $__errorArgs = ['perda_percentual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="perda_percentual" 
                                       name="perda_percentual" 
                                       value="<?php echo e(old('perda_percentual', $subatividade->perda_percentual)); ?>" 
                                       min="0" 
                                       max="100"
                                       step="0.1">
                                <?php $__errorArgs = ['perda_percentual'];
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
                                       value="<?php echo e(old('ordem', $subatividade->ordem)); ?>" 
                                       min="0">
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

                    <div class="card card-secondary mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Dimensões (para cálculos automáticos)</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="comprimento">Comprimento (C)</label>
                                        <input type="number" 
                                               class="form-control <?php $__errorArgs = ['comprimento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="comprimento" 
                                               name="comprimento" 
                                               value="<?php echo e(old('comprimento', $subatividade->comprimento)); ?>" 
                                               min="0"
                                               step="0.01">
                                        <?php $__errorArgs = ['comprimento'];
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="largura">Largura (L)</label>
                                        <input type="number" 
                                               class="form-control <?php $__errorArgs = ['largura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="largura" 
                                               name="largura" 
                                               value="<?php echo e(old('largura', $subatividade->largura)); ?>" 
                                               min="0"
                                               step="0.01">
                                        <?php $__errorArgs = ['largura'];
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="altura">Altura (H)</label>
                                        <input type="number" 
                                               class="form-control <?php $__errorArgs = ['altura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               id="altura" 
                                               name="altura" 
                                               value="<?php echo e(old('altura', $subatividade->altura)); ?>" 
                                               min="0"
                                               step="0.01">
                                        <?php $__errorArgs = ['altura'];
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label>
                                        <button type="button" class="btn btn-info btn-block" id="calcularBtn">
                                            <i class="fas fa-sync-alt mr-1"></i> Calcular
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-success mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Resultados dos Cálculos</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-info"><i class="fas fa-ruler"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Elementar</span>
                                            <span class="info-box-number" id="resultado_elementar"><?php echo e(number_format($subatividade->elementar, 2, ',', '.')); ?></span>
                                            <small>C × L × H</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-warning"><i class="fas fa-calculator"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Parcial</span>
                                            <span class="info-box-number" id="resultado_parcial"><?php echo e(number_format($subatividade->parcial, 2, ',', '.')); ?></span>
                                            <small>NPI × Elementar</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-success"><i class="fas fa-chart-line"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Quantidade Proposta</span>
                                            <span class="info-box-number" id="resultado_quantidade"><?php echo e(number_format($subatividade->quantidade_proposta, 2, ',', '.')); ?></span>
                                            <small>Parcial × (1 + Perda/100)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição Detalhada Actividade</label>
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
                                  rows="3"><?php echo e(old('descricao', $subatividade->descricao)); ?></textarea>
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
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Atualizar Subatividade
                    </button>
                    <a href="<?php echo e(route('subatividades.index', ['atividade_id' => $subatividade->atividade_id])); ?>" 
                       class="btn btn-secondary">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-1"></i> Informações
                </h3>
            </div>
            <div class="card-body">
                <dl>
                    <dt><i class="fas fa-calendar-alt mr-1"></i> Criado em:</dt>
                    <dd><?php echo e($subatividade->created_at ? $subatividade->created_at->format('d/m/Y H:i') : '-'); ?></dd>
                    
                    <dt><i class="fas fa-history mr-1"></i> Última atualização:</dt>
                    <dd><?php echo e($subatividade->updated_at ? $subatividade->updated_at->format('d/m/Y H:i') : '-'); ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    // Função para calcular os valores via AJAX
    function calcularValores() {
        const npi = $('#npi').val() || 1;
        const comprimento = $('#comprimento').val();
        const largura = $('#largura').val();
        const altura = $('#altura').val();
        const perda = $('#perda_percentual').val() || 0;

        $.ajax({
            url: '<?php echo e(route("subatividades.calcular")); ?>',
            type: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                npi: npi,
                comprimento: comprimento,
                largura: largura,
                altura: altura,
                perda_percentual: perda
            },
            success: function(response) {
                $('#resultado_elementar').text(response.elementar);
                $('#resultado_parcial').text(response.parcial);
                $('#resultado_quantidade').text(response.quantidade_proposta);
            },
            error: function(xhr) {
                console.error('Erro no cálculo:', xhr);
            }
        });
    }

    // Calcular ao clicar no botão
    $('#calcularBtn').click(calcularValores);

    // Calcular automaticamente ao mudar os campos
    $('#npi, #comprimento, #largura, #altura, #perda_percentual').change(calcularValores);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/subatividades/edit.blade.php ENDPATH**/ ?>