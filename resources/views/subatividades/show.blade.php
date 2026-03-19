@extends('adminlte::page')

@section('title', 'Detalhes da Subatividade')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-info-circle mr-2"></i>Detalhes da Subatividade</h1>
    <div>
        <a href="{{ route('subatividades.edit', $subatividade->id) }}" class="btn btn-warning">
            <i class="fas fa-edit mr-1"></i> Editar
        </a>
        <a href="{{ route('subatividades.index', ['atividade_id' => $subatividade->atividade_id]) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Voltar
        </a>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-1"></i> Informações Gerais
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="150">Código:</th>
                        <td><span class="badge bg-primary">{{ $subatividade->codigo }}</span></td>
                    </tr>
                    <tr>
                        <th>Nome:</th>
                        <td>{{ $subatividade->nome }}</td>
                    </tr>
                    <tr>
                        <th>Atividade:</th>
                        <td>
                            <a href="{{ route('atividades.show', $subatividade->atividade_id) }}">
                                {{ $subatividade->atividade->categoriaObra->codigo }}.{{ $subatividade->atividade->codigo }} - {{ $subatividade->atividade->nome }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Unidade:</th>
                        <td>{{ $subatividade->unidade }}</td>
                    </tr>
                    <tr>
                        <th>NPI:</th>
                        <td>{{ $subatividade->npi }}</td>
                    </tr>
                    <tr>
                        <th>Perda (%):</th>
                        <td>{{ $subatividade->perda_percentual }}%</td>
                    </tr>
                    <tr>
                        <th>Ordem:</th>
                        <td>{{ $subatividade->ordem ?? 'Não definida' }}</td>
                    </tr>
                    <tr>
                        <th>Descrição:</th>
                        <td>{{ $subatividade->descricao ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Criado em:</th>
                        <td>{{ $subatividade->created_at ? $subatividade->created_at->format('d/m/Y H:i:s') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Atualizado em:</th>
                        <td>{{ $subatividade->updated_at ? $subatividade->updated_at->format('d/m/Y H:i:s') : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="card-title">
                    <i class="fas fa-calculator mr-1"></i> Cálculos
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-info"><i class="fas fa-ruler"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Dimensões</span>
                                <span class="info-box-number">
                                    @if($subatividade->comprimento)
                                        {{ $subatividade->comprimento }} x {{ $subatividade->largura ?? '-' }} x {{ $subatividade->altura ?? '-' }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-info"><i class="fas fa-cube"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Elementar</span>
                                <span class="info-box-number">{{ number_format($subatividade->elementar, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-warning"><i class="fas fa-calculator"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Parcial</span>
                                <span class="info-box-number">{{ number_format($subatividade->parcial, 2, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box bg-light">
                            <span class="info-box-icon bg-warning"><i class="fas fa-chart-line"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Quant. Proposta</span>
                                <span class="info-box-number">{{ number_format($subatividade->quantidade_proposta, 2, ',', '.') }} {{ $subatividade->unidade }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-purple text-white">
                <h3 class="card-title">
                    <i class="fas fa-coins mr-1"></i> Custos
                </h3>
                <div class="card-tools">
                    <a href="{{ route('composicoes.create', ['subatividade_id' => $subatividade->id]) }}" 
                       class="btn btn-sm btn-light">
                        <i class="fas fa-plus"></i> Adicionar Material
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Quant.</th>
                            <th>Unidade</th>
                            <th>Custo Unit.</th>
                            <th>Custo Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subatividade->composicaoCustos as $comp)
                        <tr>
                            <td>{{ $comp->material->nome ?? 'N/A' }}</td>
                            <td class="text-right">{{ number_format($comp->quantidade, 2, ',', '.') }}</td>
                            <td>{{ $comp->unidade }}</td>
                            <td class="text-right">MT {{ number_format($comp->custo_unitario, 2, ',', '.') }}</td>
                            <td class="text-right">MT {{ number_format($comp->custo_total, 2, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                <i class="fas fa-info-circle mr-1"></i>
                                Nenhum material vinculado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-success text-white">
                            <th colspan="4" class="text-right">TOTAL MATERIAIS:</th>
                            <th class="text-right">MT {{ number_format($subatividade->total_materiais, 2, ',', '.') }}</th>
                        </tr>
                        <tr class="bg-info text-white">
                            <th colspan="4" class="text-right">TOTAL MÃO DE OBRA:</th>
                            <th class="text-right">MT {{ number_format($subatividade->total_mao_obra, 2, ',', '.') }}</th>
                        </tr>
                        <tr class="bg-primary text-white">
                            <th colspan="4" class="text-right">PREÇO UNITÁRIO:</th>
                            <th class="text-right">MT {{ number_format($subatividade->preco_unitario, 2, ',', '.') }}</th>
                        </tr>
                        <tr class="bg-warning text-white">
                            <th colspan="4" class="text-right">TOTAL GERAL:</th>
                            <th class="text-right">MT {{ number_format($subatividade->total, 2, ',', '.') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@stop