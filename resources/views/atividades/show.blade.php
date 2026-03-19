@extends('adminlte::page')

@section('title', 'Detalhes da Atividade')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-info-circle mr-2"></i>Detalhes da Atividade</h1>
    <div>
        <a href="{{ route('atividades.edit', $atividade->id) }}" class="btn btn-warning">
            <i class="fas fa-edit mr-1"></i> Editar
        </a>
        <a href="{{ route('atividades.index', ['categoria_id' => $atividade->categoria_obra_id]) }}" class="btn btn-secondary">
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
                    <i class="fas fa-info-circle mr-1"></i> Informações da Atividade
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="150">Código:</th>
                        <td><span class="badge bg-primary">{{ $atividade->codigo }}</span></td>
                    </tr>
                    <tr>
                        <th>Nome:</th>
                        <td>{{ $atividade->nome }}</td>
                    </tr>
                    <tr>
                        <th>Categoria:</th>
                        <td>
                            <span class="badge bg-info">
                                {{ $atividade->categoriaObra->codigo }} - {{ $atividade->categoriaObra->nome }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Unidade:</th>
                        <td>{{ $atividade->unidade }}</td>
                    </tr>
                    <tr>
                        <th>NPI:</th>
                        <td>{{ $atividade->npi }}</td>
                    </tr>
                    <tr>
                        <th>Ordem:</th>
                        <td>{{ $atividade->ordem ?? 'Não definida' }}</td>
                    </tr>
                    <tr>
                        <th>Criado em:</th>
                        <td>{{ $atividade->created_at ? $atividade->created_at->format('d/m/Y H:i:s') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Atualizado em:</th>
                        <td>{{ $atividade->updated_at ? $atividade->updated_at->format('d/m/Y H:i:s') : '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h3 class="card-title">
                    <i class="fas fa-list mr-1"></i> Subatividades
                </h3>
                <div class="card-tools">
                    <a href="{{ route('subatividades.create', ['atividade_id' => $atividade->id]) }}" 
                       class="btn btn-sm btn-light">
                        <i class="fas fa-plus"></i> Nova Subatividade
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Unidade</th>
                            <th>Quant.</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($atividade->subatividades as $sub)
                        <tr>
                            <td>{{ $sub->codigo }}</td>
                            <td>{{ $sub->nome }}</td>
                            <td>{{ $sub->unidade }}</td>
                            <td class="text-right">{{ number_format($sub->quantidade_proposta, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('subatividades.show', $sub->id) }}" class="btn btn-xs btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                <i class="fas fa-info-circle mr-1"></i>
                                Nenhuma subatividade cadastrada.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h3 class="card-title">
                    <i class="fas fa-calculator mr-1"></i> Resumo de Custos
                </h3>
            </div>
            <div class="card-body">
                @php
                    $totalGeral = 0;
                @endphp
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="bg-light">
                                <th>Subatividade</th>
                                <th class="text-right">Quantidade</th>
                                <th class="text-right">Total Materiais</th>
                                <th class="text-right">Total Mão Obra</th>
                                <th class="text-right">Preço Unitário</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($atividade->subatividades as $sub)
                            @php
                                $totalGeral += $sub->total;
                            @endphp
                            <tr>
                                <td>{{ $sub->codigo }} - {{ $sub->nome }}</td>
                                <td class="text-right">{{ number_format($sub->quantidade_proposta, 2, ',', '.') }} {{ $sub->unidade }}</td>
                                <td class="text-right">MT {{ number_format($sub->total_materiais, 2, ',', '.') }}</td>
                                <td class="text-right">MT {{ number_format($sub->total_mao_obra, 2, ',', '.') }}</td>
                                <td class="text-right">MT {{ number_format($sub->preco_unitario, 2, ',', '.') }}</td>
                                <td class="text-right"><strong>MT {{ number_format($sub->total, 2, ',', '.') }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-success text-white">
                                <th colspan="5" class="text-right">TOTAL DA ATIVIDADE:</th>
                                <th class="text-right">MT {{ number_format($totalGeral, 2, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop