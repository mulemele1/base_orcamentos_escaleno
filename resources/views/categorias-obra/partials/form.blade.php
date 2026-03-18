<div class="card-body">
    @include('categorias-obra.partials.validations')

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="codigo" class="required-field">Código</label>
                <input type="text" 
                       name="codigo" 
                       value="{{ old('codigo', $categoria->codigo ?? '') }}" 
                       class="form-control @error('codigo') is-invalid @enderror" 
                       id="codigo"
                       placeholder="Ex: 01, 02, 03" 
                       required>
                @error('codigo')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <small class="text-muted">Código único para identificar a categoria</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="ordem" class="required-field">Ordem</label>
                <input type="number" 
                       name="ordem" 
                       value="{{ old('ordem', $categoria->ordem ?? '0') }}" 
                       class="form-control @error('ordem') is-invalid @enderror" 
                       id="ordem"
                       min="0"
                       required>
                @error('ordem')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <small class="text-muted">Ordem de exibição</small>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="nome" class="required-field">Nome da Categoria</label>
        <input type="text" 
               name="nome" 
               value="{{ old('nome', $categoria->nome ?? '') }}" 
               class="form-control @error('nome') is-invalid @enderror" 
               id="nome"
               placeholder="Ex: 01 - EDIFICIO PRINCIPAL" 
               required>
        @error('nome')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea class="form-control @error('descricao') is-invalid @enderror" 
                  id="descricao" 
                  name="descricao" 
                  rows="3"
                  placeholder="Descrição da categoria (opcional)">{{ old('descricao', $categoria->descricao ?? '') }}</textarea>
        @error('descricao')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    @if(isset($categoria) && $categoria->id)
        <div class="alert alert-secondary mt-3">
            <div class="row">
                <div class="col-md-6">
                    <small>
                        <i class="far fa-calendar-alt mr-1"></i>
                        <strong>Criado em:</strong> {{ $categoria->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
                <div class="col-md-6">
                    <small>
                        <i class="far fa-clock mr-1"></i>
                        <strong>Última atualização:</strong> {{ $categoria->updated_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-secondary">
        <i class="fas fa-save mr-1"></i> {{ isset($categoria) ? 'Atualizar' : 'Salvar' }}
    </button>
    <a href="{{ route('categorias-obra.list') }}" class="btn btn-default">
        <i class="fas fa-times mr-1"></i> Cancelar
    </a>
</div>