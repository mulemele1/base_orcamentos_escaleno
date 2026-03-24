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

    /* ── Field styles ── */
    .field-group { margin-bottom: 22px; }

    .field-label {
        display: block;
        font-size: .8rem;
        font-weight: 600;
        color: var(--ink-soft);
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 7px;
    }
    .field-label .req { color: var(--red); margin-left: 2px; }

    .field-input,
    .field-textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-family: 'Roboto', sans-serif;
        font-size: .92rem;
        color: var(--ink);
        background: var(--surface);
        outline: none;
        transition: border-color .2s, box-shadow .2s, background .2s;
        appearance: none;
    }
    .field-textarea { resize: vertical; min-height: 90px; }
    .field-input:focus,
    .field-textarea:focus {
        border-color: var(--accent);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(28,110,243,.12);
    }
    .field-input.is-invalid,
    .field-textarea.is-invalid {
        border-color: var(--red);
        background: #fff5f5;
    }
    .field-input.is-invalid:focus,
    .field-textarea.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220,38,38,.12);
    }
    .field-hint {
        font-size: .78rem;
        color: var(--ink-muted);
        margin-top: 5px;
    }
    .field-error {
        font-size: .78rem;
        color: var(--red);
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ── Section Divider ── */
    .section-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 26px 0 20px;
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

    /* ── Meta info box ── */
    .meta-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 14px 18px;
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
    .meta-item i { color: var(--teal); font-size: .85rem; }
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
    @include('categorias-obra.partials.validations')

    {{-- Identificação --}}
    <div class="section-divider">
        <span class="section-divider-label"><i class="fas fa-fingerprint mr-1"></i>Identificação</span>
        <div class="section-divider-line"></div>
    </div>

    <div class="row" style="margin: 0 -10px;">
        <div class="col-md-6" style="padding: 0 10px;">
            <div class="field-group">
                <label class="field-label" for="codigo">
                    Código <span class="req">*</span>
                </label>
                <input type="text"
                       id="codigo"
                       name="codigo"
                       value="{{ old('codigo', $categoria->codigo ?? '') }}"
                       class="field-input @error('codigo') is-invalid @enderror"
                       placeholder="Ex: 01, 02, 03"
                       required>
                @error('codigo')
                    <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
                <div class="field-hint">Código único para identificar a categoria</div>
            </div>
        </div>

        <div class="col-md-3" style="padding: 0 10px;">
            <div class="field-group">
                <label class="field-label" for="ordem">
                    Ordem <span class="req">*</span>
                </label>
                <input type="number"
                       id="ordem"
                       name="ordem"
                       value="{{ old('ordem', $categoria->ordem ?? '0') }}"
                       class="field-input @error('ordem') is-invalid @enderror"
                       min="0"
                       required>
                @error('ordem')
                    <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
                <div class="field-hint">Ordem de exibição na listagem</div>
            </div>
        </div>
    </div>

    {{-- Dados Gerais --}}
    <div class="section-divider">
        <span class="section-divider-label"><i class="fas fa-align-left mr-1"></i>Dados Gerais</span>
        <div class="section-divider-line"></div>
    </div>

    <div class="field-group">
        <label class="field-label" for="nome">
            Nome da Categoria <span class="req">*</span>
        </label>
        <input type="text"
               id="nome"
               name="nome"
               value="{{ old('nome', $categoria->nome ?? '') }}"
               class="field-input @error('nome') is-invalid @enderror"
               placeholder="Ex: 01 - EDIFÍCIO PRINCIPAL"
               required>
        @error('nome')
            <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
    </div>

    <div class="field-group">
        <label class="field-label" for="descricao">Descrição</label>
        <textarea id="descricao"
                  name="descricao"
                  class="field-textarea @error('descricao') is-invalid @enderror"
                  placeholder="Descrição da categoria (opcional)">{{ old('descricao', $categoria->descricao ?? '') }}</textarea>
        @error('descricao')
            <div class="field-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
        @enderror
    </div>

    {{-- Meta info (só em edição) --}}
@if(isset($categoria) && $categoria->id)
<div class="meta-box">
    <div class="meta-item">
        <i class="far fa-calendar-alt"></i>
        <span><strong>Criado em:</strong> {{ $categoria->created_at->format('d/m/Y H:i') }}</span>
    </div>
    <div class="meta-item">
        <i class="far fa-clock"></i>
        <span><strong>Última atualização:</strong> {{ $categoria->updated_at->format('d/m/Y H:i') }}</span>
    </div>
</div>

{{-- Projetos vinculados --}}
@include('categorias-obra.partials.projetos_vinculados')
@endif
</div>

<div class="form-footer">
    <a href="{{ route('categorias-obra.list') }}" class="btn-cancel">
        <i class="fas fa-times"></i> Cancelar
    </a>
    <button type="submit" class="btn-save">
        <i class="fas fa-save"></i>
        {{ isset($categoria) && $categoria->id ? 'Atualizar Categoria' : 'Salvar Categoria' }}
    </button>
</div>