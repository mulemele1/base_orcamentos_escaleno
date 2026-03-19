@extends('adminlte::page')

@section('title', 'Editar Composição')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-edit mr-2"></i>Editar Composição</h1>
    <a href="{{ route('composicoes.index', ['subatividade_id' => $composicao->subatividade_id]) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Voltar
    </a>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="card-title">
                    <i class="fas fa-edit mr-1"></i> Editar Material na Composição
                </h3>
            </div>
            <form action="{{ route('composicoes.update', $composicao->id) }}" method="POST" id="composicaoForm">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subatividade_id">Subatividade</label>
                                <select class="form-control" id="subatividade_id" disabled>
                                    <option value="{{ $composicao->subatividade_id }}" selected>
                                        [{{ $composicao->subatividade->atividade->categoriaObra->codigo }}.
                                        {{ $composicao->subatividade->atividade->codigo }}.
                                        {{ $composicao->subatividade->codigo }}]
                                        {{ $composicao->subatividade->nome }}
                                    </option>
                                </select>
                                <input type="hidden" name="subatividade_id" value="{{ $composicao->subatividade_id }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="material_id">Material</label>
                                <select class="form-control" id="material_id" disabled>
                                    <option value="{{ $composicao->material_id }}" selected>
                                        [{{ $composicao->material->codigo }}] {{ $composicao->material->nome }}
                                    </option>
                                </select>
                                <input type="hidden" name="material_id" value="{{ $composicao->material_id }}">
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
                                       value="{{ old('quantidade', $composicao->quantidade) }}" 
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
                                       value="{{ old('unidade', $composicao->unidade) }}" 
                                       readonly>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="custo_unitario">Custo Unitário (MT)</label>
                                <input type="number" 
                                       class="form-control @error('custo_unitario') is-invalid @enderror" 
                                       id="custo_unitario" 
                                       name="custo_unitario" 
                                       value="{{ old('custo_unitario', $composicao->custo_unitario) }}" 
                                       min="0"
                                       step="0.01">
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
                                       value="{{ number_format($composicao->custo_total, 2, ',', '.') }}" 
                                       readonly
                                       disabled>
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
                                    <option value="material" {{ old('tipo', $composicao->tipo) == 'material' ? 'selected' : '' }}>Material</option>
                                    <option value="mao_obra" {{ old('tipo', $composicao->tipo) == 'mao_obra' ? 'selected' : '' }}>Mão de Obra</option>
                                    <option value="equipamento" {{ old('tipo', $composicao->tipo) == 'equipamento' ? 'selected' : '' }}>Equipamento</option>
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
                                           value="{{ old('mao_obra_percentual', $composicao->mao_obra_percentual) }}" 
                                           min="0"
                                           max="100"
                                           step="1">
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                @error('mao_obra_percentual')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save mr-1"></i> Atualizar
                    </button>
                    <a href="{{ route('composicoes.index', ['subatividade_id' => $composicao->subatividade_id]) }}" 
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
                    <i class="fas fa-info-circle mr-1"></i> Subatividade
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <th>Código:</th>
                        <td>{{ $composicao->subatividade->codigo }}</td>
                    </tr>
                    <tr>
                        <th>Nome:</th>
                        <td>{{ $composicao->subatividade->nome }}</td>
                    </tr>
                    <tr>
                        <th>Quant. Proposta:</th>
                        <td>{{ number_format($composicao->subatividade->quantidade_proposta, 2, ',', '.') }} {{ $composicao->subatividade->unidade }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
$(document).ready(function() {
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

    // Calcular total inicial
    calcularTotal();
});
</script>
@stop