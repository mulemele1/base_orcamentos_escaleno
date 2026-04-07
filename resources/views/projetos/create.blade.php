@extends('adminlte::page')

@section('title', 'Novo Projeto')

@section('content_header')
    <h1>
        <i class="fas fa-plus-circle text-success mr-2"></i>
        Novo Projeto
    </h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informações do Projeto</h3>
            </div>
            <div class="card-body">
                {{-- CORREÇÃO: Usar url() em vez de route() --}}
                <form action="{{ url('/projetos') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="nome">Nome do Projeto <span class="text-danger">*</span></label>
                        <input type="text" name="nome" id="nome" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               value="{{ old('nome') }}" 
                               placeholder="Ex: Igreja de Boquisso" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cliente">Cliente</label>
                                <input type="text" name="cliente" id="cliente" 
                                       class="form-control @error('cliente') is-invalid @enderror" 
                                       value="{{ old('cliente') }}" 
                                       placeholder="Nome do cliente">
                                @error('cliente')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="localizacao">Localização</label>
                                <input type="text" name="localizacao" id="localizacao" 
                                       class="form-control @error('localizacao') is-invalid @enderror" 
                                       value="{{ old('localizacao') }}" 
                                       placeholder="Endereço do projeto">
                                @error('localizacao')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea name="descricao" id="descricao" 
                                  class="form-control @error('descricao') is-invalid @enderror" 
                                  rows="4" 
                                  placeholder="Descreva o projeto...">{{ old('descricao') }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="data_inicio">Data de Início</label>
                                <input type="date" name="data_inicio" id="data_inicio" 
                                       class="form-control @error('data_inicio') is-invalid @enderror" 
                                       value="{{ old('data_inicio') }}">
                                @error('data_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="data_fim">Data de Fim</label>
                                <input type="date" name="data_fim" id="data_fim" 
                                       class="form-control @error('data_fim') is-invalid @enderror" 
                                       value="{{ old('data_fim') }}">
                                @error('data_fim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="iva">IVA (%)</label>
                                <input type="number" name="iva" id="iva" 
                                       class="form-control @error('iva') is-invalid @enderror" 
                                       step="0.01" 
                                       value="{{ old('iva', 16) }}">
                                <small class="form-text text-muted">Percentual padrão: 16%</small>
                                @error('iva')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contingencia">Contingência (%)</label>
                                <input type="number" name="contingencia" id="contingencia" 
                                       class="form-control @error('contingencia') is-invalid @enderror" 
                                       step="0.01" 
                                       value="{{ old('contingencia', 8) }}">
                                <small class="form-text text-muted">Percentual padrão: 8%</small>
                                @error('contingencia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Criar Projeto
                        </button>
                        <a href="{{ url('/projetos') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Dicas
                </h3>
            </div>
            <div class="card-body">
                <h5>O que é um projeto?</h5>
                <p>Um projeto representa uma obra ou construção específica. Cada projeto terá suas próprias medições e orçamentos.</p>
                
                <h5 class="mt-3">Próximos passos:</h5>
                <ol class="pl-3">
                    <li>Preencha as informações básicas</li>
                    <li>Após criar, inicie a medição</li>
                    <li>Adicione as dimensões dos elementos</li>
                    <li>Gere o orçamento final</li>
                </ol>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-lightbulb"></i>
                    <small>Os campos com <span class="text-danger">*</span> são obrigatórios.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@stop