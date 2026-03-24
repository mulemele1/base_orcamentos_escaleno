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
    @include('itens-orcamento.partials.validations')

    <input type="hidden" name="categoria_obra_id" value="{{ $categoria->id }}">

    {{-- Identificação --}}
    <div class="section-divider">
        <span class="section-divider-label"><i class="fas fa-fingerprint mr-1"></i>Identificação</span>
        <div class="section-divider-line"></div>
    </div>

    <div class="row" style="margin: 0 -10px;">
        <div class="col-md-4" style="padding: 0 10px;">
            <div class="field-group">
                <label class="field-label" for="item">Item <span class="req">*</span></label>
                <input type="text" id="item" name="item"
                       value="{{ old('item', $item->item ?? '') }}"
                       class="field-input @error('item') is-invalid @enderror"
                       placeholder="Ex: 1.1, 2.3.1" required>
                @error('item')
                    <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
                <div class="field-hint">Código do item de orçamento</div>
            </div>
        </div>

        <div class="col-md-4" style="padding: 0 10px;">
            <div class="field-group">
                <label class="field-label" for="unidade">Unidade <span class="req">*</span></label>
                <select id="unidade" name="unidade"
                        class="field-select @error('unidade') is-invalid @enderror" required>
                    <option value="">Selecione...</option>
                    @foreach($unidades as $unidade)
                        <option value="{{ $unidade }}"
                            {{ old('unidade', $item->unidade ?? '') == $unidade ? 'selected' : '' }}>
                            {{ $unidade }}
                        </option>
                    @endforeach
                </select>
                @error('unidade')
                    <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-4" style="padding: 0 10px;">
            <div class="field-group">
                <label class="field-label" for="material_id">Material Relacionado</label>
                <select id="material_id" name="material_id"
                        class="field-select @error('material_id') is-invalid @enderror">
                    <option value="">Nenhum</option>
                    @foreach($materiais as $material)
                        <option value="{{ $material->id }}"
                            {{ old('material_id', $item->material_id ?? '') == $material->id ? 'selected' : '' }}>
                            {{ $material->codigo }} — {{ $material->nome }}
                        </option>
                    @endforeach
                </select>
                @error('material_id')
                    <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="field-group">
        <label class="field-label" for="descricao">Descrição <span class="req">*</span></label>
        <textarea id="descricao" name="descricao"
                  class="field-textarea @error('descricao') is-invalid @enderror"
                  placeholder="Descrição detalhada do item" required>{{ old('descricao', $item->descricao ?? '') }}</textarea>
        @error('descricao')
            <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
    </div>

    {{-- Dimensões e Quantidades --}}
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
                           value="{{ old('npi', $item->npi ?? '1') }}"
                           class="field-input @error('npi') is-invalid @enderror"
                           min="1" onchange="calcular()" onkeyup="calcular()">
                    @error('npi')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3" style="padding: 0 10px;">
                <div class="field-group">
                    <label class="field-label" for="comprimento">Comprimento (C)</label>
                    <input type="number" step="0.01" min="0" id="comprimento" name="comprimento"
                           value="{{ old('comprimento', $item->comprimento ?? '') }}"
                           class="field-input @error('comprimento') is-invalid @enderror"
                           onchange="calcular()" onkeyup="calcular()">
                    @error('comprimento')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3" style="padding: 0 10px;">
                <div class="field-group">
                    <label class="field-label" for="largura">Largura (L)</label>
                    <input type="number" step="0.01" min="0" id="largura" name="largura"
                           value="{{ old('largura', $item->largura ?? '') }}"
                           class="field-input @error('largura') is-invalid @enderror"
                           onchange="calcular()" onkeyup="calcular()">
                    @error('largura')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-3" style="padding: 0 10px;">
                <div class="field-group">
                    <label class="field-label" for="altura">Altura (H)</label>
                    <input type="number" step="0.01" min="0" id="altura" name="altura"
                           value="{{ old('altura', $item->altura ?? '') }}"
                           class="field-input @error('altura') is-invalid @enderror"
                           onchange="calcular()" onkeyup="calcular()">
                    @error('altura')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row" style="margin: 0 -10px;">
            <div class="col-md-4" style="padding: 0 10px;">
                <div class="field-group" style="margin-bottom:0;">
                    <label class="field-label" for="perdas">Fator de Perdas</label>
                    <input type="number" step="0.01" min="1" max="100" id="perdas" name="perdas"
                           value="{{ old('perdas', $item->perdas ?? '1') }}"
                           class="field-input @error('perdas') is-invalid @enderror"
                           onchange="calcular()" onkeyup="calcular()">
                    @error('perdas')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                    <div class="field-hint">1 = 0% &nbsp;|&nbsp; 1.1 = 10% &nbsp;|&nbsp; 2 = 100%</div>
                </div>
            </div>
        </div>

        {{-- Calc Results --}}
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

    {{-- Custos e Preços --}}
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
                           value="{{ old('custo_fornecimento', $item->custo_fornecimento ?? '') }}"
                           class="field-input @error('custo_fornecimento') is-invalid @enderror"
                           onchange="calcularTotal()" onkeyup="calcularTotal()">
                    @error('custo_fornecimento')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4" style="padding: 0 10px;">
                <div class="field-group">
                    <label class="field-label" for="custo_mao_obra">Custo de Mão de Obra (MT)</label>
                    <input type="number" step="0.01" min="0" id="custo_mao_obra" name="custo_mao_obra"
                           value="{{ old('custo_mao_obra', $item->custo_mao_obra ?? '') }}"
                           class="field-input @error('custo_mao_obra') is-invalid @enderror"
                           onchange="calcularTotal()" onkeyup="calcularTotal()">
                    @error('custo_mao_obra')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-4" style="padding: 0 10px;">
                <div class="field-group">
                    <label class="field-label" for="preco_unitario">Preço Unitário (MT) <span class="req">*</span></label>
                    <input type="number" step="0.01" min="0" id="preco_unitario" name="preco_unitario"
                           value="{{ old('preco_unitario', $item->preco_unitario ?? '') }}"
                           class="field-input @error('preco_unitario') is-invalid @enderror"
                           required onchange="calcularTotal()" onkeyup="calcularTotal()">
                    @error('preco_unitario')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row" style="margin: 0 -10px;">
            <div class="col-md-4" style="padding: 0 10px;">
                <div class="field-group" style="margin-bottom: 0;">
                    <label class="field-label" for="quantidade_proposta">Quantidade Proposta <span class="req">*</span></label>
                    <input type="number" step="0.01" min="0" id="quantidade_proposta" name="quantidade_proposta"
                           value="{{ old('quantidade_proposta', $item->quantidade_proposta ?? '') }}"
                           class="field-input @error('quantidade_proposta') is-invalid @enderror"
                           required readonly>
                    @error('quantidade_proposta')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                    <div class="field-hint"><i class="fas fa-lock" style="font-size:.7rem;"></i> Calculado automaticamente</div>
                </div>
            </div>
            <div class="col-md-4" style="padding: 0 10px;">
                <div class="field-group" style="margin-bottom: 0;">
                    <label class="field-label" for="total">Total (MT) <span class="req">*</span></label>
                    <input type="number" step="0.01" min="0" id="total" name="total"
                           value="{{ old('total', $item->total ?? '') }}"
                           class="field-input @error('total') is-invalid @enderror"
                           required readonly>
                    @error('total')
                        <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                    <div class="field-hint"><i class="fas fa-lock" style="font-size:.7rem;"></i> Calculado automaticamente</div>
                </div>
            </div>
        </div>

        {{-- Total display --}}
        <div class="total-box">
            <div>
                <div class="total-box-label">Total do Item</div>
                <div class="total-box-value" id="display_total">MT 0,00</div>
            </div>
            <div class="total-box-icon"><i class="fas fa-coins"></i></div>
        </div>
    </div>

    {{-- Comentários --}}
    <div class="section-divider">
        <span class="section-divider-label"><i class="fas fa-comment-alt mr-1"></i>Observações</span>
        <div class="section-divider-line"></div>
    </div>

    <div class="field-group">
        <label class="field-label" for="comentarios">Comentários</label>
        <textarea id="comentarios" name="comentarios"
                  class="field-textarea @error('comentarios') is-invalid @enderror"
                  placeholder="Observações adicionais sobre o item">{{ old('comentarios', $item->comentarios ?? '') }}</textarea>
        @error('comentarios')
            <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
    </div>

    {{-- Meta (só em edição) --}}
    @if(isset($item) && $item->id)
    <div class="meta-box">
        <div class="meta-item">
            <i class="far fa-calendar-alt"></i>
            <span><strong>Criado em:</strong> {{ $item->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="meta-item">
            <i class="far fa-clock"></i>
            <span><strong>Última atualização:</strong> {{ $item->updated_at->format('d/m/Y H:i') }}</span>
        </div>
    </div>
    @endif
</div>

<div class="form-footer">
    <a href="{{ route('itens-orcamento.list', ['categoria_id' => $categoria->id]) }}" class="btn-cancel">
        <i class="fas fa-times"></i> Cancelar
    </a>
    <button type="submit" class="btn-save">
        <i class="fas fa-save"></i>
        {{ isset($item) && $item->id ? 'Atualizar Item' : 'Salvar Item' }}
    </button>
</div>

@push('js')
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
@endpush