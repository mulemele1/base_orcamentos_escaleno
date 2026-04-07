@extends('adminlte::page')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-ruler"></i> Medição - {{ $medicao->codigo }}</h1>
        <div>
            <span class="badge badge-info">Projeto: {{ $projeto->nome }}</span>
            <span class="badge badge-secondary">Versão: {{ $medicao->versao }}</span>
            <span class="badge badge-{{ $medicao->status == 'aprovado' ? 'success' : ($medicao->status == 'revisto' ? 'warning' : 'secondary') }}">
                {{ ucfirst($medicao->status) }}
            </span>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resumo da Medição</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Data de Criação:</strong> {{ $medicao->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Última Atualização:</strong> {{ $medicao->updated_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Total de Itens:</strong> {{ $medicao->itens->count() }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Observações:</strong> {{ $medicao->observacoes ?? 'Nenhuma observação' }}</p>
                            <p><strong>Quantidade Total:</strong> {{ number_format($medicao->total_medicao, 2, ',', '.') }} unidades</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Itens Medidos</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            48
                                <th>Categoria</th>
                                <th>Atividade</th>
                                <th>Subatividade</th>
                                <th>Código</th>
                                <th>Unidade</th>
                                <th class="text-right">Quantidade</th>
                                <th>Dimensões</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($medicao->itens as $item)
                                @php
                                    $subatividade = $item->subatividade;
                                    $atividade = $subatividade->atividade;
                                    $categoria = $atividade->categoria;
                                @endphp
                                <tr>
                                    <td>{{ $categoria->codigo }} - {{ $categoria->nome }}</td>
                                    <td>{{ $atividade->codigo }} - {{ $atividade->nome }}</td>
                                    <td>{{ $subatividade->codigo }} - {{ $subatividade->nome }}</td>
                                    <td>{{ $subatividade->codigo }}</td>
                                    <td>{{ $item->unidade }}</td>
                                    <td class="text-right">{{ number_format($item->quantidade_proposta, 2, ',', '.') }}</td>
                                    <td>
                                        @if($item->comprimento || $item->largura || $item->altura)
                                            <small>
                                                C: {{ $item->comprimento ?? '-' }} m |
                                                L: {{ $item->largura ?? '-' }} m |
                                                A: {{ $item->altura ?? '-' }} m
                                                @if($item->perda_percentual > 0)
                                                    <br>Perda: {{ $item->perda_percentual }}%
                                                @endif
                                            </small>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                                        <p>Nenhum item medido ainda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('projetos.show', $projeto->id) }}" class="btn btn-default">
                                <i class="fas fa-arrow-left"></i> Voltar ao Projeto
                            </a>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('medicoes.edit', $medicao->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Editar Medição
                            </a>
                            @if($medicao->itens->count() > 0 && !$projeto->tem_orcamento)
                                <form action="{{ route('orcamentos.criar-apartir-medicao', $projeto->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="medicao_id" value="{{ $medicao->id }}">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-chart-line"></i> Gerar Orçamento
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('medicoes.destroy', $medicao->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta medição?')">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop