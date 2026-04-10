<?php $__env->startSection('title', 'Editar Medição - ' . $projeto->nome); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit"></i> Editar Medição
                    </h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-info-circle"></i> Localização:</strong><br>
                                <?php if($medicao->componente->grupo): ?>
                                    Módulo: <?php echo e($medicao->componente->grupo->actividade->capitulo->modulo->nome); ?><br>
                                    Capítulo: <?php echo e($medicao->componente->grupo->actividade->capitulo->nome); ?><br>
                                    Actividade: <?php echo e($medicao->componente->grupo->actividade->nome); ?><br>
                                    Grupo: <?php echo e($medicao->componente->grupo->nome); ?>

                                <?php else: ?>
                                    Módulo: <?php echo e($medicao->componente->actividade->capitulo->modulo->nome); ?><br>
                                    Capítulo: <?php echo e($medicao->componente->actividade->capitulo->nome); ?><br>
                                    Actividade: <?php echo e($medicao->componente->actividade->nome); ?>

                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-calculator"></i> Informações do Componente:</strong><br>
                                Nome: <?php echo e($medicao->componente->nome); ?><br>
                                Unidade: <?php echo e($medicao->componente->unidade); ?><br>
                                Fórmula: 
                                <?php switch($medicao->componente->formula_calculo):
                                    case ('volume'): ?>
                                        NPI × C × L × H
                                        <?php break; ?>
                                    <?php case ('area'): ?>
                                        NPI × C × L
                                        <?php break; ?>
                                    <?php case ('area_parede'): ?>
                                        NPI × C × H
                                        <?php break; ?>
                                    <?php case ('area_lateral'): ?>
                                        NPI × L × H
                                        <?php break; ?>
                                    <?php case ('comprimento'): ?>
                                        NPI × C
                                        <?php break; ?>
                                    <?php case ('valor_fixo'): ?>
                                        NPI × H (kg por unidade)
                                        <?php break; ?>
                                <?php endswitch; ?>
                                <br>
                                Perda padrão: <?php echo e($medicao->componente->perda_padrao); ?>%
                            </div>
                        </div>
                    </div>
                    
                    <form action="<?php echo e(route('medicoes.update', [$projeto, $medicao])); ?>" method="POST" enctype="multipart/form-data" id="form-medicao">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <div class="form-group">
                            <label>Origem da Medição <span class="text-danger">*</span></label>
                            <div class="form-check">
                                <input type="radio" name="origem" value="desenho" id="origem_desenho" class="form-check-input" 
                                       <?php echo e(old('origem', $medicao->origem) == 'desenho' ? 'checked' : ''); ?>>
                                <label for="origem_desenho" class="form-check-label">
                                    <i class="fas fa-drafting-compass"></i> Desenho/Planta
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="origem" value="campo" id="origem_campo" class="form-check-input"
                                       <?php echo e(old('origem', $medicao->origem) == 'campo' ? 'checked' : ''); ?>>
                                <label for="origem_campo" class="form-check-label">
                                    <i class="fas fa-hard-hat"></i> Medição em Campo
                                </label>
                            </div>
                        </div>
                        
                        <div id="campos_desenho" class="campos-origem" style="<?php echo e(old('origem', $medicao->origem) == 'desenho' ? 'display:block' : 'display:none'); ?>">
                            <div class="form-group">
                                <label for="prancha">Número da Prancha/Desenho</label>
                                <input type="text" name="prancha" id="prancha" class="form-control" value="<?php echo e(old('prancha', $medicao->prancha)); ?>" placeholder="Ex: E-01, ARQ-02">
                            </div>
                        </div>
                        
                        <div id="campos_campo" class="campos-origem" style="<?php echo e(old('origem', $medicao->origem) == 'campo' ? 'display:block' : 'display:none'); ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="data_medicao">Data da Medição</label>
                                        <input type="date" name="data_medicao" id="data_medicao" class="form-control" value="<?php echo e(old('data_medicao', optional($medicao->data_medicao)->format('Y-m-d'))); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="medido_por">Medido por</label>
                                        <input type="text" name="medido_por" id="medido_por" class="form-control" value="<?php echo e(old('medido_por', $medicao->medido_por)); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="foto">Foto da Medição</label>
                                <?php if($medicao->foto_path): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo e(asset('storage/' . $medicao->foto_path)); ?>" alt="Foto da medição" style="max-width: 200px; max-height: 150px;" class="img-thumbnail">
                                        <br><small class="text-muted">Foto atual</small>
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="foto" id="foto" class="form-control-file" accept="image/*">
                                <small class="form-text text-muted">Formatos: JPG, PNG (máx. 5MB). Deixe em branco para manter a foto atual.</small>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="npi">NPI (Nº repetições) <span class="text-danger">*</span></label>
                                    <input type="number" name="npi" id="npi" class="form-control" step="1" min="1" value="<?php echo e(old('npi', $medicao->npi)); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="comprimento">Comprimento (C)</label>
                                    <input type="number" name="comprimento" id="comprimento" class="form-control" step="0.01" value="<?php echo e(old('comprimento', $medicao->comprimento)); ?>" placeholder="metros">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="largura">Largura (L)</label>
                                    <input type="number" name="largura" id="largura" class="form-control" step="0.01" value="<?php echo e(old('largura', $medicao->largura)); ?>" placeholder="metros">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="altura">Altura/Espessura (H)</label>
                                    <input type="number" name="altura" id="altura" class="form-control" step="0.01" value="<?php echo e(old('altura', $medicao->altura)); ?>" placeholder="metros">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="perda">Perda (%)</label>
                                    <input type="number" name="perda" id="perda" class="form-control" step="0.5" value="<?php echo e(old('perda', $medicao->perda)); ?>">
                                    <small class="form-text text-muted">Deixe em branco para usar a perda padrão</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info" id="resultado-calculo">
                            <strong><i class="fas fa-calculator"></i> Cálculo:</strong><br>
                            <span id="calculo-elementar">Calculando...</span>
                        </div>
                        
                        <div class="form-group">
                            <label for="observacoes">Observações</label>
                            <textarea name="observacoes" id="observacoes" class="form-control" rows="3"><?php echo e(old('observacoes', $medicao->observacoes)); ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Atualizar Medição
                            </button>
                            <a href="<?php echo e(route('medicoes.dashboard', $projeto)); ?>" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Cancelar
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
                        <i class="fas fa-info-circle"></i> Ajuda
                    </h3>
                </div>
                <div class="card-body">
                    <h5><i class="fas fa-calculator"></i> Como funciona o cálculo?</h5>
                    <p>A quantidade é calculada automaticamente baseado na fórmula do componente:</p>
                    <ul>
                        <li><strong>Volume:</strong> NPI × C × L × H</li>
                        <li><strong>Área:</strong> NPI × C × L</li>
                        <li><strong>Área de Parede:</strong> NPI × C × H</li>
                        <li><strong>Comprimento Linear:</strong> NPI × C</li>
                        <li><strong>Valor Fixo:</strong> NPI × H (onde H é kg/unidade)</li>
                    </ul>
                    <p><strong>Perda:</strong> Aumenta a quantidade final em % para compensar desperdícios.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    // Alternar campos conforme origem
    document.querySelectorAll('input[name="origem"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const camposDesenho = document.getElementById('campos_desenho');
            const camposCampo = document.getElementById('campos_campo');
            if (this.value === 'desenho') {
                camposDesenho.style.display = 'block';
                camposCampo.style.display = 'none';
            } else {
                camposDesenho.style.display = 'none';
                camposCampo.style.display = 'block';
            }
        });
    });
    
    // Cálculo em tempo real
    const npiInput = document.getElementById('npi');
    const comprimentoInput = document.getElementById('comprimento');
    const larguraInput = document.getElementById('largura');
    const alturaInput = document.getElementById('altura');
    const perdaInput = document.getElementById('perda');
    const resultadoSpan = document.getElementById('calculo-elementar');
    
    const componente = <?php echo json_encode($medicao->componente, 15, 512) ?>;
    
    function calcular() {
        const npi = parseFloat(npiInput.value) || 0;
        const comprimento = parseFloat(comprimentoInput.value) || 0;
        const largura = parseFloat(larguraInput.value) || 0;
        const altura = parseFloat(alturaInput.value) || 0;
        const perda = parseFloat(perdaInput.value) || 0;
        
        let elementar = 0;
        let formulaDesc = '';
        
        switch(componente.formula_calculo) {
            case 'volume':
                elementar = npi * comprimento * largura * altura;
                formulaDesc = `${npi} × ${comprimento} × ${largura} × ${altura}`;
                break;
            case 'area':
                elementar = npi * comprimento * largura;
                formulaDesc = `${npi} × ${comprimento} × ${largura}`;
                break;
            case 'area_parede':
                elementar = npi * comprimento * altura;
                formulaDesc = `${npi} × ${comprimento} × ${altura}`;
                break;
            case 'area_lateral':
                elementar = npi * largura * altura;
                formulaDesc = `${npi} × ${largura} × ${altura}`;
                break;
            case 'comprimento':
                elementar = npi * comprimento;
                formulaDesc = `${npi} × ${comprimento}`;
                break;
            case 'largura':
                elementar = npi * largura;
                formulaDesc = `${npi} × ${largura}`;
                break;
            case 'altura':
                elementar = npi * altura;
                formulaDesc = `${npi} × ${altura}`;
                break;
            case 'valor_fixo':
                elementar = npi * (altura > 0 ? altura : 1);
                formulaDesc = `${npi} × ${altura > 0 ? altura : 'valor padrão'}`;
                break;
            default:
                elementar = 0;
        }
        
        const quantidade = elementar * (1 + perda / 100);
        
        resultadoSpan.innerHTML = `
            <strong>Elementar:</strong> ${formulaDesc} = ${elementar.toFixed(2)} ${componente.unidade}<br>
            <strong>+ Perda (${perda}%):</strong> ${elementar.toFixed(2)} × ${(1 + perda/100).toFixed(2)} = <strong class="text-success">${quantidade.toFixed(2)} ${componente.unidade}</strong>
        `;
    }
    
    // Adicionar event listeners
    if (npiInput) npiInput.addEventListener('input', calcular);
    if (comprimentoInput) comprimentoInput.addEventListener('input', calcular);
    if (larguraInput) larguraInput.addEventListener('input', calcular);
    if (alturaInput) alturaInput.addEventListener('input', calcular);
    if (perdaInput) perdaInput.addEventListener('input', calcular);
    
    // Calcular ao carregar a página
    calcular();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Alvaro_Martins\Escaleno\base_orcamentos_escaleno\resources\views/medicoes/edit.blade.php ENDPATH**/ ?>