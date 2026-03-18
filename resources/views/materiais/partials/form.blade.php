

<div class="card-body">
    @include('materiais.partials.validations')

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="codigo" class="required-field">Código</label>
                <input type="text" 
                       name="codigo" 
                       value="{{ old('codigo', $material->codigo ?? '') }}" 
                       class="form-control @error('codigo') is-invalid @enderror" 
                       id="codigo"
                       placeholder="Ex: 1.1, 2.3, 3.1.4" 
                       required>
                @error('codigo')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <small class="text-muted">Formato recomendado: número com pontos (ex: 1.1, 2.3.1)</small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="categoria" class="required-field">Categoria</label>
                <select class="form-control @error('categoria') is-invalid @enderror" 
                        id="categoria" 
                        name="categoria" 
                        required>
                    <option value="">Selecione uma categoria</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria }}" 
                            {{ old('categoria', $material->categoria ?? '') == $categoria ? 'selected' : '' }}>
                            {{ $categoria }}
                        </option>
                    @endforeach
                </select>
                @error('categoria')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="nome" class="required-field">Nome do Material</label>
        <input type="text" 
               name="nome" 
               value="{{ old('nome', $material->nome ?? '') }}" 
               class="form-control @error('nome') is-invalid @enderror" 
               id="nome"
               placeholder="Ex: Cimento portland normal 42.5N" 
               required>
        @error('nome')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="unidade" class="required-field">Unidade</label>
                <select class="form-control @error('unidade') is-invalid @enderror" 
                        id="unidade" 
                        name="unidade" 
                        required>
                    <option value="">Selecione...</option>
                    @foreach($unidades as $key => $unidade)
                        <option value="{{ $key }}" 
                            {{ old('unidade', $material->unidade ?? '') == $key ? 'selected' : '' }}>
                            {{ $unidade }}
                        </option>
                    @endforeach
                </select>
                @error('unidade')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="valor_compra" class="required-field">Valor de Compra (MT)</label>
                <input type="number" 
                       step="0.01" 
                       min="0" 
                       name="valor_compra" 
                       value="{{ old('valor_compra', $material->valor_compra ?? '') }}" 
                       class="form-control @error('valor_compra') is-invalid @enderror" 
                       id="valor_compra"
                       placeholder="0.00" 
                       required>
                @error('valor_compra')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="rendimento" class="required-field">Rendimento</label>
                <input type="number" 
                       step="0.01" 
                       min="0" 
                       name="rendimento" 
                       value="{{ old('rendimento', $material->rendimento ?? '1') }}" 
                       class="form-control @error('rendimento') is-invalid @enderror" 
                       id="rendimento"
                       placeholder="Ex: 50, 5.8" 
                       required>
                @error('rendimento')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <small class="text-muted">Quantidade por unidade (ex: kg por m², metros por barra)</small>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                  id="descricao" 
                  name="descricao" 
                  rows="3"
                  placeholder="Descrição detalhada do material (opcional)">{{ old('descricao', $material->descricao ?? '') }}</textarea>
        @error('descricao')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="observacoes">Observações</label>
        <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                  id="observacoes" 
                  name="observacoes" 
                  rows="2"
                  placeholder="Informações adicionais, notas sobre fornecedores, etc. (opcional)">{{ old('observacoes', $material->observacoes ?? '') }}</textarea>
        @error('observacoes')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- Preview de cálculo -->
    <div class="preview-calculo" id="previewCalculo" style="display: none;">
        <strong><i class="fas fa-calculator mr-2"></i>Pré-visualização do cálculo:</strong><br>
        <span id="previewTexto"></span>
    </div>

    <!-- Informações do sistema (apenas para edição) -->
    @if(isset($material) && $material->id)
        <div class="alert alert-secondary mt-3">
            <div class="row">
                <div class="col-md-6">
                    <small>
                        <i class="far fa-calendar-alt mr-1"></i>
                        <strong>Criado em:</strong> {{ $material->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
                <div class="col-md-6">
                    <small>
                        <i class="far fa-clock mr-1"></i>
                        <strong>Última atualização:</strong> {{ $material->updated_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    @endif
</div>
<!-- /.card-body -->

<div class="card-footer">
    <button type="submit" class="btn btn-secondary">
        <i class="fas fa-save mr-1"></i> {{ isset($material) ? 'Atualizar' : 'Salvar' }}
    </button>
    <a href="{{ route('materiais.list') }}" class="btn btn-default">
        <i class="fas fa-times mr-1"></i> Cancelar
    </a>
</div>

@push('js')
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
@endpush