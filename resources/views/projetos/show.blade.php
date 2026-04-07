{{-- resources/views/projetos/show.blade.php --}}
@extends('adminlte::page')

@section('title', $projeto->nome)

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-building text-primary mr-2"></i>
        {{ $projeto->nome }}
    </h1>
    <div>
        <a href="{{ route('projetos.edit', $projeto->id) }}" class="btn btn-primary">
            <i class="fas fa-edit"></i> Editar
        </a>
        <a href="{{ route('projetos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>
@stop

@section('content')
{{-- Cards de resumo --}}
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $componentesMedidos }}/{{ $totalComponentes }}</h3>
                <p>Componentes Medidos</p>
            </div>
            <div class="icon">
                <i class="fas fa-ruler-combined"></i>
            </div>
            <div class="small-box-footer">
                <div class="progress" style="height: 3px;">
                    <div class="progress-bar" style="width: {{ $progresso }}%"></div>
                </div>
                <small>{{ $progresso }}% completo</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $projeto->medicoes()->count() }}</h3>
                <p>Medições Realizadas</p>
            </div>
            <div class="icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $projeto->orcamentos()->count() }}</h3>
                <p>Orçamentos Gerados</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $projeto->status_formatado }}</h3>
                <p>Status do Projeto</p>
            </div>
            <div class="icon">
                <i class="fas fa-flag-checkered"></i>
            </div>
        </div>
    </div>
</div>

{{-- Informações do projeto --}}
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Informações do Projeto
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 150px;">Nome</th>
                        <td><strong>{{ $projeto->nome }}</strong></td>
                    </tr>
                    <tr>
                        <th>Cliente</th>
                        <td>{{ $projeto->cliente ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Localização</th>
                        <td>{{ $projeto->localizacao ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>Data de Início</th>
                        <td>{{ $projeto->data_inicio ? $projeto->data_inicio->format('d/m/Y') : '—' }}</td>
                    </tr>
                    <tr>
                        <th>Data de Fim</th>
                        <td>{{ $projeto->data_fim ? $projeto->data_fim->format('d/m/Y') : '—' }}</td>
                    </tr>
                    <tr>
                        <th>Descrição</th>
                        <td>{{ $projeto->descricao ?? '—' }}</td>
                    </tr>
                    <tr>
                        <th>IVA</th>
                        <td>{{ $projeto->iva }}%</td>
                    </tr>
                    <tr>
                        <th>Contingência</th>
                        <td>{{ $projeto->contingencia }}%</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i> Ações Rápidas
                </h3>
            </div>
            <div class="card-body">
                @if($projeto->status == 'rascunho' || $projeto->status == 'medicao')
                    <a href="{{ route('medicoes.dashboard', $projeto->id) }}" class="btn btn-success btn-block mb-2">
                        <i class="fas fa-ruler-combined"></i> Iniciar Medição
                    </a>
                @endif
                
                @if($projeto->status == 'medicao' && $componentesMedidos == $totalComponentes && $totalComponentes > 0)
                    <form action="{{ route('medicoes.finalizar', $projeto->id) }}" method="POST" class="d-inline w-100">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning btn-block mb-2" onclick="return confirm('Finalizar medição?')">
                            <i class="fas fa-check-circle"></i> Finalizar Medição
                        </button>
                    </form>
                @endif
                
                @if($projeto->status == 'orcamento' && $projeto->orcamentos->isEmpty())
                    <a href="{{ route('orcamentos.gerar', $projeto->id) }}" class="btn btn-info btn-block mb-2">
                        <i class="fas fa-chart-line"></i> Gerar Orçamento
                    </a>
                @endif
                
                @if($projeto->orcamentos->isNotEmpty())
                    @php
                        $ultimoOrcamento = $projeto->orcamentos()->latest()->first();
                    @endphp
                    <a href="{{ route('orcamentos.show', [$projeto->id, $ultimoOrcamento->id]) }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-eye"></i> Ver Último Orçamento
                    </a>
                @endif
                
                <form action="{{ route('projetos.nova-versao', $projeto->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-block">
                        <i class="fas fa-copy"></i> Duplicar Projeto
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Lista de medições --}}
@if($medicoes->isNotEmpty())
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-clipboard-list"></i> Medições Realizadas
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Componente</th>
                                <th>Dimensões</th>
                                <th>NPI</th>
                                <th>Quantidade</th>
                                <th>Unidade</th>
                                <th>Origem</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($medicoes as $medicao)
                            <tr>
                                <td>
                                    <strong>{{ $medicao->componente->nome ?? '—' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $medicao->componente->formula_calculo ?? '—' }}</small>
                                </td>
                                <td>
                                    @if($medicao->comprimento) {{ $medicao->comprimento }}m @endif
                                    @if($medicao->largura) × {{ $medicao->largura }}m @endif
                                    @if($medicao->altura) × {{ $medicao->altura }}m @endif
                                    @if(!$medicao->comprimento && !$medicao->largura && !$medicao->altura)
                                        —
                                    @endif
                                </td>
                                <td>{{ $medicao->npi }}</td>
                                <td class="text-right">
                                    <strong>{{ number_format($medicao->quantidade, 2) }}</strong>
                                </td>
                                <td>{{ $medicao->componente->unidade ?? '—' }}</td>
                                <td>
                                    @if($medicao->origem == 'desenho')
                                        <span class="badge badge-info">
                                            <i class="fas fa-drafting-compass"></i> Desenho
                                        </span>
                                    @else
                                        <span class="badge badge-success">
                                            <i class="fas fa-hard-hat"></i> Campo
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('medicoes.edit', [$projeto->id, $medicao->id]) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('medicoes.destroy', [$projeto->id, $medicao->id]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Remover medição?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body text-center py-4">
                <i class="fas fa-clipboard-list fa-3x mb-3 text-muted"></i>
                <p>Nenhuma medição realizada ainda.</p>
@if($projeto->status == 'rascunho' || $projeto->status == 'medicao')
    <a href="{{ route('medicoes.dashboard', ['projeto' => $projeto->id]) }}" class="btn btn-success btn-block mb-2">
        <i class="fas fa-ruler-combined"></i> Iniciar Medição
    </a>
@endif
            </div>
        </div>
    </div>
</div>
@endif

{{-- Lista de orçamentos --}}
@if($projeto->orcamentos->isNotEmpty())
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-line"></i> Orçamentos Gerados
                </h3>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Data</th>
                                <th>Subtotal</th>
                                <th>IVA</th>
                                <th>Total</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projeto->orcamentos as $orcamento)
                            <tr>
                                <td>{{ $orcamento->nome }}</td>
                                <td>{{ $orcamento->data_orcamento->format('d/m/Y') }}</td>
                                <td class="text-right">MT {{ number_format($orcamento->subtotal, 2, ',', '.') }}</td>
                                <td class="text-right">MT {{ number_format($orcamento->iva, 2, ',', '.') }}</td>
                                <td class="text-right">
                                    <strong>MT {{ number_format($orcamento->total_geral, 2, ',', '.') }}</strong>
                                </td>
                                <td>
                                    <a href="{{ route('orcamentos.show', [$projeto->id, $orcamento->id]) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('orcamentos.pdf', [$projeto->id, $orcamento->id]) }}" class="btn btn-sm btn-danger">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@stop