@extends('adminlte::page')

@section('title', 'Adicionar Material à Composição')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-plus-circle mr-2"></i>Adicionar Material</h1>
    <a href="{{ route('composicoes.index', ['subatividade_id' => $subatividadeId]) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Voltar
    </a>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">
                    <i class="fas fa-cube mr-1"></i> Vincular Material à Subatividade
                </h3>
            </div>
            <form action="{{ route('composicoes.store') }}" method="POST" id="composicaoForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subatividade_id">Subatividade <span class="text-danger">*</span></label>
                                <select class="form-control @error('subatividade_id') is-invalid @enderror" 
                                        id="subatividade_id" 
                                        name="subatividade_id" 
                                        required>
                                    <option value="">Selecione...</option>
                                    @foreach($subatividades as $sub)
                                        <option value="{{ $sub->id }}" 
                                            {{ old('subatividade_id', $subatividadeId) == $sub->id ? 'selected' : '' }}>
                                            [{{ $sub->atividade->categoriaObra->codigo }}.{{ $sub->atividade->codigo }}.{{ $sub->codigo }}]
                                            {{ $sub->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subatividade_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="material_id">Material (da Base de Preços) <span class="text-danger">*</span></label>
                                <select class="form-control select2 @error('material_id') is-invalid @enderror" 
                                        id="material_id" 
                                        name="material_id" 
                                        required
                                        style="width: 100%;">
                                    <option value="">Selecione um material...</option>
                                    @foreach($materiais as $material)
                                        <option value="{{ $material->id }}" 
                                            data-unidade="{{ $material->unidade }}"
                                            data-preco="{{ $material->valor_compra }}"
                                            {{ old('material_id') == $material->id ? 'selected' : '' }}>
                                            [{{ $material->codigo }}] {{ $material->nome }} - {{ $material->unidade }} - MT {{ number_format($material->valor_compra, 2, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('material_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="quantidade">Quantidade <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('quantidade') is-invalid @enderror" 
                                       id="quantidade" 
                                       name="quantidade" 
                                       value="{{ old('quantidade', 1) }}" 
                                       min="0.001"
                                       step="0.001"
                                       required>
                                @error('quantidade')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="unidade">Unidade</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="unidade" 
                                       name="unidade" 
                                       value="{{ old('unidade') }}" 
                                       readonly
                                       placeholder="Auto">
                                <small class="text-muted">Vem do material</small>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="custo_unitario">Custo Unitário (MT)</label>
                                <input type="number" 
                                       class="form-control @error('custo_unitario') is-invalid @enderror" 
                                       id="custo_unitario" 
                                       name="custo_unitario" 
                                       value="{{ old('custo_unitario') }}" 
                                       min="0"
                                       step="0.01"
                                       placeholder="Auto da Base">
                                <small class="text-muted">Deixe vazio para usar o preço da Base</small>
                                @error('custo_unitario')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="custo_total">Custo Total (MT)</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="custo_total" 
                                       value="0,00" 
                                       readonly
                                       disabled>
                                <small class="text-muted">Calculado automaticamente</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tipo">Tipo de Custo</label>
                                <select class="form-control @error('tipo') is-invalid @enderror" 
                                        id="tipo" 
                                        name="tipo">
                                    <option value="material" {{ old('tipo', 'material') == 'material' ? 'selected' : '' }}>Material</option>
                                    <option value="mao_obra" {{ old('tipo') == 'mao_obra' ? 'selected' : '' }}>Mão de Obra</option>
                                    <option value="equipamento" {{ old('tipo') == 'equipamento' ? 'selected' : '' }}>Equipamento</option>
                                </select>
                                @error('tipo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="mao_obra_percentual">% Mão de Obra (para materiais)</label>
                                <div class="input-group">
                                    <input type="number" 
                                           class="form-control @error('mao_obra_percentual') is-invalid @enderror" 
                                           id="mao_obra_percentual" 
                                           name="mao_obra_percentual" 
                                           value="{{ old('mao_obra_percentual', 50) }}" 
                                           min="0"
                                           max="100"
                                           step="1">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <small class="text-muted">Percentual para mão de obra</small>
                                @error('mao_obra_percentual')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Adicionar à Composição
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo mr-1"></i> Limpar
                    </button>
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
                <div class="callout callout-info">
                    <h5><i class="fas fa-database"></i> Base de Preços</h5>
                    <p>Os materiais são buscados automaticamente da Base de Preços.</p>
                </div>
                
                <div class="callout callout-warning">
                    <h5><i class="fas fa-calculator"></i> Cálculo Automático</h5>
                    <p><strong>Custo Total = Quantidade × Custo Unitário</strong></p>
                    <p>O custo unitário vem da Base de Preços, mas pode ser alterado manualmente.</p>
                </div>
                
                <div class="callout callout-success">
                    <h5><i class="fas fa-chart-line"></i> Mão de Obra</h5>
                    <p>Para materiais, pode-se definir um percentual de mão de obra que será calculado separadamente.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script>
$(document).ready(function() {
    // Inicializar Select2 para melhor busca de materiais
    $('.select2').select2({
        placeholder: 'Digite para buscar um material...',
        allowClear: true,
        width: '100%'
    });

    // Quando mudar o material, preencher unidade automaticamente
    $('#material_id').change(function() {
        var selected = $(this).find('option:selected');
        var unidade = selected.data('unidade');
        var preco = selected.data('preco');
        
        $('#unidade').val(unidade);
        
        // Se o campo custo_unitario estiver vazio, preencher com o preço da base
        if (!$('#custo_unitario').val()) {
            $('#custo_unitario').val(preco);
        }
        
        calcularTotal();
    });

    // Calcular total quando quantidade ou custo unitário mudar
    $('#quantidade, #custo_unitario').on('input', function() {
        calcularTotal();
    });

    function calcularTotal() {
        var quantidade = parseFloat($('#quantidade').val()) || 0;
        var custoUnit = parseFloat($('#custo_unitario').val()) || 0;
        var total = quantidade * custoUnit;
        
        $('#custo_total').val(total.toFixed(2).replace('.', ','));
    }

    // Mostrar/esconder campo de percentual conforme tipo
    $('#tipo').change(function() {
        if ($(this).val() === 'material') {
            $('#mao_obra_percentual').closest('.form-group').show();
        } else {
            $('#mao_obra_percentual').closest('.form-group').hide();
        }
    }).trigger('change');
});
</script>
@stop