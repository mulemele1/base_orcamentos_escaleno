@extends('adminlte::page')

@section('title', 'Editar Orçamento - ' . $orcamento->codigo)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-edit mr-2"></i>Editar Orçamento: {{ $orcamento->codigo }}</h1>
        <div>
            <a href="{{ route('orcamentos.show', $orcamento->id) }}" class="btn btn-info">
                <i class="fas fa-eye"></i> Visualizar
            </a>
            <a href="{{ route('projetos.show', $orcamento->projeto_id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar ao Projeto
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informações do Orçamento</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('orcamentos.update', $orcamento->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome_projeto">Nome do Projeto *</label>
                            <input type="text" name="nome_projeto" id="nome_projeto" 
                                   class="form-control" value="{{ old('nome_projeto', $orcamento->nome_projeto) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cliente">Cliente *</label>
                            <input type="text" name="cliente" id="cliente" 
                                   class="form-control" value="{{ old('cliente', $orcamento->cliente) }}" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="localizacao">Localização</label>
                            <input type="text" name="localizacao" id="localizacao" 
                                   class="form-control" value="{{ old('localizacao', $orcamento->localizacao) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="data_validade">Data de Validade</label>
                            <input type="date" name="data_validade" id="data_validade" 
                                   class="form-control" value="{{ old('data_validade', $orcamento->data_validade ? $orcamento->data_validade->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="observacoes">Observações</label>
                    <textarea name="observacoes" id="observacoes" class="form-control" rows="3">{{ old('observacoes', $orcamento->observacoes) }}</textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Atualizar Orçamento</button>
                    <a href="{{ route('orcamentos.show', $orcamento->id) }}" class="btn btn-default">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Atalho para gerenciar atividades -->
    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">
                <i class="fas fa-tasks"></i> Atividades do Orçamento
            </h3>
        </div>
        <div class="card-body text-center">
            <p>Gerencie as atividades que farão parte deste orçamento.</p>
            <a href="{{ route('orcamentos.atividades.index', $orcamento->id) }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Gerenciar Atividades
            </a>
            @if($orcamento->orcamentoAtividades->count() > 0)
                <span class="ml-2 badge badge-success">
                    {{ $orcamento->orcamentoAtividades->count() }} atividades adicionadas
                </span>
            @endif
        </div>
    </div>

    <!-- Resumo rápido -->
    <div class="card mt-3">
        <div class="card-header bg-success text-white">
            <h3 class="card-title">
                <i class="fas fa-chart-line"></i> Resumo Rápido
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>MT {{ number_format($orcamento->subtotal, 0, ',', '.') }}</h3>
                            <p>Subtotal</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>MT {{ number_format($orcamento->valor_iva, 0, ',', '.') }}</h3>
                            <p>IVA ({{ $orcamento->iva_percentual }}%)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>MT {{ number_format($orcamento->grand_total, 0, ',', '.') }}</h3>
                            <p>GRAND TOTAL</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <form action="{{ route('orcamentos.calcular', $orcamento->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-calculator"></i> Recalcular Orçamento
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop