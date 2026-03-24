@extends('adminlte::page')

@section('title', 'Editar Template')

@section('content_header')
    <h1><i class="fas fa-edit mr-2"></i>Editar Template: {{ $template->nome }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('templates.update', $template->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="nome">Nome do Template *</label>
                    <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $template->nome) }}" required>
                </div>
                
                <div class="form-group">
                    <label for="tipo_projeto">Tipo de Projeto</label>
                    <select name="tipo_projeto" id="tipo_projeto" class="form-control">
                        <option value="">-- Selecione --</option>
                        <option value="residencial" {{ old('tipo_projeto', $template->tipo_projeto) == 'residencial' ? 'selected' : '' }}>Residencial</option>
                        <option value="comercial" {{ old('tipo_projeto', $template->tipo_projeto) == 'comercial' ? 'selected' : '' }}>Comercial</option>
                        <option value="industrial" {{ old('tipo_projeto', $template->tipo_projeto) == 'industrial' ? 'selected' : '' }}>Industrial</option>
                        <option value="institucional" {{ old('tipo_projeto', $template->tipo_projeto) == 'institucional' ? 'selected' : '' }}>Institucional</option>
                        <option value="infraestrutura" {{ old('tipo_projeto', $template->tipo_projeto) == 'infraestrutura' ? 'selected' : '' }}>Infraestrutura</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descricao" class="form-control" rows="3">{{ old('descricao', $template->descricao) }}</textarea>
                </div>
                
                <div class="form-check mb-3">
                    <input type="checkbox" name="publico" id="publico" class="form-check-input" value="1" {{ old('publico', $template->publico) ? 'checked' : '' }}>
                    <label class="form-check-label" for="publico">
                        <i class="fas fa-globe"></i> Tornar público (outros usuários poderão usar este template)
                    </label>
                </div>
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    A estrutura do template (atividades, subatividades e materiais) não pode ser editada após a criação.
                    Para alterar a estrutura, crie um novo template.
                </div>
                
                <button type="submit" class="btn btn-primary">Atualizar Template</button>
                <a href="{{ route('templates.show', $template->id) }}" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </div>
@stop