@extends('adminlte::page')

@section('title', 'Detalhes da Categoria')

@section('content')
<style>
    .info-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .info-card h1 {
        font-size: 1.8rem;
        margin-bottom: 5px;
    }
    .info-card p {
        opacity: 0.9;
        margin: 0;
    }
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        border: 1px solid #e2e5eb;
    }
    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #1c6ef3;
    }
</style>

<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('categorias-obra.list') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <a href="{{ route('categorias-obra.edit', $categoria->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Editar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="info-card">
            <h1><i class="fas fa-folder-open mr-2"></i>{{ $categoria->nome }}</h1>
            <p>Código: {{ $categoria->codigo }} | Ordem: {{ $categoria->ordem }}</p>
            @if($categoria->descricao)
                <p class="mt-2">{{ $categoria->descricao }}</p>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-number">{{ $categoria->atividades->count() }}</div>
            <div>Atividades</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">
            <i class="fas fa-tasks"></i> Atividades desta Categoria
        </h3>
        <div class="card-tools">
            <a href="{{ route('atividades.create', ['categoria_id' => $categoria->id]) }}" class="btn btn-sm btn-light">
                <i class="fas fa-plus"></i> Nova Atividade
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                60d
                    <th>Código</th>
                    <th>Nome</th>
                    <th>Unidade</th>
                    <th>Subatividades</th>
                    <th>Ações</th>
                </thead>
            <tbody>
                @forelse($categoria->atividades as $atividade)
                 <tr>
                    <td><span class="badge bg-primary">{{ $atividade->codigo }}</span></td>
                    <td><strong>{{ $atividade->nome }}</strong></td>
                    <td>{{ $atividade->unidade }}</td>
                    <td><span class="badge bg-success">{{ $atividade->subatividades->count() }}</span></td>
                    <td>
                        <a href="{{ route('atividades.show', $atividade->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('subatividades.index', ['atividade_id' => $atividade->id]) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-list"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">
                        <i class="fas fa-info-circle"></i> Nenhuma atividade cadastrada nesta categoria.
                        <a href="{{ route('atividades.create', ['categoria_id' => $categoria->id]) }}" class="btn btn-sm btn-primary ml-2">
                            Criar primeira atividade
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@php
    $projetosVinculados = DB::table('orcamentos')
        ->join('orcamento_atividades', 'orcamentos.id', '=', 'orcamento_atividades.orcamento_id')
        ->join('atividades', 'orcamento_atividades.atividade_id', '=', 'atividades.id')
        ->where('atividades.categoria_obra_id', $categoria->id)
        ->select('orcamentos.id', 'orcamentos.nome_projeto', 'orcamentos.codigo')
        ->distinct()
        ->get();
@endphp

@if($projetosVinculados->count() > 0)
<div class="card mt-3">
    <div class="card-header bg-success text-white">
        <h3 class="card-title">
            <i class="fas fa-project-diagram"></i> Projetos que utilizam esta categoria
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($projetosVinculados as $projeto)
            <div class="col-md-4 mb-2">
                <a href="{{ route('projetos.show', $projeto->id) }}" class="text-decoration-none">
                    <div class="card border-left-primary shadow-sm">
                        <div class="card-body py-2 px-3">
                            <i class="fas fa-building text-primary mr-2"></i>
                            <strong>{{ $projeto->nome_projeto }}</strong>
                            <br><small class="text-muted">{{ $projeto->codigo }}</small>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

@stop