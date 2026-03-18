@extends('adminlte::page')

@section('title', 'Selecionar Categoria')

@section('content')
<style>
    .card-secondary.card-outline {
        border-top-color: #6c757d;
    }
    .card-header {
        background-color: #6c757d;
        color: white;
    }
    .card-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }
    .card-header i {
        margin-right: 5px;
    }
    .categoria-card {
        transition: transform 0.2s;
        cursor: pointer;
        border: 1px solid #dee2e6;
    }
    .categoria-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        border-color: #90caf9;
    }
    .categoria-card .card-body {
        text-align: center;
        padding: 20px;
    }
    .categoria-card i {
        font-size: 2.5em;
        color: #6c757d;
        margin-bottom: 10px;
    }
    .categoria-card:hover i {
        color: #90caf9;
    }
    .categoria-card .badge {
        font-size: 1em;
        padding: 5px 10px;
    }
</style>

<div class="row mb-3">
    <div class="col-12">
        <a href="{{ url('/home') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-secondary mt-3">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-folder-open"></i>
                    Selecionar Categoria de Obra
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse ($categorias as $categoria)
                        <div class="col-md-4 col-sm-6 mb-4">
                            <a href="{{ route('itens-orcamento.list', ['categoria_id' => $categoria->id]) }}" 
                               class="text-decoration-none">
                                <div class="card categoria-card">
                                    <div class="card-body">
                                        <i class="fas fa-building"></i>
                                        <h5 class="card-title">{{ $categoria->nome }}</h5>
                                        <p class="card-text text-muted small">
                                            {{ $categoria->descricao ?? 'Sem descrição' }}
                                        </p>
                                        <span class="badge bg-secondary">{{ $categoria->codigo }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Nenhuma categoria encontrada. 
                                <a href="{{ route('categorias-obra.create') }}" class="alert-link">
                                    Clique aqui para criar uma categoria.
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection