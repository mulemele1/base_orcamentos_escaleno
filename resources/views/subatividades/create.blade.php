@extends('adminlte::page')

@section('title', 'Nova Subatividade')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-plus-circle mr-2"></i>Nova Subatividade</h1>
    <a href="{{ route('subatividades.index', ['atividade_id' => $atividadeId]) }}" class="btn btn-secondary">
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
                    <i class="fas fa-calculator mr-1"></i> Informações e Cálculos
                </h3>
            </div>
            <form action="{{ route('subatividades.store') }}" method="POST" id="subatividadeForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="atividade_id">Atividade <span class="text-danger">*</span></label>
                                <select class="form-control @error('atividade_id') is-invalid @enderror" 
                                        id="atividade_id" 
                                        name="atividade_id" 
                                        required>
                                    <option value="">Selecione...</option>
                                    @foreach($atividades as $atividade)
                                        <option value="{{ $atividade->id }}" 
                                            {{ old('atividade_id', $atividadeId) == $atividade->id ? 'selected' : '' }}>
                                            {{ $atividade->categoriaObra->codigo }}.{{ $atividade->codigo }} - {{ $atividade->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('atividade_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="codigo">Código <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('codigo') is-invalid @enderror" 
                                       id="codigo" 
                                       name="codigo" 
                                       value="{{ old('codigo') }}" 
                                       placeholder="Ex: 1.1, 1.2"
                                       required>
                                <small class="text-muted">Ex: 1.1, 2.3, 5.2</small>
                                @error('codigo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nome">Nome <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nome') is-invalid @enderror" 
                                       id="nome" 
                                       name="nome" 
                                       value="{{ old('nome') }}" 
                                       placeholder="Descrição da subatividade"
                                       required>
                                @error('nome')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="unidade">Unidade <span class="text-danger">*</span></label>
                                <select class="form-control @error('unidade') is-invalid @enderror" 
                                        id="unidade" 
                                        name="unidade" 
                                        required>
                                    <option value="">Selecione</option>
                                    <option value="m³" {{ old('unidade') == 'm³' ? 'selected' : '' }}>m³</option>
                                    <option value="m²" {{ old('unidade') == 'm²' ? 'selected' : '' }}>m²</option>
                                    <option value="m" {{ old('unidade') == 'm' ? 'selected' : '' }}>m (metro linear)</option>
                                    <option value="Un" {{ old('unidade') == 'Un' ? 'selected' : '' }}>Un (unidade)</option>
                                    <option value="Vg" {{ old('unidade') == 'Vg' ? 'selected' : '' }}>Vg (verba global)</option>
                                    <option value="kg" {{ old('unidade') == 'kg' ? 'selected' : '' }}>kg</option>
                                </select>
                                @error('unidade')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="npi">NPI</label>
                                <input type="number" 
                                       class="form-control @error('npi') is-invalid @enderror" 
                                       id="npi" 
                                       name="npi" 
                                       value="{{ old('npi', 1) }}" 
                                       min="1"
                                       step="1">
                                @error('npi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="perda_percentual">Perda (%)</label>
                                <input type="number" 
                                       class="form-control @error('perda_percentual') is-invalid @enderror" 
                                       id="perda_percentual" 
                                       name="perda_percentual" 
                                       value="{{ old('perda_percentual', 0) }}" 
                                       min="0" 
                                       max="100"
                                       step="0.1">
                                @error('perda_percentual')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ordem">Ordem</label>
                                <input type="number" 
                                       class="form-control @error('ordem') is-invalid @enderror" 
                                       id="ordem" 
                                       name="ordem" 
                                       value="{{ old('ordem') }}" 
                                       min="0">
                                @error('ordem')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
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
                                               class="form-control @error('comprimento') is-invalid @enderror" 
                                               id="comprimento" 
                                               name="comprimento" 
                                               value="{{ old('comprimento') }}" 
                                               min="0"
                                               step="0.01">
                                        @error('comprimento')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="largura">Largura (L)</label>
                                        <input type="number" 
                                               class="form-control @error('largura') is-invalid @enderror" 
                                               id="largura" 
                                               name="largura" 
                                               value="{{ old('largura') }}" 
                                               min="0"
                                               step="0.01">
                                        @error('largura')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="altura">Altura (H)</label>
                                        <input type="number" 
                                               class="form-control @error('altura') is-invalid @enderror" 
                                               id="altura" 
                                               name="altura" 
                                               value="{{ old('altura') }}" 
                                               min="0"
                                               step="0.01">
                                        @error('altura')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
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
                                            <span class="info-box-number" id="resultado_elementar">0,00</span>
                                            <small>C × L × H</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-warning"><i class="fas fa-calculator"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Parcial</span>
                                            <span class="info-box-number" id="resultado_parcial">0,00</span>
                                            <small>NPI × Elementar</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-success"><i class="fas fa-chart-line"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Quantidade Proposta</span>
                                            <span class="info-box-number" id="resultado_quantidade">0,00</span>
                                            <small>Parcial × (1 + Perda/100)</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição Detalhada</label>
                        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                  id="descricao" 
                                  name="descricao" 
                                  rows="3">{{ old('descricao') }}</textarea>
                        @error('descricao')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Salvar Subatividade
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
                    <i class="fas fa-info-circle mr-1"></i> Como calcular
                </h3>
            </div>
            <div class="card-body">
                <div class="callout callout-info">
                    <h5><i class="fas fa-ruler"></i> Elementar</h5>
                    <p class="text-muted">= C × L × H</p>
                    <p><small>Quando aplicável (m³, m², m)</small></p>
                </div>
                
                <div class="callout callout-warning">
                    <h5><i class="fas fa-calculator"></i> Parcial</h5>
                    <p class="text-muted">= NPI × Elementar</p>
                    <p><small>Quantidade total sem perdas</small></p>
                </div>
                
                <div class="callout callout-success">
                    <h5><i class="fas fa-chart-line"></i> Quantidade Proposta</h5>
                    <p class="text-muted">= Parcial × (1 + Perda/100)</p>
                    <p><small>Quantidade final com perdas</small></p>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-warning">
                <h3 class="card-title">
                    <i class="fas fa-lightbulb mr-1"></i> Dicas
                </h3>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>Código:</strong> Use formato decimal (1.1, 2.3)
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>Unidade:</strong> Escolha conforme o tipo de medição
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>Dimensões:</strong> Preencha apenas se aplicável
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>Clique em "Calcular"</strong> para ver os resultados
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
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
            url: '{{ route("subatividades.calcular") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
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
@stop  