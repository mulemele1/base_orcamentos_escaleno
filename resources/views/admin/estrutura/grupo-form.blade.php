{{-- resources/views/admin/estrutura/grupo-form.blade.php --}}
@extends('admin.layouts.admin')

@section('admin-content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    @if(isset($grupo))
                        <i class="fas fa-edit"></i> Editar Grupo
                    @else
                        <i class="fas fa-plus"></i> Novo Grupo
                    @endif
                </h3>
            </div>
            <div class="card-body">
                @if(isset($grupo))
                    <form action="{{ route('admin.estrutura.grupo.update', $grupo->id) }}" method="POST">
                    @method('PUT')
                @else
                    <form action="{{ route('admin.estrutura.grupo.store') }}" method="POST">
                @endif
                    @csrf
                    
                    <div class="form-group">
                        <label for="actividade_id">Actividade <span class="text-danger">*</span></label>
                        <select name="actividade_id" id="actividade_id" class="form-control @error('actividade_id') is-invalid @enderror" required>
                            <option value="">Selecione uma actividade...</option>
                            @foreach($actividades as $ativ)
                                <option value="{{ $ativ->id }}" 
                                    {{ old('actividade_id', isset($grupo) ? $grupo->actividade_id : (isset($actividadeSelecionada) ? $actividadeSelecionada->id : '')) == $ativ->id ? 'selected' : '' }}>
                                    {{ $ativ->capitulo->modulo->ordem }}.{{ $ativ->capitulo->ordem }}.{{ $ativ->ordem }} - {{ Str::limit($ativ->nome, 60) }}
                                </option>
                            @endforeach
                        </select>
                        @error('actividade_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="nome">Nome do Grupo <span class="text-danger">*</span></label>
                        <input type="text" name="nome" id="nome" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               value="{{ old('nome', $grupo->nome ?? '') }}" 
                               placeholder="Ex: Aço 10mm" required>
                        @error('nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="unidade_padrao">Unidade Padrão <span class="text-danger">*</span></label>
                        <select name="unidade_padrao" id="unidade_padrao" class="form-control @error('unidade_padrao') is-invalid @enderror" required>
                            <option value="m³" {{ old('unidade_padrao', $grupo->unidade_padrao ?? '') == 'm³' ? 'selected' : '' }}>m³ (metro cúbico)</option>
                            <option value="m²" {{ old('unidade_padrao', $grupo->unidade_padrao ?? '') == 'm²' ? 'selected' : '' }}>m² (metro quadrado)</option>
                            <option value="m" {{ old('unidade_padrao', $grupo->unidade_padrao ?? '') == 'm' ? 'selected' : '' }}>m (metro linear)</option>
                            <option value="kg" {{ old('unidade_padrao', $grupo->unidade_padrao ?? '') == 'kg' ? 'selected' : '' }}>kg (quilograma)</option>
                            <option value="un" {{ old('unidade_padrao', $grupo->unidade_padrao ?? '') == 'un' ? 'selected' : '' }}>un (unidade)</option>
                        </select>
                        @error('unidade_padrao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="ordem">Ordem <span class="text-danger">*</span></label>
                        <input type="number" name="ordem" id="ordem" 
                               class="form-control @error('ordem') is-invalid @enderror" 
                               value="{{ old('ordem', $grupo->ordem ?? 0) }}" 
                               min="1" required>
                        <small class="form-text text-muted">Define a posição de exibição dentro da actividade</small>
                        @error('ordem')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                        <a href="{{ route('admin.estrutura.grupos', isset($actividadeSelecionada) ? $actividadeSelecionada->id : (isset($grupo) ? $grupo->actividade_id : '')) }}" class="btn btn-secondary">
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
                <h5>O que é um Grupo?</h5>
                <p>O grupo é um nível opcional da hierarquia. Usado para agrupar componentes similares, como diâmetros de aço.</p>
                
                <h5 class="mt-3">Exemplo na Actividade "Armaduras de Aço CA-50":</h5>
                <ul>
                    <li>Aço 6mm</li>
                    <li>Aço 8mm</li>
                    <li>Aço 10mm</li>
                    <li>Aço 12mm</li>
                </ul>
                
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    <small>Se a actividade não precisa de agrupamento, os componentes podem ser adicionados directamente.</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection