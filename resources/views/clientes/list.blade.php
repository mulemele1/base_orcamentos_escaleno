@extends('adminlte::page')

@section('title', 'Lista de Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lista de Clientes</h3>
                    <a href="{{ route('clientes.create') }}" class="btn btn-primary float-right">
                        <i class="fas fa-plus"></i> Novo Cliente
                    </a>
                </div>
                <div class="card-body">
                    <!-- Formulário de busca -->
                    <form action="{{ route('clientes.list') }}" method="GET" class="form-inline mb-3">
                        <div class="form-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar..." value="{{ request('search') }}">
                        </div>
                        <div class="form-group mx-2">
                            <select name="status" class="form-control">
                                <option value="">Todos os status</option>
                                <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-filter"></i> Filtrar
                        </button>
                    </form>

                    <!-- Tabela de clientes -->
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>CPF/CNPJ</th>
                                <th>Status</th>
                                <th width="150">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>{{ $cliente->nome }}</td>
                                <td>{{ $cliente->email }}</td>
                                <td>{{ $cliente->telefone ?: $cliente->celular }}</td>
                                <td>{{ $cliente->cpf_cnpj }}</td>
                                <td>
                                    @if($cliente->status == 'ativo')
                                        <span class="badge badge-success">Ativo</span>
                                    @else
                                        <span class="badge badge-danger">Inativo</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-sm btn-info" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este cliente?')" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Nenhum cliente encontrado</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Paginação -->
                    <div class="mt-3">
                        {{ $clientes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection