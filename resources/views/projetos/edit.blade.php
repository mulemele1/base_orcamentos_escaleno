{{-- resources/views/projetos/edit.blade.php --}}
@extends('adminlte::page')

@section('title', 'Editar Projeto - ' . $projeto->nome)

@section('content_header')
    <h1>
        <i class="fas fa-edit text-warning mr-2"></i>
        Editar Projeto: {{ $projeto->nome }}
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
                <form action="{{ route('projetos.update', $projeto->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="nome">Nome do Projeto <span class="text-danger">*</span></label>
                        <input type="text" name="nome" id="nome" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               value="{{ old('nome', $projeto->nome) }}" required>
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
                                       value="{{ old('cliente', $projeto->cliente) }}">
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
                                       value="{{ old('localizacao', $projeto->localizacao) }}">
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
                                  rows="4">{{ old('descricao', $projeto->descricao) }}</textarea>
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
                                       value="{{ old('data_inicio', optional($projeto->data_inicio)->format('Y-m-d')) }}">
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
                                       value="{{ old('data_fim', optional($projeto->data_fim)->format('Y-m-d')) }}">
                                @error('data_fim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Status do Projeto</label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="rascunho" {{ old('status', $projeto->status) == 'rascunho' ? 'selected' : '' }}>Rascunho</option>
                                    <option value="medicao" {{ old('status', $projeto->status) == 'medicao' ? 'selected' : '' }}>Em Medição</option>
                                    <option value="orcamento" {{ old('status', $projeto->status) == 'orcamento' ? 'selected' : '' }}>Orçamento</option>
                                    <option value="concluido" {{ old('status', $projeto->status) == 'concluido' ? 'selected' : '' }}>Concluído</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="iva">IVA (%)</label>
                                <input type="number" name="iva" id="iva" 
                                       class="form-control @error('iva') is-invalid @enderror" 
                                       step="0.01" 
                                       value="{{ old('iva', $projeto->iva) }}">
                                @error('iva')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="contingencia">Contingência (%)</label>
                                <input type="number" name="contingencia" id="contingencia" 
                                       class="form-control @error('contingencia') is-invalid @enderror" 
                                       step="0.01" 
                                       value="{{ old('contingencia', $projeto->contingencia) }}">
                                @error('contingencia')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Atualizar Projeto
                        </button>
                        <a href="{{ route('projetos.show', $projeto->id) }}" class="btn btn-secondary">
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
                    <i class="fas fa-chart-line"></i> Resumo
                </h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Progresso da Medição:</strong>
                    <div class="progress mt-1" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: {{ $projeto->progresso_medicao }}%"></div>
                    </div>
                    <small class="text-muted">{{ $projeto->progresso_medicao }}% completo</small>
                </div>
                
                <div class="mb-3">
                    <strong>Medições realizadas:</strong>
                    <span class="badge badge-info">{{ $projeto->medicoes()->count() }}</span>
                </div>
                
                <div class="mb-3">
                    <strong>Orçamentos gerados:</strong>
                    <span class="badge badge-success">{{ $projeto->orcamentos()->count() }}</span>
                </div>
                
                <hr>
                
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <small>Alterar o status manualmente pode afetar o fluxo de trabalho. Use com cuidado.</small>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-copy"></i> Ações
                </h3>
            </div>
            <div class="card-body">
                <form action="{{ route('projetos.nova-versao', $projeto->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-block mb-2">
                        <i class="fas fa-copy"></i> Duplicar Projeto
                    </button>
                </form>
                
                @if($projeto->status == 'medicao')
                    <form action="{{ route('medicoes.finalizar', $projeto->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-outline-success btn-block" onclick="return confirm('Finalizar medição?')">
                            <i class="fas fa-check-circle"></i> Finalizar Medição
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@stop