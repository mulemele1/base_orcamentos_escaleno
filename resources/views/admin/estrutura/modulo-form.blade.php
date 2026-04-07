{{-- resources/views/admin/estrutura/modulo-form.blade.php --}}
@extends('admin.layouts.admin')

@section('admin-content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    @if(isset($modulo))
                        <i class="fas fa-edit"></i> Editar Módulo
                    @else
                        <i class="fas fa-plus"></i> Novo Módulo
                    @endif
                </h3>
            </div>
            <div class="card-body">
                @if(isset($modulo))
                    <form action="{{ route('admin.estrutura.modulo.update', $modulo->id) }}" method="POST">
                    @method('PUT')
                @else
                    <form action="{{ route('admin.estrutura.modulo.store') }}" method="POST">
                @endif
                    @csrf
                    
                    <div class="form-group">
                        <label for="nome">Nome do Módulo <span class="text-danger">*</span></label>
                        <input type="text" name="nome" id="nome" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               value="{{ old('nome', $modulo->nome ?? '') }}" 
                               placeholder="Ex: 4. BETÕES, AÇOS E COFRAGEM" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="ordem">Ordem <span class="text-danger">*</span></label>
                        <input type="number" name="ordem" id="ordem" 
                               class="form-control @error('ordem') is-invalid @enderror" 
                               value="{{ old('ordem', $modulo->ordem ?? 0) }}" 
                               min="1" required>
                        <small class="form-text text-muted">Define a posição de exibição (1, 2, 3...)</small>
                        @error('ordem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea name="descricao" id="descricao" 
                                  class="form-control @error('descricao') is-invalid @enderror" 
                                  rows="3">{{ old('descricao', $modulo->descricao ?? '') }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                        <a href="{{ route('admin.estrutura.modulos') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Informações
                </h3>
            </div>
            <div class="card-body">
                <h5>O que é um Módulo?</h5>
                <p>O módulo é o nível mais alto da hierarquia. Representa grandes grupos de serviços na obra.</p>
                
                <h5 class="mt-3">Exemplos:</h5>
                <ul>
                    <li>4. BETÕES, AÇOS E COFRAGEM</li>
                    <li>5. ALVENARIAS</li>
                    <li>6. COBERTURAS E TECTOS</li>
                </ul>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-lightbulb"></i>
                    <small>A ordem define a sequência de exibição no sistema.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection