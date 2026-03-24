@extends('adminlte::page')

@section('title', 'Novo Template')

@section('content_header')
    <h1><i class="fas fa-plus-circle mr-2"></i>Criar Template</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('templates.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="orcamento_id">Selecionar Orçamento Base *</label>
                    <select name="orcamento_id" id="orcamento_id" class="form-control" required>
                        <option value="">-- Selecione um orçamento --</option>
                        @foreach($orcamentos as $orc)
                            <option value="{{ $orc->id }}">
                                {{ $orc->codigo }} - {{ $orc->nome_projeto }} ({{ $orc->created_at->format('d/m/Y') }})
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">O template será criado a partir da estrutura deste orçamento</small>
                </div>
                
                <div class="form-group">
                    <label for="nome">Nome do Template *</label>
                    <input type="text" name="nome" id="nome" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="tipo_projeto">Tipo de Projeto</label>
                    <select name="tipo_projeto" id="tipo_projeto" class="form-control">
                        <option value="">-- Selecione --</option>
                        <option value="residencial">Residencial</option>
                        <option value="comercial">Comercial</option>
                        <option value="industrial">Industrial</option>
                        <option value="institucional">Institucional</option>
                        <option value="infraestrutura">Infraestrutura</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descricao" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="form-check mb-3">
                    <input type="checkbox" name="publico" id="publico" class="form-check-input" value="1">
                    <label class="form-check-label" for="publico">
                        <i class="fas fa-globe"></i> Tornar público (outros usuários poderão usar este template)
                    </label>
                </div>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    O template salvará toda a estrutura do orçamento selecionado: categorias, atividades, subatividades e composições de custo.
                </div>
                
                <button type="submit" class="btn btn-primary">Criar Template</button>
                <a href="{{ route('templates.index') }}" class="btn btn-default">Cancelar</a>
            </form>
        </div>
    </div>
@stop