@extends('adminlte::page')

@section('title', 'Editar Fornecedor')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>Detalhes do Fornecedor</h2>
            <p class="text-muted">Informações completas do fornecedor</p>
        </div>
        <div class="col text-end">
            <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('fornecedores.list') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5>Informações Gerais</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>ID:</th>
                            <td>{{ $fornecedor->id }}</td>
                        </tr>
                        <tr>
                            <th>Nome:</th>
                            <td><strong>{{ $fornecedor->nome }}</strong></td>
                        </tr>
                        <tr>
                            <th>Tipo:</th>
                            <td><span class="badge bg-info">{{ ucfirst($fornecedor->tipo) }}</span></td>
                        </tr>
                        <tr>
                            <th>NUIT:</th>
                            <td>{{ $fornecedor->nuit ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($fornecedor->status == 'ativo')
                                    <span class="badge bg-success">Ativo</span>
                                @else
                                    <span class="badge bg-danger">Inativo</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Localização:</th>
                            <td>{{ $fornecedor->localizacao ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Contactos</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th>Telefone:</th>
                            <td>{{ $fornecedor->contacto ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>
                                @if($fornecedor->email)
                                    <a href="mailto:{{ $fornecedor->email }}">{{ $fornecedor->email }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Website:</th>
                            <td>
                                @if($fornecedor->website)
                                    <a href="{{ $fornecedor->website }}" target="_blank">{{ $fornecedor->website }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5>Estatísticas de Preços</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3>{{ $totalPrecos }}</h3>
                                    <p>Total de Preços</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3>{{ $precosAtivos }}</h3>
                                    <p>Preços Ativos</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h3>{{ $totalPrecos - $precosAtivos }}</h3>
                                    <p>Históricos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h5 class="mt-4">Últimos Preços Cadastrados</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Preço</th>
                                <th>Data</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ultimosPrecos as $preco)
                            <tr>
                                <td>{{ $preco->material->nome }}</td>
                                <td>{{ number_format($preco->preco, 2, ',', '.') }} MZN</td>
                                <td>{{ $preco->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($preco->estado == 'ativo')
                                        <span class="badge bg-success">Ativo</span>
                                    @else
                                        <span class="badge bg-secondary">Histórico</span>
                                    @endif
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
@endsection