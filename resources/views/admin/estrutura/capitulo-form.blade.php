{{-- resources/views/admin/estrutura/capitulo-form.blade.php --}}
@extends('admin.layouts.admin')

@section('admin-content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    @if(isset($capitulo))
                        <i class="fas fa-edit"></i> Editar Capítulo
                    @else
                        <i class="fas fa-plus"></i> Novo Capítulo
                    @endif
                </h3>
            </div>
            <div class="card-body">
                @if(isset($capitulo))
                    <form action="{{ route('admin.estrutura.capitulo.update', $capitulo->id) }}" method="POST">
                    @method('PUT')
                @else
                    <form action="{{ route('admin.estrutura.capitulo.store') }}" method="POST">
                @endif
                    @csrf
                    
                    <div class="form-group">
                        <label for="modulo_id">Módulo <span class="text-danger">*</span></label>
                        <select name="modulo_id" id="modulo_id" class="form-control @error('modulo_id') is-invalid @enderror" required>
                            <option value="">Selecione um módulo...</option>
                            @foreach($modulos as $mod)
                                <option value="{{ $mod->id }}" 
                                    {{ old('modulo_id', isset($capitulo) ? $capitulo->modulo_id : (isset($moduloSelecionado) ? $moduloSelecionado->id : '')) == $mod->id ? 'selected' : '' }}>
                                    {{ $mod->ordem }}. {{ $mod->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('modulo_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="nome">Nome do Capítulo <span class="text-danger">*</span></label>
                        <input type="text" name="nome" id="nome" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               value="{{ old('nome', $capitulo->nome ?? '') }}" 
                               placeholder="Ex: Betões" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="ordem">Ordem <span class="text-danger">*</span></label>
                        <input type="number" name="ordem" id="ordem" 
                               class="form-control @error('ordem') is-invalid @enderror" 
                               value="{{ old('ordem', $capitulo->ordem ?? 0) }}" 
                               min="1" required>
                        <small class="form-text text-muted">Define a posição de exibição dentro do módulo (1, 2, 3...)</small>
                        @error('ordem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea name="descricao" id="descricao" 
                                  class="form-control @error('descricao') is-invalid @enderror" 
                                  rows="3">{{ old('descricao', $capitulo->descricao ?? '') }}</textarea>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                        <a href="{{ route('admin.estrutura.capitulos', isset($moduloSelecionado) ? $moduloSelecionado->id : (isset($capitulo) ? $capitulo->modulo_id : '')) }}" class="btn btn-secondary">
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
                <h5>O que é um Capítulo?</h5>
                <p>O capítulo é o segundo nível da hierarquia. Agrupa actividades relacionadas dentro de um módulo.</p>
                
                <h5 class="mt-3">Exemplos no Módulo "4. BETÕES, AÇOS E COFRAGEM":</h5>
                <ul>
                    <li>Betões</li>
                    <li>Aços</li>
                    <li>Cofragem</li>
                </ul>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-lightbulb"></i>
                    <small>A ordem define a sequência de exibição dentro do módulo.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection