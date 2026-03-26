@extends('adminlte::page')

@section('title', 'Nova Atividade')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-plus-circle mr-2"></i>Nova Atividade</h1>
    <a href="{{ route('atividades.index', ['categoria_id' => $categoriaId]) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Voltar
    </a>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informações da Atividade</h3>
            </div>
            <form action="{{ route('atividades.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="codigo">Código <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('codigo') is-invalid @enderror" 
                                       id="codigo" 
                                       name="codigo" 
                                       value="{{ old('codigo') }}" 
                                       placeholder="Ex: 1, 2, 3..."
                                       required>
                                <small class="text-muted">Código numérico da atividade</small>
                                @error('codigo')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="nome">Nome da Atividade <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('nome') is-invalid @enderror" 
                                       id="nome" 
                                       name="nome" 
                                       value="{{ old('nome') }}" 
                                       placeholder="Ex: TRABALHOS PRELIMINARES"
                                       required>
                                @error('nome')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="categoria_obra_id">Módulo <span class="text-danger">*</span></label>
                                <select class="form-control @error('categoria_obra_id') is-invalid @enderror" 
                                        id="categoria_obra_id" 
                                        name="categoria_obra_id" 
                                        required>
                                    <option value="">Selecione...</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" 
                                            {{ old('categoria_obra_id', $categoriaId) == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->codigo }} - {{ $categoria->nome }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria_obra_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="unidade">Unidade</label>
                                <input type="text" 
                                       class="form-control @error('unidade') is-invalid @enderror" 
                                       id="unidade" 
                                       name="unidade" 
                                       value="{{ old('unidade', 'Vg') }}" 
                                       placeholder="Ex: Vg, m², m³">
                                @error('unidade')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="npi">NPI</label>
                                <input type="number" 
                                       class="form-control @error('npi') is-invalid @enderror" 
                                       id="npi" 
                                       name="npi" 
                                       value="{{ old('npi', 1) }}" 
                                       min="1"
                                       step="1">
                                @error('npi')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="ordem">Ordem</label>
                                <input type="number" 
                                       class="form-control @error('ordem') is-invalid @enderror" 
                                       id="ordem" 
                                       name="ordem" 
                                       value="{{ old('ordem') }}" 
                                       min="0"
                                       placeholder="Auto">
                                @error('ordem')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Salvar Atividade
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo mr-1"></i> Limpar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">
                    <i class="fas fa-info-circle mr-1"></i> Dicas
                </h3>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>Código:</strong> Use números sequenciais (1, 2, 3...)
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>Nome:</strong> Use letras maiúsculas para padronizar
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>Unidade:</strong> Vg (Verba Global), m², m³, Un, etc.
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>NPI:</strong> Número de vezes que a atividade se repete
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success mr-1"></i>
                        <strong>Ordem:</strong> Define a posição na listagem
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop