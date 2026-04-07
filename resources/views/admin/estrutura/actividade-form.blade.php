{{-- resources/views/admin/estrutura/actividade-form.blade.php --}}
@extends('admin.layouts.admin')

@section('admin-content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    @if(isset($actividade))
                        <i class="fas fa-edit"></i> Editar Actividade
                    @else
                        <i class="fas fa-plus"></i> Nova Actividade
                    @endif
                </h3>
            </div>
            <div class="card-body">
                @if(isset($actividade))
                    <form action="{{ route('admin.estrutura.actividade.update', $actividade->id) }}" method="POST">
                    @method('PUT')
                @else
                    <form action="{{ route('admin.estrutura.actividade.store') }}" method="POST">
                @endif
                    @csrf
                    
                    <div class="form-group">
                        <label for="capitulo_id">Capítulo <span class="text-danger">*</span></label>
                        <select name="capitulo_id" id="capitulo_id" class="form-control @error('capitulo_id') is-invalid @enderror" required>
                            <option value="">Selecione um capítulo...</option>
                            @foreach($capitulos as $cap)
                                <option value="{{ $cap->id }}" 
                                    {{ old('capitulo_id', isset($actividade) ? $actividade->capitulo_id : (isset($capituloSelecionado) ? $capituloSelecionado->id : '')) == $cap->id ? 'selected' : '' }}>
                                    {{ $cap->modulo->ordem }}.{{ $cap->ordem }} - {{ $cap->modulo->nome }} / {{ $cap->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('capitulo_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="nome">Nome da Actividade <span class="text-danger">*</span></label>
                        <input type="text" name="nome" id="nome" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               value="{{ old('nome', $actividade->nome ?? '') }}" 
                               placeholder="Ex: Fornecimento e assentamento de betão estrutural" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="ordem">Ordem <span class="text-danger">*</span></label>
                        <input type="number" name="ordem" id="ordem" 
                               class="form-control @error('ordem') is-invalid @enderror" 
                               value="{{ old('ordem', $actividade->ordem ?? 0) }}" 
                               min="1" required>
                        <small class="form-text text-muted">Define a posição de exibição dentro do capítulo</small>
                        @error('ordem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="descricao">Descrição Detalhada <span class="text-danger">*</span></label>
                        <textarea name="descricao" id="descricao" 
                                  class="form-control @error('descricao') is-invalid @enderror" 
                                  rows="5" required>{{ old('descricao', $actividade->descricao ?? '') }}</textarea>
                        <small class="form-text text-muted">Descreva detalhadamente o trabalho a ser executado</small>
                        @error('descricao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                        <a href="{{ route('admin.estrutura.actividades', isset($capituloSelecionado) ? $capituloSelecionado->id : (isset($actividade) ? $actividade->capitulo_id : '')) }}" class="btn btn-secondary">
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
                    <i class="fas fa-info-circle"></i> Informações
                </h3>
            </div>
            <div class="card-body">
                <h5>O que é uma Actividade?</h5>
                <p>A actividade é o terceiro nível da hierarquia. Descreve um trabalho específico a ser executado na obra.</p>
                
                <h5 class="mt-3">Exemplo:</h5>
                <div class="alert alert-secondary">
                    <strong>Fornecimento e assentamento de betão estrutural C20/25</strong>
                    <hr class="my-2">
                    <small>Fornecimento e assentamento de betão armado do tipo B, classe C20/25 em sapatas, vigas, pilares e lajes, incluindo trabalhos complementares.</small>
                </div>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-lightbulb"></i>
                    <small>A descrição deve ser clara e detalhada para evitar dúvidas na execução.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection