@extends('adminlte::page')

@section('title', 'Gerar Orçamento - ' . $projeto->nome)

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-chart-line text-success mr-2"></i>
        Gerar Orçamento: {{ $projeto->nome }}
    </h1>
    <div>
        <a href="{{ route('medicoes.dashboard', $projeto) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calculator"></i> Associação de Materiais às Medições
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('orcamentos.salvar', $projeto) }}" method="POST" id="form-orcamento">
                    @csrf
                    
                    <div class="form-group">
                        <label for="nome">Nome do Orçamento <span class="text-danger">*</span></label>
                        <input type="text" name="nome" id="nome" class="form-control" 
                               value="Orçamento {{ $projeto->nome }} - {{ now()->format('d/m/Y') }}" required>
                    </div>
                    
                    <hr>
                    
                    <h4><i class="fas fa-list-ul"></i> Medições Realizadas</h4>
                    
                    @foreach($medicoesPorCategoria as $categoria => $medicoesCat)
                        <div class="card mt-3">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-folder-open"></i> {{ $categoria }}
                                </h5>
                                <span class="float-right badge badge-info">{{ count($medicoesCat) }} itens</span>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th>Componente</th>
                                                <th>Dimensões</th>
                                                <th>Quantidade</th>
                                                <th>Unidade</th>
                                                <th>Material</th>
                                                <th>Preço Unitário</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($medicoesCat as $medicao)
                                                @php
                                                    $componente = $medicao->componente;
                                                    $formulaText = '';
                                                    if($medicao->comprimento) $formulaText .= $medicao->comprimento . 'm ';
                                                    if($medicao->largura) $formulaText .= '× ' . $medicao->largura . 'm ';
                                                    if($medicao->altura) $formulaText .= '× ' . $medicao->altura . 'm';
                                                    if(!$formulaText) $formulaText = $medicao->altura . ' ' . $componente->unidade;
                                                @endphp
                                                <tr class="item-orcamento" data-medicao-id="{{ $medicao->id }}" data-quantidade="{{ $medicao->quantidade }}">
                                                    <td>
                                                        <strong>{{ $componente->nome }}</strong>
                                                        <br><small class="text-muted">{{ $componente->formula_calculo }}</small>
                                                    </td>
                                                    <td>
                                                        <small>{{ $medicao->npi }} × {{ $formulaText }}</small>
                                                        @if($medicao->perda > 0)
                                                            <br><small class="text-warning">+{{ $medicao->perda }}% perda</small>
                                                        @endif
                                                    </td>
                                                    <td class="text-right">
                                                        <strong>{{ number_format($medicao->quantidade, 2) }}</strong>
                                                        <input type="hidden" name="itens[{{ $loop->index }}][medicao_id]" value="{{ $medicao->id }}">
                                                    </td>
                                                    <td>{{ $componente->unidade }}</td>
                                                    <td>
                                                        <select name="itens[{{ $loop->index }}][preco_material_id]" 
                                                                class="form-control select-material" 
                                                                data-index="{{ $loop->index }}"
                                                                data-quantidade="{{ $medicao->quantidade }}"
                                                                required>
                                                            <option value="">Selecione...</option>
                                                            @foreach($precosMateriais as $material)
                                                                <option value="{{ $material->id }}" 
                                                                        data-preco="{{ $material->valor_atual }}"
                                                                        data-unidade="{{ $material->unidade }}">
                                                                    {{ $material->codigo }} - {{ $material->nome }} 
                                                                    ({{ number_format($material->valor_atual, 2) }} MT/{{ $material->unidade }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" 
                                                               name="itens[{{ $loop->index }}][preco_unitario]" 
                                                               class="form-control preco-unitario"
                                                               data-index="{{ $loop->index }}"
                                                               step="0.01"
                                                               readonly
                                                               required>
                                                    </td>
                                                    <td class="subtotal-cell text-right" data-index="{{ $loop->index }}">
                                                        <span class="badge badge-secondary">0,00 MT</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="iva">IVA (%)</label>
                                <input type="number" name="iva" id="iva" class="form-control" step="0.01" value="{{ $iva }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contingencia">Contingência (%)</label>
                                <input type="number" name="contingencia" id="contingencia" class="form-control" step="0.01" value="{{ $contingencia }}" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-success" id="resumo-orcamento">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Subtotal:</strong><br>
                                <span id="subtotal" class="h4">0,00 MT</span>
                            </div>
                            <div class="col-md-3">
                                <strong>IVA:</strong><br>
                                <span id="valor-iva" class="h4">0,00 MT</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Subtotal B:</strong><br>
                                <span id="subtotal-b" class="h4">0,00 MT</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Contingências:</strong><br>
                                <span id="valor-contingencias" class="h4">0,00 MT</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12 text-right">
                                <strong class="h3 text-success">TOTAL FINAL: <span id="total-geral">0,00 MT</span></strong>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Salvar Orçamento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectMateriais = document.querySelectorAll('.select-material');
        const precoUnitarioInputs = document.querySelectorAll('.preco-unitario');
        const ivaInput = document.getElementById('iva');
        const contingenciaInput = document.getElementById('contingencia');
        
        function atualizarCalculo() {
            let subtotal = 0;
            
            selectMateriais.forEach((select, index) => {
                const selectedOption = select.options[select.selectedIndex];
                const preco = parseFloat(selectedOption?.dataset?.preco) || 0;
                const quantidade = parseFloat(select.dataset.quantidade) || 0;
                const total = preco * quantidade;
                
                // Atualizar input de preço unitário
                const precoInput = document.querySelector(`.preco-unitario[data-index="${index}"]`);
                if (precoInput) {
                    precoInput.value = preco.toFixed(2);
                }
                
                // Atualizar subtotal na célula
                const subtotalCell = document.querySelector(`.subtotal-cell[data-index="${index}"] span`);
                if (subtotalCell) {
                    subtotalCell.innerHTML = total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' MT';
                    if (total > 0) {
                        subtotalCell.classList.remove('badge-secondary');
                        subtotalCell.classList.add('badge-success');
                    } else {
                        subtotalCell.classList.remove('badge-success');
                        subtotalCell.classList.add('badge-secondary');
                    }
                }
                
                subtotal += total;
            });
            
            const ivaPercent = parseFloat(ivaInput.value) || 0;
            const contingenciaPercent = parseFloat(contingenciaInput.value) || 0;
            
            const valorIva = subtotal * (ivaPercent / 100);
            const subtotalB = subtotal + valorIva;
            const valorContingencias = subtotalB * (contingenciaPercent / 100);
            const totalGeral = subtotalB + valorContingencias;
            
            document.getElementById('subtotal').innerHTML = subtotal.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' MT';
            document.getElementById('valor-iva').innerHTML = valorIva.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' MT';
            document.getElementById('subtotal-b').innerHTML = subtotalB.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' MT';
            document.getElementById('valor-contingencias').innerHTML = valorContingencias.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' MT';
            document.getElementById('total-geral').innerHTML = totalGeral.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' MT';
        }
        
        selectMateriais.forEach(select => {
            select.addEventListener('change', atualizarCalculo);
        });
        
        ivaInput.addEventListener('input', atualizarCalculo);
        contingenciaInput.addEventListener('input', atualizarCalculo);
        
        // Calcular inicialmente
        atualizarCalculo();
    });
</script>
@endsection