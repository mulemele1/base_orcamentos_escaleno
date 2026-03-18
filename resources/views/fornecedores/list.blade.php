@extends('adminlte::page')

@section('title', 'Form Fornecedor')

@section('content')
<div class="container-fluid">
    <!-- Cabeçalho -->
    <div class="row mb-4">
        <div class="col">
            <h2>Fornecedores</h2>
            <p class="text-muted">Gestão de fornecedores de materiais de construção</p>
        </div>
        <div class="col text-end">
            <a href="{{ route('fornecedores.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Novo Fornecedor
            </a>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Fornecedores</h5>
                    <h3>{{ $totalFornecedores }}</h3>
                </div>
            </div>
        </div>
        @foreach($tipos as $tipo)
        <div class="col-md-2">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <h6 class="card-title">{{ ucfirst($tipo->tipo) }}</h6>
                    <h4>{{ $tipo->total }}</h4>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Filtros e Busca -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('fornecedores.list') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Buscar</label>
                            <input type="text" name="search" class="form-control" 
                                   value="{{ request('search') }}" 
                                   placeholder="Nome, localização ou tipo...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipo</label>
                            <select name="tipo" class="form-control">
                                <option value="">Todos</option>
                                @foreach(['ferragem', 'betoneira', 'construcao', 'madeira', 'agregados', 'eletrico', 'hidraulico', 'diversos'] as $tipo)
                                    <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>
                                        {{ ucfirst($tipo) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">Todos</option>
                                <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                                <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filtrar
                                </button>
                                <a href="{{ route('fornecedores.list') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabela de Fornecedores -->
    <div class="card">
        <div class="card-header">
            <h5>Lista de Fornecedores</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Localização</th>
                            <th>Tipo</th>
                            <th>Contacto</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Preços</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fornecedores as $fornecedor)
                        <tr>
                            <td>{{ $fornecedor->id }}</td>
                            <td>
                                <strong>{{ $fornecedor->nome }}</strong>
                                @if($fornecedor->nuit)
                                    <br><small class="text-muted">NUIT: {{ $fornecedor->nuit }}</small>
                                @endif
                            </td>
                            <td>{{ $fornecedor->localizacao ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($fornecedor->tipo) }}</span>
                            </td>
                            <td>{{ $fornecedor->contacto ?? '-' }}</td>
                            <td>{{ $fornecedor->email ?? '-' }}</td>
                            <td>
                                @if($fornecedor->status == 'ativo')
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary">{{ $fornecedor->precos->count() }}</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('fornecedores.show', $fornecedor->id) }}" 
                                       class="btn btn-sm btn-info" title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" 
                                       class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('fornecedores.destroy', $fornecedor->id) }}" 
                                          method="POST" class="d-inline" 
                                          onsubmit="return confirm('Tem certeza que deseja excluir este fornecedor?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Nenhum fornecedor encontrado</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center">
                {{ $fornecedores->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        @if(session('success'))
            Swal.fire('Sucesso!', '{{ session('success') }}', 'success');
        @endif
        
        @if(session('error'))
            Swal.fire('Erro!', '{{ session('error') }}', 'error');
        @endif
    });
</script>
@endpush
@endsection