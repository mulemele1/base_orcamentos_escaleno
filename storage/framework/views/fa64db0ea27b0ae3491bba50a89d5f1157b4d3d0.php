<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;500;600;700;800&family=Roboto:wght@300;400;500;600&display=swap');

    :root {
        --ink:       #0d1117;
        --ink-soft:  #3a4252;
        --ink-muted: #8891a4;
        --surface:   #f4f5f7;
        --card:      #ffffff;
        --border:    #e2e5eb;
        --accent:    #1c6ef3;
        --green:     #16a34a;
        --amber:     #d97706;
        --red:       #dc2626;
        --teal:      #0891b2;
        --radius:    12px;
        --shadow-sm: 0 1px 3px rgba(0,0,0,.06);
    }

    body, .wrapper {
        background: var(--surface) !important;
        font-family: 'Roboto', sans-serif !important;
        color: var(--ink) !important;
    }

    /* ── Field ── */
    .field-group { margin-bottom: 20px; }
    .field-label {
        display: block;
        font-size: .78rem;
        font-weight: 600;
        color: var(--ink-soft);
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 6px;
    }
    .field-label .req { color: var(--red); margin-left: 2px; }
    .field-input,
    .field-select,
    .field-textarea {
        width: 100%;
        padding: 9px 13px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-family: 'Roboto', sans-serif;
        font-size: .9rem;
        color: var(--ink);
        background: var(--surface);
        outline: none;
        transition: border-color .2s, box-shadow .2s, background .2s;
        appearance: none;
    }
    .field-textarea { resize: vertical; min-height: 72px; }
    .field-input:focus,
    .field-select:focus,
    .field-textarea:focus {
        border-color: var(--accent);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(28,110,243,.12);
    }
    .field-input.is-invalid,
    .field-select.is-invalid,
    .field-textarea.is-invalid {
        border-color: var(--red);
        background: #fff5f5;
    }
    .field-input.is-invalid:focus,
    .field-select.is-invalid:focus,
    .field-textarea.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220,38,38,.12);
    }
    .field-input[readonly] {
        background: var(--surface);
        color: var(--ink-muted);
        cursor: not-allowed;
        border-style: dashed;
    }
    .field-hint {
        font-size: .76rem;
        color: var(--ink-muted);
        margin-top: 4px;
    }
    .field-error {
        font-size: .76rem;
        color: var(--red);
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ── Section Divider ── */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 28px 0 20px;
    }
    .section-divider-label {
        font-family: 'Roboto Slab', serif;
        font-size: .78rem;
        font-weight: 600;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: .7px;
        white-space: nowrap;
    }
    .section-divider-line {
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    /* ── Sub Panel (replaces inner card) ── */
    .sub-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 20px 22px;
        margin-bottom: 0;
    }

    /* ── Calc Display Boxes ── */
    .calc-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 20px;
    }
    .calc-box {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 9px;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 4px;
        box-shadow: var(--shadow-sm);
        transition: border-color .2s;
    }
    .calc-box:hover { border-color: rgba(28,110,243,.25); }
    .calc-box-label {
        font-size: .72rem;
        font-weight: 600;
        color: var(--ink-muted);
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .calc-box-value {
        font-family: 'Roboto Slab', serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--ink);
        font-variant-numeric: tabular-nums;
    }

    /* ── Total Display Box ── */
    .total-box {
        background: linear-gradient(135deg, #14532d 0%, #166534 100%);
        border-radius: 10px;
        padding: 18px 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 20px;
    }
    .total-box-label {
        font-size: .8rem;
        font-weight: 600;
        color: rgba(255,255,255,.65);
        text-transform: uppercase;
        letter-spacing: .7px;
    }
    .total-box-value {
        font-family: 'Roboto Slab', serif;
        font-size: 1.6rem;
        font-weight: 800;
        color: #fff;
        font-variant-numeric: tabular-nums;
        letter-spacing: -.3px;
    }
    .total-box-icon {
        width: 44px; height: 44px;
        border-radius: 10px;
        background: rgba(255,255,255,.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: rgba(255,255,255,.8);
    }

    /* ── Meta Box ── */
    .meta-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 12px 18px;
        margin-top: 24px;
        display: flex;
        gap: 32px;
        flex-wrap: wrap;
    }
    .meta-item {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: .82rem;
        color: var(--ink-muted);
    }
    .meta-item i { color: var(--teal); }
    .meta-item strong { color: var(--ink-soft); font-weight: 600; }

    /* ── Footer Buttons ── */
    .form-footer {
        padding: 20px 28px;
        border-top: 1px solid var(--border);
        background: var(--surface);
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        border-radius: 0 0 var(--radius) var(--radius);
    }
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 22px;
        border-radius: 8px;
        font-family: 'Roboto', sans-serif;
        font-size: .88rem;
        font-weight: 500;
        text-decoration: none !important;
        border: 1.5px solid var(--border);
        background: var(--card);
        color: var(--ink-soft) !important;
        transition: all .2s;
        cursor: pointer;
    }
    .btn-cancel:hover {
        border-color: var(--ink-muted);
        color: var(--ink) !important;
        transform: translateY(-1px);
    }
    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 26px;
        border-radius: 8px;
        font-family: 'Roboto', sans-serif;
        font-size: .88rem;
        font-weight: 600;
        border: none;
        background: var(--accent);
        color: #fff;
        cursor: pointer;
        transition: all .2s;
    }
    .btn-save:hover {
        background: #1558d0;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(28,110,243,.35);
    }
    .btn-save:active { transform: translateY(0); }
</style>

<div style="padding: 28px 28px 4px;">
    <?php echo $__env->make('itens-orcamento.partials.validations', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <input type="hidden" name="categoria_obra_id" value="<?php echo e($categoria->id); ?>">

    
    <div class="section-divider">
        <span class="section-divider-label"><i class="fas fa-fingerprint mr-1"></i>Identificação</span>
        <div class="section-divider-line"></div>
    </div>

    <div class="row" style="margin: 0 -10px;">
        <div class="col-md-4" style="padding: 0 10px;">
            <div class="field-group">
                <label class="field-label" for="item">Item <span class="req">*</span></label>
                <input type="text" id="item" name="item"
                       value="<?php echo e(old('item', $item->item ?? '')); ?>"
                       class="field-input <?php $__errorArgs = ['item'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       placeholder="Ex: 1.1, 2.3.1" required>
                <?php $__errorArgs = ['item'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="field-hint">Código do item de orçamento</div>
            </div>
        </div>

        <div class="col-md-4" style="padding: 0 10px;">
            <div class="field-group">
                <label class="field-label" for="unidade">Unidade <span class="req">*</span></label>
                <select id="unidade" name="unidade"
                        class="field-select <?php $__errorArgs = ['unidade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                    <option value="">Selecione...</option>
                    <?php $__currentLoopData = $unidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unidade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($unidade); ?>"
                            <?php echo e(old('unidade', $item->unidade ?? '') == $unidade ? 'selected' : ''); ?>>
                            <?php echo e($unidade); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['unidade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="col-md-4" style="padding: 0 10px;">
            <div class="field-group">
                <label class="field-label" for="material_id">Material Relacionado</label>
                <select id="material_id" name="material_id"
                        class="field-select <?php $__errorArgs = ['material_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">Nenhum</option>
                    <?php $__currentLoopData = $materiais; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($material->id); ?>"
                            <?php echo e(old('material_id', $item->material_id ?? '') == $material->id ? 'selected' : ''); ?>>
                            <?php echo e($material->codigo); ?> — <?php echo e($material->nome); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['material_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </div>

    <div class="field-group">
        <label class="field-label" for="descricao">Descrição <span class="req">*</span></label>
        <textarea id="descricao" name="descricao"
                  class="field-textarea <?php $__errorArgs = ['descricao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                  placeholder="Descrição detalhada do item" required><?php echo e(old('descricao', $item->descricao ?? '')); ?></textarea>
        <?php $__errorArgs = ['descricao'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <div class="section-divider">
        <span class="section-divider-label"><i class="fas fa-ruler-combined mr-1"></i>Dimensões e Quantidades</span>
        <div class="section-divider-line"></div>
    </div>

    <div class="sub-panel">
        <div class="row" style="margin: 0 -10px;">
            <div class="col-md-3" style="padding: 0 10px;">
                <div class="field-group">
                    <label class="field-label" for="npi">NPI (Nº de Peças Iguais)</label>
                    <input type="number" id="npi" name="npi"
                           value="<?php echo e(old('npi', $item->npi ?? '1')); ?>"
                           class="field-input <?php $__errorArgs = ['npi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           min="1" onchange="calcular()" onkeyup="calcular()">
                    <?php $__errorArgs = ['npi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="col-md-3" style="padding: 0 10px;">
                <div class="field-group">
                    <label class="field-label" for="comprimento">Comprimento (C)</label>
                    <input type="number" step="0.01" min="0" id="comprimento" name="comprimento"
                           value="<?php echo e(old('comprimento', $item->comprimento ?? '')); ?>"
                           class="field-input <?php $__errorArgs = ['comprimento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           onchange="calcular()" onkeyup="calcular()">
                    <?php $__errorArgs = ['comprimento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="col-md-3" style="padding: 0 10px;">
                <div class="field-group">
                    <label class="field-label" for="largura">Largura (L)</label>
                    <input type="number" step="0.01" min="0" id="largura" name="largura"
                           value="<?php echo e(old('largura', $item->largura ?? '')); ?>"
                           class="field-input <?php $__errorArgs = ['largura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           onchange="calcular()" onkeyup="calcular()">
                    <?php $__errorArgs = ['largura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="col-md-3" style="padding: 0 10px;">
                <div class="field-group">
                    <label class="field-label" for="altura">Altura (H)</label>
                    <input type="number" step="0.01" min="0" id="altura" name="altura"
                           value="<?php echo e(old('altura', $item->altura ?? '')); ?>"
                           class="field-input <?php $__errorArgs = ['altura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           onchange="calcular()" onkeyup="calcular()">
                    <?php $__errorArgs = ['altura'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        <div class="row" style="margin: 0 -10px;">
            <div class="col-md-4" style="padding: 0 10px;">
                <div class="field-group" style="margin-bottom:0;">
                    <label class="field-label" for="perdas">Fator de Perdas</label>
                    <input type="number" step="0.01" min="1" max="100" id="perdas" name="perdas"
                           value="<?php echo e(old('perdas', $item->perdas ?? '1')); ?>"
                           class="field-input <?php $__errorArgs = ['perdas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           onchange="calcular()" onkeyup="calcular()">
                    <?php $__errorArgs = ['perdas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="field-hint">1 = 0% &nbsp;|&nbsp; 1.1 = 10% &nbsp;|&nbsp; 2 = 100%</div>
                </div>
            </div>
        </div>

        
        <div class="calc-row">
            <div class="calc-box">
                <span class="calc-box-label">Elementar (C × L × H)</span>
                <span class="calc-box-value" id="display_elementar">0,00</span>
            </div>
            <div class="calc-box">
                <span class="calc-box-label">Parcial (NPI × Elementar)</span>
                <span class="calc-box-value" id="display_parcial">0,00</span>
            </div>
            <div class="calc-box">
                <span class="calc-box-label">Quant. Proposta (c/ Perdas)</span>
                <span class="calc-box-value" id="display_quantidade">0,00</span>
            </div>
        </div>
    </div>

    
    <div class="section-divider">
        <span class="section-divider-label"><i class="fas fa-coins mr-1"></i>Custos e Preços</span>
        <div class="section-divider-line"></div>
    </div>

    <div class="sub-panel">
        <div class="row" style="margin: 0 -10px;">
            <div class="col-md-4" style="padding: 0 10px;">
                <div class="field-group">
                    <label class="field-label" for="custo_fornecimento">Custo de Fornecimento (MT)</label>
                    <input type="number" step="0.01" min="0" id="custo_fornecimento" name="custo_fornecimento"
                           value="<?php echo e(old('custo_fornecimento', $item->custo_fornecimento ?? '')); ?>"
                           class="field-input <?php $__errorArgs = ['custo_fornecimento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           onchange="calcularTotal()" onkeyup="calcularTotal()">
                    <?php $__errorArgs = ['custo_fornecimento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="col-md-4" style="padding: 0 10px;">
                <div class="field-group">
                    <label class="field-label" for="custo_mao_obra">Custo de Mão de Obra (MT)</label>
                    <input type="number" step="0.01" min="0" id="custo_mao_obra" name="custo_mao_obra"
                           value="<?php echo e(old('custo_mao_obra', $item->custo_mao_obra ?? '')); ?>"
                           class="field-input <?php $__errorArgs = ['custo_mao_obra'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           onchange="calcularTotal()" onkeyup="calcularTotal()">
                    <?php $__errorArgs = ['custo_mao_obra'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
            <div class="col-md-4" style="padding: 0 10px;">
                <div class="field-group">
                    <label class="field-label" for="preco_unitario">Preço Unitário (MT) <span class="req">*</span></label>
                    <input type="number" step="0.01" min="0" id="preco_unitario" name="preco_unitario"
                           value="<?php echo e(old('preco_unitario', $item->preco_unitario ?? '')); ?>"
                           class="field-input <?php $__errorArgs = ['preco_unitario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required onchange="calcularTotal()" onkeyup="calcularTotal()">
                    <?php $__errorArgs = ['preco_unitario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        <div class="row" style="margin: 0 -10px;">
            <div class="col-md-4" style="padding: 0 10px;">
                <div class="field-group" style="margin-bottom: 0;">
                    <label class="field-label" for="quantidade_proposta">Quantidade Proposta <span class="req">*</span></label>
                    <input type="number" step="0.01" min="0" id="quantidade_proposta" name="quantidade_proposta"
                           value="<?php echo e(old('quantidade_proposta', $item->quantidade_proposta ?? '')); ?>"
                           class="field-input <?php $__errorArgs = ['quantidade_proposta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required readonly>
                    <?php $__errorArgs = ['quantidade_proposta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="field-hint"><i class="fas fa-lock" style="font-size:.7rem;"></i> Calculado automaticamente</div>
                </div>
            </div>
            <div class="col-md-4" style="padding: 0 10px;">
                <div class="field-group" style="margin-bottom: 0;">
                    <label class="field-label" for="total">Total (MT) <span class="req">*</span></label>
                    <input type="number" step="0.01" min="0" id="total" name="total"
                           value="<?php echo e(old('total', $item->total ?? '')); ?>"
                           class="field-input <?php $__errorArgs = ['total'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           required readonly>
                    <?php $__errorArgs = ['total'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="field-hint"><i class="fas fa-lock" style="font-size:.7rem;"></i> Calculado automaticamente</div>
                </div>
            </div>
        </div>

        
        <div class="total-box">
            <div>
                <div class="total-box-label">Total do Item</div>
                <div class="total-box-value" id="display_total">MT 0,00</div>
            </div>
            <div class="total-box-icon"><i class="fas fa-coins"></i></div>
        </div>
    </div>

    
    <div class="section-divider">
        <span class="section-divider-label"><i class="fas fa-comment-alt mr-1"></i>Observações</span>
        <div class="section-divider-line"></div>
    </div>

    <div class="field-group">
        <label class="field-label" for="comentarios">Comentários</label>
        <textarea id="comentarios" name="comentarios"
                  class="field-textarea <?php $__errorArgs = ['comentarios'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                  placeholder="Observações adicionais sobre o item"><?php echo e(old('comentarios', $item->comentarios ?? '')); ?></textarea>
        <?php $__errorArgs = ['comentarios'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="field-error"><i class="fas fa-exclamation-circle"></i> <?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <?php if(isset($item) && $item->id): ?>
    <div class="meta-box">
        <div class="meta-item">
            <i class="far fa-calendar-alt"></i>
            <span><strong>Criado em:</strong> <?php echo e($item->created_at->format('d/m/Y H:i')); ?></span>
        </div>
        <div class="meta-item">
            <i class="far fa-clock"></i>
            <span><strong>Última atualização:</strong> <?php echo e($item->updated_at->format('d/m/Y H:i')); ?></span>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="form-footer">
    <a href="<?php echo e(route('itens-orcamento.list', ['categoria_id' => $categoria->id])); ?>" class="btn-cancel">
        <i class="fas fa-times"></i> Cancelar
    </a>
    <button type="submit" class="btn-save">
        <i class="fas fa-save"></i>
        <?php echo e(isset($item) && $item->id ? 'Atualizar Item' : 'Salvar Item'); ?>

    </button>
</div>

<?php $__env->startPush('js'); ?>
<script>
    function calcular() {
        const npi         = parseFloat(document.getElementById('npi').value)         || 1;
        const comprimento = parseFloat(document.getElementById('comprimento').value) || 0;
        const largura     = parseFloat(document.getElementById('largura').value)     || 0;
        const altura      = parseFloat(document.getElementById('altura').value)      || 0;
        const perdas      = parseFloat(document.getElementById('perdas').value)      || 1;

        let elementar = 0;
        if (comprimento && largura && altura)   elementar = comprimento * largura * altura;
        else if (comprimento && largura)         elementar = comprimento * largura;
        else if (comprimento)                    elementar = comprimento;

        const parcial    = elementar * npi;
        const quantidade = parcial * perdas;

        const fmt = v => v.toFixed(2).replace('.', ',');

        document.getElementById('display_elementar').innerText  = fmt(elementar);
        document.getElementById('display_parcial').innerText    = fmt(parcial);
        document.getElementById('display_quantidade').innerText = fmt(quantidade);
        document.getElementById('quantidade_proposta').value    = quantidade.toFixed(2);

        calcularTotal();
    }

    function calcularTotal() {
        const quantidade    = parseFloat(document.getElementById('quantidade_proposta').value) || 0;
        const precoUnitario = parseFloat(document.getElementById('preco_unitario').value)      || 0;
        const total         = quantidade * precoUnitario;

        document.getElementById('total').value              = total.toFixed(2);
        document.getElementById('display_total').innerText = 'MT ' + total.toFixed(2).replace('.', ',');
    }

    document.addEventListener('DOMContentLoaded', () => calcular());

    // Aviso de saída com alterações não salvas
    let formChanged = false;
    const form   = document.querySelector('form');
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(el => {
        el.addEventListener('change', () => formChanged = true);
        el.addEventListener('keyup',  () => formChanged = true);
    });
    window.addEventListener('beforeunload', e => {
        if (formChanged) { e.preventDefault(); e.returnValue = ''; }
    });
    form.addEventListener('submit', () => formChanged = false);
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\Users\escaleno\Programacao\base_orcamentos_escaleno\resources\views/itens-orcamento/partials/form.blade.php ENDPATH**/ ?>