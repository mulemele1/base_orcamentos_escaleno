<?php $__env->startSection('admin-content'); ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <?php if(isset($componente)): ?>
                        <i class="fas fa-edit"></i> Editar Componente
                    <?php else: ?>
                        <i class="fas fa-plus"></i> Novo Componente
                    <?php endif; ?>
                </h3>
            </div>
            <div class="card-body">
                <?php if(isset($componente)): ?>
                    <form action="<?php echo e(route('admin.estrutura.componente.update', $componente->id)); ?>" method="POST" id="form-componente">
                    <?php echo method_field('PUT'); ?>
                <?php else: ?>
                    <form action="<?php echo e(route('admin.estrutura.componente.store')); ?>" method="POST" id="form-componente">
                <?php endif; ?>
                    <?php echo csrf_field(); ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="grupo_id">Grupo (opcional)</label>
                                <select name="grupo_id" id="grupo_id" class="form-control <?php $__errorArgs = ['grupo_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option value="">Sem grupo (directo na actividade)</option>
                                    <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($grp->id); ?>" 
                                            <?php echo e(old('grupo_id', isset($componente) ? $componente->grupo_id : (isset($grupoSelecionado) ? $grupoSelecionado->id : '')) == $grp->id ? 'selected' : ''); ?>>
                                            <?php echo e($grp->actividade->capitulo->modulo->ordem); ?>.<?php echo e($grp->actividade->capitulo->ordem); ?>.<?php echo e($grp->actividade->ordem); ?>.<?php echo e($grp->ordem); ?> - <?php echo e($grp->nome); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['grupo_id'];
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
                                <label for="actividade_id">Actividade <span class="text-danger">*</span></label>
                                <select name="actividade_id" id="actividade_id" class="form-control <?php $__errorArgs = ['actividade_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">Selecione uma actividade...</option>
                                    <?php $__currentLoopData = $actividades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ativ): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($ativ->id); ?>" 
                                            <?php echo e(old('actividade_id', isset($componente) ? $componente->actividade_id : (isset($actividadeSelecionada) ? $actividadeSelecionada->id : '')) == $ativ->id ? 'selected' : ''); ?>>
                                            <?php echo e($ativ->capitulo->modulo->ordem); ?>.<?php echo e($ativ->capitulo->ordem); ?>.<?php echo e($ativ->ordem); ?> - <?php echo e(Str::limit($ativ->nome, 50)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['actividade_id'];
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
                    
                    <div class="form-group">
                        <label for="nome">Nome do Componente <span class="text-danger">*</span></label>
                        <input type="text" name="nome" id="nome" 
                               class="form-control <?php $__errorArgs = ['nome'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('nome', $componente->nome ?? '')); ?>" 
                               placeholder="Ex: Sapata isolada" required>
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
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="unidade">Unidade <span class="text-danger">*</span></label>
                                <select name="unidade" id="unidade" class="form-control <?php $__errorArgs = ['unidade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="m³" <?php echo e(old('unidade', $componente->unidade ?? '') == 'm³' ? 'selected' : ''); ?>>m³ (metro cúbico)</option>
                                    <option value="m²" <?php echo e(old('unidade', $componente->unidade ?? '') == 'm²' ? 'selected' : ''); ?>>m² (metro quadrado)</option>
                                    <option value="m" <?php echo e(old('unidade', $componente->unidade ?? '') == 'm' ? 'selected' : ''); ?>>m (metro linear)</option>
                                    <option value="kg" <?php echo e(old('unidade', $componente->unidade ?? '') == 'kg' ? 'selected' : ''); ?>>kg (quilograma)</option>
                                    <option value="un" <?php echo e(old('unidade', $componente->unidade ?? '') == 'un' ? 'selected' : ''); ?>>un (unidade)</option>
                                </select>
                                <?php $__errorArgs = ['unidade'];
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
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="formula_calculo">Fórmula de Cálculo <span class="text-danger">*</span></label>
                                <select name="formula_calculo" id="formula_calculo" class="form-control <?php $__errorArgs = ['formula_calculo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="volume" <?php echo e(old('formula_calculo', $componente->formula_calculo ?? '') == 'volume' ? 'selected' : ''); ?>>Volume (C × L × H)</option>
                                    <option value="area" <?php echo e(old('formula_calculo', $componente->formula_calculo ?? '') == 'area' ? 'selected' : ''); ?>>Área (C × L)</option>
                                    <option value="area_parede" <?php echo e(old('formula_calculo', $componente->formula_calculo ?? '') == 'area_parede' ? 'selected' : ''); ?>>Área de Parede (C × H)</option>
                                    <option value="area_lateral" <?php echo e(old('formula_calculo', $componente->formula_calculo ?? '') == 'area_lateral' ? 'selected' : ''); ?>>Área Lateral (L × H)</option>
                                    <option value="comprimento" <?php echo e(old('formula_calculo', $componente->formula_calculo ?? '') == 'comprimento' ? 'selected' : ''); ?>>Comprimento Linear (C)</option>
                                    <option value="largura" <?php echo e(old('formula_calculo', $componente->formula_calculo ?? '') == 'largura' ? 'selected' : ''); ?>>Largura (L)</option>
                                    <option value="altura" <?php echo e(old('formula_calculo', $componente->formula_calculo ?? '') == 'altura' ? 'selected' : ''); ?>>Altura (H)</option>
                                    <option value="valor_fixo" <?php echo e(old('formula_calculo', $componente->formula_calculo ?? '') == 'valor_fixo' ? 'selected' : ''); ?>>Valor Fixo (NPI × H)</option>
                                </select>
                                <?php $__errorArgs = ['formula_calculo'];
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
                        <div class="col-md-4">
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
                                       value="<?php echo e(old('ordem', $componente->ordem ?? 0)); ?>" 
                                       min="1" required>
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
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="perda_padrao">Perda Padrão (%)</label>
                                <input type="number" name="perda_padrao" id="perda_padrao" 
                                       class="form-control <?php $__errorArgs = ['perda_padrao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       step="0.5" 
                                       value="<?php echo e(old('perda_padrao', $componente->perda_padrao ?? 0)); ?>">
                                <small class="form-text text-muted">Percentual de desperdício padrão para este componente</small>
                                <?php $__errorArgs = ['perda_padrao'];
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
                            <div class="form-group" id="campo_valor_padrao" style="display: <?php echo e(old('formula_calculo', $componente->formula_calculo ?? '') == 'valor_fixo' ? 'block' : 'none'); ?>">
                                <label for="valor_padrao">Valor Padrão</label>
                                <input type="number" name="valor_padrao" id="valor_padrao" 
                                       class="form-control <?php $__errorArgs = ['valor_padrao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       step="0.01" 
                                       value="<?php echo e(old('valor_padrao', $componente->valor_padrao ?? '')); ?>" 
                                       placeholder="Ex: 33 (kg por unidade)">
                                <small class="form-text text-muted">Usado apenas para fórmula "Valor Fixo" (ex: kg por unidade)</small>
                                <?php $__errorArgs = ['valor_padrao'];
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
                    
                    
                    <div class="card mt-3">
                        <div class="card-header bg-light">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calculator"></i> Simulador de Cálculo
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="sim_npi">NPI (Nº repetições)</label>
                                        <input type="number" id="sim_npi" class="form-control" value="1" step="1" min="1">
                                    </div>
                                </div>
                                <div id="campos_simulacao">
                                    <div class="row">
                                        <div class="col-md-3" id="campo_sim_c" style="display: block;">
                                            <div class="form-group">
                                                <label for="sim_c">Comprimento (C)</label>
                                                <input type="number" id="sim_c" class="form-control" step="0.01" placeholder="metros">
                                            </div>
                                        </div>
                                        <div class="col-md-3" id="campo_sim_l" style="display: block;">
                                            <div class="form-group">
                                                <label for="sim_l">Largura (L)</label>
                                                <input type="number" id="sim_l" class="form-control" step="0.01" placeholder="metros">
                                            </div>
                                        </div>
                                        <div class="col-md-3" id="campo_sim_h" style="display: block;">
                                            <div class="form-group">
                                                <label for="sim_h">Altura/Espessura (H)</label>
                                                <input type="number" id="sim_h" class="form-control" step="0.01" placeholder="metros">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="alert alert-info">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong><i class="fas fa-chart-line"></i> ELEMENTAR:</strong><br>
                                                <span id="resultado_elementar" class="h4" style="color: #ffffff !important; background-color: #17a2b8; display: inline-block; padding: 5px 15px; border-radius: 5px;">0.00</span>
                                                <span id="unidade_elementar" style="color: #ffffff;"></span>
                                            </div>
                                            <div class="col-md-6">
                                                <strong><i class="fas fa-chart-line"></i> PARCIAL:</strong><br>
                                                <span id="resultado_parcial" class="h4" style="color: #ffffff !important; background-color: #28a745; display: inline-block; padding: 5px 15px; border-radius: 5px;">0.00</span>
                                                <span id="unidade_parcial" style="color: #ffffff;"></span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <strong><i class="fas fa-percent"></i> PERDAS:</strong><br>
                                                <span id="resultado_perdas" class="h4" style="color: #ffffff !important; background-color: #ffc107; display: inline-block; padding: 5px 15px; border-radius: 5px;">0.00</span>
                                                <span id="unidade_perdas" style="color: #ffffff;"></span>
                                            </div>
                                            <div class="col-md-6">
                                                <strong><i class="fas fa-check-circle"></i> QUANTIDADE FINAL:</strong><br>
                                                <span id="resultado_quantidade" class="h4" style="color: #ffffff !important; background-color: #dc3545; display: inline-block; padding: 5px 15px; border-radius: 5px;">0.00</span>
                                                <span id="unidade_quantidade" style="color: #ffffff;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="sim_perda">Perda (%)</label>
                                <input type="number" id="sim_perda" class="form-control" step="0.5" value="5">
                                <small class="form-text text-muted">Digite a percentagem de perda para este componente</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                        
                        <?php if(isset($componente)): ?>
                            <?php if($componente->grupo_id): ?>
                                <a href="<?php echo e(route('admin.estrutura.componentes.por-grupo', $componente->grupo_id)); ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('admin.estrutura.componentes.por-actividade', $componente->actividade_id)); ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if(isset($grupoSelecionado) && $grupoSelecionado): ?>
                                <a href="<?php echo e(route('admin.estrutura.componentes.por-grupo', $grupoSelecionado->id)); ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            <?php elseif(isset($actividadeSelecionada) && $actividadeSelecionada): ?>
                                <a href="<?php echo e(route('admin.estrutura.componentes.por-actividade', $actividadeSelecionada->id)); ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('admin.estrutura.componentes.todos')); ?>" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancelar
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
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
                <h5>O que é um Componente?</h5>
                <p>O componente é o nível mais baixo da hierarquia. É o elemento que será medido na obra.</p>
                
                <h5 class="mt-3">Fórmulas de Cálculo:</h5>
                <ul>
                    <li><strong>Volume:</strong> C × L × H</li>
                    <li><strong>Área:</strong> C × L</li>
                    <li><strong>Área de Parede:</strong> C × H</li>
                    <li><strong>Área Lateral:</strong> L × H</li>
                    <li><strong>Comprimento Linear:</strong> C</li>
                    <li><strong>Largura:</strong> L</li>
                    <li><strong>Altura:</strong> H</li>
                    <li><strong>Valor Fixo:</strong> NPI × H (kg por unidade)</li>
                </ul>
                
                <div class="alert alert-success mt-3">
                    <i class="fas fa-chart-line"></i>
                    <strong>Como funciona o cálculo:</strong><br>
                    <strong>ELEMENTAR</strong> = C × L × H (conforme a fórmula selecionada)<br>
                    <strong>PARCIAL</strong> = NPI × ELEMENTAR<br>
                    <strong>PERDAS</strong> = PARCIAL × (Perda / 100)<br>
                    <strong>QUANTIDADE</strong> = PARCIAL + PERDAS
                </div>
                
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-lightbulb"></i>
                    <strong>Nota:</strong><br>
                    Este simulador ajuda a visualizar como a quantidade será calculada durante a medição.<br>
                    Os valores aqui são apenas para simulação e não afetam o componente salvo.
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formulaSelect = document.getElementById('formula_calculo');
        const campoValorPadrao = document.getElementById('campo_valor_padrao');
        
        // Campos de simulação
        const campoSimC = document.getElementById('campo_sim_c');
        const campoSimL = document.getElementById('campo_sim_l');
        const campoSimH = document.getElementById('campo_sim_h');
        
        // Função para mostrar/ocultar campos conforme a fórmula
        function atualizarCamposFormula() {
            const formula = formulaSelect.value;
            
            // Mostrar/ocultar campo de valor padrão
            if (formula === 'valor_fixo') {
                campoValorPadrao.style.display = 'block';
            } else {
                campoValorPadrao.style.display = 'none';
            }
            
            // Atualizar campos de simulação
            switch(formula) {
                case 'volume': // C × L × H
                    campoSimC.style.display = 'block';
                    campoSimL.style.display = 'block';
                    campoSimH.style.display = 'block';
                    break;
                case 'area': // C × L
                    campoSimC.style.display = 'block';
                    campoSimL.style.display = 'block';
                    campoSimH.style.display = 'none';
                    break;
                case 'area_parede': // C × H
                    campoSimC.style.display = 'block';
                    campoSimL.style.display = 'none';
                    campoSimH.style.display = 'block';
                    break;
                case 'area_lateral': // L × H
                    campoSimC.style.display = 'none';
                    campoSimL.style.display = 'block';
                    campoSimH.style.display = 'block';
                    break;
                case 'comprimento': // C
                    campoSimC.style.display = 'block';
                    campoSimL.style.display = 'none';
                    campoSimH.style.display = 'none';
                    break;
                case 'largura': // L
                    campoSimC.style.display = 'none';
                    campoSimL.style.display = 'block';
                    campoSimH.style.display = 'none';
                    break;
                case 'altura': // H
                    campoSimC.style.display = 'none';
                    campoSimL.style.display = 'none';
                    campoSimH.style.display = 'block';
                    break;
                case 'valor_fixo': // Fixo (kg por unidade)
                    campoSimC.style.display = 'none';
                    campoSimL.style.display = 'none';
                    campoSimH.style.display = 'block';
                    break;
                default:
                    campoSimC.style.display = 'block';
                    campoSimL.style.display = 'block';
                    campoSimH.style.display = 'block';
            }
            
            // Recalcular
            calcular();
        }
        
        // Função de cálculo
        function calcular() {
            const formula = formulaSelect.value;
            const npi = parseFloat(document.getElementById('sim_npi').value) || 0;
            const c = parseFloat(document.getElementById('sim_c').value) || 0;
            const l = parseFloat(document.getElementById('sim_l').value) || 0;
            const h = parseFloat(document.getElementById('sim_h').value) || 0;
            const perdaPercent = parseFloat(document.getElementById('sim_perda').value) || 0;
            
            const unidade = document.getElementById('unidade').value;
            
            let elementar = 0;
            
            switch(formula) {
                case 'volume':
                    elementar = c * l * h;
                    break;
                case 'area':
                    elementar = c * l;
                    break;
                case 'area_parede':
                    elementar = c * h;
                    break;
                case 'area_lateral':
                    elementar = l * h;
                    break;
                case 'comprimento':
                    elementar = c;
                    break;
                case 'largura':
                    elementar = l;
                    break;
                case 'altura':
                    elementar = h;
                    break;
                case 'valor_fixo':
                    elementar = h;
                    break;
                default:
                    elementar = 0;
            }
            
            const parcial = npi * elementar;
            const perdas = parcial * (perdaPercent / 100);
            const quantidade = parcial + perdas;
            
            // Atualizar os resultados
            document.getElementById('resultado_elementar').innerHTML = elementar.toFixed(2);
            document.getElementById('resultado_parcial').innerHTML = parcial.toFixed(2);
            document.getElementById('resultado_perdas').innerHTML = perdas.toFixed(2);
            document.getElementById('resultado_quantidade').innerHTML = quantidade.toFixed(2);
            
            // Atualizar unidades
            const unidadeTexto = unidade;
            document.getElementById('unidade_elementar').innerHTML = unidadeTexto;
            document.getElementById('unidade_parcial').innerHTML = unidadeTexto;
            document.getElementById('unidade_perdas').innerHTML = unidadeTexto;
            document.getElementById('unidade_quantidade').innerHTML = unidadeTexto;
        }
        
        // Adicionar event listeners
        formulaSelect.addEventListener('change', atualizarCamposFormula);
        document.getElementById('sim_npi').addEventListener('input', calcular);
        document.getElementById('sim_c').addEventListener('input', calcular);
        document.getElementById('sim_l').addEventListener('input', calcular);
        document.getElementById('sim_h').addEventListener('input', calcular);
        document.getElementById('sim_perda').addEventListener('input', calcular);
        document.getElementById('unidade').addEventListener('change', calcular);
        
        // Inicializar
        atualizarCamposFormula();
        
        // Preencher valores padrão para simulação se existirem dados do componente
        <?php if(isset($componente)): ?>
            document.getElementById('sim_npi').value = 1;
            document.getElementById('sim_perda').value = <?php echo e($componente->perda_padrao ?? 5); ?>;
            document.getElementById('unidade').value = '<?php echo e($componente->unidade); ?>';
            
            // Se for valor fixo e tiver valor padrão
            <?php if($componente->formula_calculo == 'valor_fixo' && $componente->valor_padrao): ?>
                document.getElementById('sim_h').value = <?php echo e($componente->valor_padrao); ?>;
                document.getElementById('sim_h').placeholder = 'kg por unidade';
            <?php endif; ?>
            
            calcular();
        <?php endif; ?>
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .alert-info .row {
        margin-bottom: 10px;
    }
    .alert-info span.h4 {
        font-size: 1.3rem;
        font-weight: bold;
        padding: 8px 16px;
        border-radius: 8px;
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Alvaro_Martins\Escaleno\base_orcamentos_escaleno\resources\views/admin/estrutura/componente-form.blade.php ENDPATH**/ ?>