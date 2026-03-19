@extends('adminlte::page')

@section('title', 'Editar Subatividade')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-edit mr-2"></i>Editar Subatividade</h1>
    <a href="{{ route('subatividades.index', ['atividade_id' => $subatividade->atividade_id]) }}" class="btn btn-secondary">
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
            <form action="{{ route('subatividades.update', $subatividade->id) }}" method="POST" id="subatividadeForm">
                @csrf
                @method('PUT')
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
                                            {{ old('atividade_id', $subatividade->atividade_id) == $atividade->id ? 'selected' : '' }}>
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
                                       value="{{ old('codigo', $subatividade->codigo) }}" 
                                       placeholder="Ex: 1.1, 1.2"
                                       required>
                                <small class="text-muted">Ex: 1.1, 2.3</small>
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
                                       value="{{ old('nome', $subatividade->nome) }}" 
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
                                    <option value="m³" {{ old('unidade', $subatividade->unidade) == 'm³' ? 'selected' : '' }}>m³</option>
                                    <option value="m²" {{ old('unidade', $subatividade->unidade) == 'm²' ? 'selected' : '' }}>m²</option>
                                    <option value="m" {{ old('unidade', $subatividade->unidade) == 'm' ? 'selected' : '' }}>m (metro linear)</option>
                                    <option value="Un" {{ old('unidade', $subatividade->unidade) == 'Un' ? 'selected' : '' }}>Un (unidade)</option>
                                    <option value="Vg" {{ old('unidade', $subatividade->unidade) == 'Vg' ? 'selected' : '' }}>Vg (verba global)</option>
                                    <option value="kg" {{ old('unidade', $subatividade->unidade) == 'kg' ? 'selected' : '' }}>kg</option>
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
                                       value="{{ old('npi', $subatividade->npi) }}" 
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
                                       value="{{ old('perda_percentual', $subatividade->perda_percentual) }}" 
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
                                       value="{{ old('ordem', $subatividade->ordem) }}" 
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
                                               value="{{ old('comprimento', $subatividade->comprimento) }}" 
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
                                               value="{{ old('largura', $subatividade->largura) }}" 
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
                                               value="{{ old('altura', $subatividade->altura) }}" 
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
                                            <span class="info-box-number" id="resultado_elementar">{{ number_format($subatividade->elementar, 2, ',', '.') }}</span>
                                            <small>C × L × H</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-warning"><i class="fas fa-calculator"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Parcial</span>
                                            <span class="info-box-number" id="resultado_parcial">{{ number_format($subatividade->parcial, 2, ',', '.') }}</span>
                                            <small>NPI × Elementar</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-light">
                                        <span class="info-box-icon bg-success"><i class="fas fa-chart-line"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Quantidade Proposta</span>
                                            <span class="info-box-number" id="resultado_quantidade">{{ number_format($subatividade->quantidade_proposta, 2, ',', '.') }}</span>
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
                                  rows="3">{{ old('descricao', $subatividade->descricao) }}</textarea>
                        @error('descricao')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Atualizar Subatividade
                    </button>
                    <a href="{{ route('subatividades.index', ['atividade_id' => $subatividade->atividade_id]) }}" 
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
                    <i class="fas fa-info-circle mr-1"></i> Informações
                </h3>
            </div>
            <div class="card-body">
                <dl>
                    <dt><i class="fas fa-calendar-alt mr-1"></i> Criado em:</dt>
                    <dd>{{ $subatividade->created_at ? $subatividade->created_at->format('d/m/Y H:i') : '-' }}</dd>
                    
                    <dt><i class="fas fa-history mr-1"></i> Última atualização:</dt>
                    <dd>{{ $subatividade->updated_at ? $subatividade->updated_at->format('d/m/Y H:i') : '-' }}</dd>
                </dl>
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