@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>Gestão de Preços</h2>
            <p class="text-muted">Cadastre e compare preços de diferentes fornecedores</p>
        </div>
        <div class="col text-end">
            <a href="{{ route('admin.precos.dashboard') }}" class="btn btn-info">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('admin.precos.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Novo Preço
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.precos.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <select name="material_id" class="form-control">
                            <option value="">Todos os Materiais</option>
                            @foreach($materiais as $material)
                                <option value="{{ $material->id }}" {{ request('material_id') == $material->id ? 'selected' : '' }}>
                                    {{ $material->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="fornecedor_id" class="form-control">
                            <option value="">Todos os Fornecedores</option>
                            @foreach($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->id }}" {{ request('fornecedor_id') == $fornecedor->id ? 'selected' : '' }}>
                                    {{ $fornecedor->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="data_inicio" class="form-control" 
                               value="{{ request('data_inicio') }}" placeholder="Data Início">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="data_fim" class="form-control" 
                               value="{{ request('data_fim') }}" placeholder="Data Fim">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="{{ route('admin.precos.index') }}" class="btn btn-secondary">Limpar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Preços -->
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Fornecedor</th>
                        <th>Preço</th>
                        <th>Unidade</th>
                        <th>Data Cotação</th>
                        <th>Estado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($precos as $preco)
                    <tr>
                        <td>
                            <strong>{{ $preco->material->nome }}</strong>
                            <br><small class="text-muted">{{ $preco->material->categoria }}</small>
                        </td>
                        <td>{{ $preco->fornecedor->nome }}</td>
                        <td class="fw-bold">
                            {{ number_format($preco->preco, 2, ',', '.') }} MZN
                            @if($preco->quantidade_compra > 1)
                                <br><small>({{ $preco->quantidade_compra }} {{ $preco->unidade_compra }})</small>
                            @endif
                        </td>
                        <td>{{ $preco->unidade_compra }}</td>
                        <td>{{ $preco->data_cotacao->format('d/m/Y') }}</td>
                        <td>
                            @if($preco->estado == 'ativo')
                                <span class="badge bg-success">Ativo</span>
                            @else
                                <span class="badge bg-secondary">Histórico</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.precos.edit', $preco) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.precos.destroy', $preco) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirmar exclusão?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{ $precos->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection