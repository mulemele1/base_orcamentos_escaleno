<div class="card-body">
    @include('itens-orcamento.partials.validations')

    <input type="hidden" name="categoria_obra_id" value="{{ $categoria->id }}">

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="item" class="required-field">Item</label>
                <input type="text" 
                       name="item" 
                       value="{{ old('item', $item->item ?? '') }}" 
                       class="form-control @error('item') is-invalid @enderror" 
                       id="item"
                       placeholder="Ex: 1.1, 2.3.1" 
                       required>
                @error('item')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <small class="text-muted">Código do item (ex: 1.1, 2.3.1)</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="unidade" class="required-field">Unidade</label>
                <select class="form-control @error('unidade') is-invalid @enderror" 
                        id="unidade" 
                        name="unidade" 
                        required>
                    <option value="">Selecione...</option>
                    @foreach($unidades as $unidade)
                        <option value="{{ $unidade }}" 
                            {{ old('unidade', $item->unidade ?? '') == $unidade ? 'selected' : '' }}>
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
                <label for="material_id">Material Relacionado</label>
                <select class="form-control @error('material_id') is-invalid @enderror" 
                        id="material_id" 
                        name="material_id">
                    <option value="">Nenhum</option>
                    @foreach($materiais as $material)
                        <option value="{{ $material->id }}" 
                            {{ old('material_id', $item->material_id ?? '') == $material->id ? 'selected' : '' }}>
                            {{ $material->codigo }} - {{ $material->nome }}
                        </option>
                    @endforeach
                </select>
                @error('material_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="descricao" class="required-field">Descrição</label>
        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                  id="descricao" 
                  name="descricao" 
                  rows="2"
                  placeholder="Descrição detalhada do item" 
                  required>{{ old('descricao', $item->descricao ?? '') }}</textarea>
        @error('descricao')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="card card-secondary mt-3">
        <div class="card-header">
            <h3 class="card-title">Dimensões e Quantidades</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="npi">NPI (Nº de Peças Iguais)</label>
                        <input type="number" 
                               name="npi" 
                               value="{{ old('npi', $item->npi ?? '1') }}" 
                               class="form-control @error('npi') is-invalid @enderror" 
                               id="npi"
                               min="1"
                               onchange="calcular()">
                        @error('npi')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="comprimento">Comprimento (C)</label>
                        <input type="number" 
                               step="0.01" 
                               min="0" 
                               name="comprimento" 
                               value="{{ old('comprimento', $item->comprimento ?? '') }}" 
                               class="form-control @error('comprimento') is-invalid @enderror" 
                               id="comprimento"
                               onchange="calcular()"
                               onkeyup="calcular()">
                        @error('comprimento')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="largura">Largura (L)</label>
                        <input type="number" 
                               step="0.01" 
                               min="0" 
                               name="largura" 
                               value="{{ old('largura', $item->largura ?? '') }}" 
                               class="form-control @error('largura') is-invalid @enderror" 
                               id="largura"
                               onchange="calcular()"
                               onkeyup="calcular()">
                        @error('largura')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="altura">Altura (H)</label>
                        <input type="number" 
                               step="0.01" 
                               min="0" 
                               name="altura" 
                               value="{{ old('altura', $item->altura ?? '') }}" 
                               class="form-control @error('altura') is-invalid @enderror" 
                               id="altura"
                               onchange="calcular()"
                               onkeyup="calcular()">
                        @error('altura')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="perdas">Fator de Perdas (%)</label>
                        <input type="number" 
                               step="0.01" 
                               min="1" 
                               max="100" 
                               name="perdas" 
                               value="{{ old('perdas', $item->perdas ?? '1') }}" 
                               class="form-control @error('perdas') is-invalid @enderror" 
                               id="perdas"
                               onchange="calcular()"
                               onkeyup="calcular()">
                        @error('perdas')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">1 = 0% | 1.1 = 10% | 2 = 100%</small>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text">Elementar (C x L x H)</span>
                            <span class="info-box-number" id="display_elementar">0,00</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text">Parcial (NPI x Elementar)</span>
                            <span class="info-box-number" id="display_parcial">0,00</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text">Quant. Proposta (c/ Perdas)</span>
                            <span class="info-box-number" id="display_quantidade">0,00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-secondary mt-3">
        <div class="card-header">
            <h3 class="card-title">Custos e Preços</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="custo_fornecimento">Custo de Fornecimento (MT)</label>
                        <input type="number" 
                               step="0.01" 
                               min="0" 
                               name="custo_fornecimento" 
                               value="{{ old('custo_fornecimento', $item->custo_fornecimento ?? '') }}" 
                               class="form-control @error('custo_fornecimento') is-invalid @enderror" 
                               id="custo_fornecimento"
                               onchange="calcularTotal()"
                               onkeyup="calcularTotal()">
                        @error('custo_fornecimento')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="custo_mao_obra">Custo de Mão de Obra (MT)</label>
                        <input type="number" 
                               step="0.01" 
                               min="0" 
                               name="custo_mao_obra" 
                               value="{{ old('custo_mao_obra', $item->custo_mao_obra ?? '') }}" 
                               class="form-control @error('custo_mao_obra') is-invalid @enderror" 
                               id="custo_mao_obra"
                               onchange="calcularTotal()"
                               onkeyup="calcularTotal()">
                        @error('custo_mao_obra')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="preco_unitario" class="required-field">Preço Unitário (MT)</label>
                        <input type="number" 
                               step="0.01" 
                               min="0" 
                               name="preco_unitario" 
                               value="{{ old('preco_unitario', $item->preco_unitario ?? '') }}" 
                               class="form-control @error('preco_unitario') is-invalid @enderror" 
                               id="preco_unitario"
                               required
                               onchange="calcularTotal()"
                               onkeyup="calcularTotal()">
                        @error('preco_unitario')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="quantidade_proposta" class="required-field">Quantidade Proposta</label>
                        <input type="number" 
                               step="0.01" 
                               min="0" 
                               name="quantidade_proposta" 
                               value="{{ old('quantidade_proposta', $item->quantidade_proposta ?? '') }}" 
                               class="form-control @error('quantidade_proposta') is-invalid @enderror" 
                               id="quantidade_proposta"
                               required
                               readonly
                               style="background-color: #e9ecef;">
                        @error('quantidade_proposta')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Calculado automaticamente</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="total" class="required-field">Total (MT)</label>
                        <input type="number" 
                               step="0.01" 
                               min="0" 
                               name="total" 
                               value="{{ old('total', $item->total ?? '') }}" 
                               class="form-control @error('total') is-invalid @enderror" 
                               id="total"
                               required
                               readonly
                               style="background-color: #e9ecef;">
                        @error('total')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="info-box bg-success">
                        <div class="info-box-content">
                            <span class="info-box-text">TOTAL DO ITEM</span>
                            <span class="info-box-number" id="display_total">MT 0,00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="comentarios">Comentários</label>
        <textarea class="form-control @error('comentarios') is-invalid @enderror" 
                  id="comentarios" 
                  name="comentarios" 
                  rows="2"
                  placeholder="Observações adicionais sobre o item">{{ old('comentarios', $item->comentarios ?? '') }}</textarea>
        @error('comentarios')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    @if(isset($item) && $item->id)
        <div class="alert alert-secondary mt-3">
            <div class="row">
                <div class="col-md-6">
                    <small>
                        <i class="far fa-calendar-alt mr-1"></i>
                        <strong>Criado em:</strong> {{ $item->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
                <div class="col-md-6">
                    <small>
                        <i class="far fa-clock mr-1"></i>
                        <strong>Última atualização:</strong> {{ $item->updated_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-secondary">
        <i class="fas fa-save mr-1"></i> {{ isset($item) ? 'Atualizar' : 'Salvar' }}
    </button>
    <a href="{{ route('itens-orcamento.list', ['categoria_id' => $categoria->id]) }}" class="btn btn-default">
        <i class="fas fa-times mr-1"></i> Cancelar
    </a>
</div>

@push('js')
<script>
    function calcular() {
        const npi = parseFloat(document.getElementById('npi').value) || 1;
        const comprimento = parseFloat(document.getElementById('comprimento').value) || 0;
        const largura = parseFloat(document.getElementById('largura').value) || 0;
        const altura = parseFloat(document.getElementById('altura').value) || 0;
        const perdas = parseFloat(document.getElementById('perdas').value) || 1;

        // Calcular elementar
        let elementar = 0;
        if (comprimento && largura && altura) {
            elementar = comprimento * largura * altura;
        } else if (comprimento && largura) {
            elementar = comprimento * largura;
        } else if (comprimento) {
            elementar = comprimento;
        }

        // Calcular parcial
        const parcial = elementar * npi;

        // Calcular quantidade proposta com perdas
        const quantidade = parcial * perdas;

        // Atualizar displays
        document.getElementById('display_elementar').innerText = elementar.toFixed(2).replace('.', ',');
        document.getElementById('display_parcial').innerText = parcial.toFixed(2).replace('.', ',');
        document.getElementById('display_quantidade').innerText = quantidade.toFixed(2).replace('.', ',');
        
        // Atualizar campo quantidade_proposta
        document.getElementById('quantidade_proposta').value = quantidade.toFixed(2);

        // Recalcular total
        calcularTotal();
    }

    function calcularTotal() {
        const quantidade = parseFloat(document.getElementById('quantidade_proposta').value) || 0;
        const precoUnitario = parseFloat(document.getElementById('preco_unitario').value) || 0;
        
        const total = quantidade * precoUnitario;
        
        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('display_total').innerHTML = 'MT ' + total.toFixed(2).replace('.', ',');
    }

    // Chamar calcular ao carregar a página
    document.addEventListener('DOMContentLoaded', function() {
        calcular();
    });

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

    form.addEventListener('submit', function() {
        formChanged = false;
    });
</script>
@endpush