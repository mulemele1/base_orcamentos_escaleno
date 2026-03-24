@extends('adminlte::page')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-tasks mr-2"></i>Gerenciar Atividades: {{ $orcamento->codigo }}</h1>
    <a href="{{ route('projetos.show', $orcamento->projeto_id) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Voltar ao Projeto
    </a>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus-circle"></i> Adicionar Atividade</h3>
            </div>
            <div class="card-body">
                @if($categorias->isEmpty())
                    <div class="alert alert-warning">
                        Nenhuma categoria cadastrada. <a href="{{ route('categorias-obra.create') }}">Crie uma categoria</a> primeiro.
                    </div>
                @else
                    <form action="{{ route('orcamentos.atividades.store', $orcamento->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="atividade_id">Selecione uma Atividade</label>
                            <select name="atividade_id" id="atividade_id" class="form-control" required>
                                <option value="">-- Escolha uma atividade --</option>
                                @foreach($categorias as $categoria)
                                    @if($categoria->atividades->count() > 0)
                                        <optgroup label="{{ $categoria->codigo }} - {{ $categoria->nome }}">
                                            @foreach($categoria->atividades as $atividade)
                                                <option value="{{ $atividade->id }}">
                                                    {{ $atividade->codigo }} - {{ $atividade->nome }} ({{ $atividade->unidade }})
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Adicionar ao Orçamento
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list-ul"></i> Atividades no Orçamento</h3>
            </div>
            <div class="card-body p-0">
                @if($atividadesNoOrcamento->isEmpty())
                    <div class="text-center p-4">
                        <i class="fas fa-info-circle fa-2x mb-2 text-muted"></i>
                        <p class="text-muted">Nenhuma atividade adicionada a este orçamento.</p>
                    </div>
                @else
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Atividade</th>
                                <th>Categoria</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($atividadesNoOrcamento as $item)
                            <tr>
                                <td>{{ $item->atividade->codigo }}</td>
                                <td><strong>{{ $item->atividade->nome }}</strong></td>
                                <td>{{ $item->categoriaObra->codigo }} - {{ $item->categoriaObra->nome }}</td>
                                <td>
                                    <form action="{{ route('orcamentos.atividades.destroy', [$orcamento->id, $item->atividade_id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja remover esta atividade?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@stop