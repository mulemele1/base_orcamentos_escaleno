@php
    // Define o fornecedor como um objeto vazio se não existir (para create)
    $fornecedor = $fornecedor ?? null;
@endphp

<style>
    .required-field::after {
        content: " *";
        color: red;
    }
</style>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="nome" class="required-field">Nome do Fornecedor</label>
            <input type="text" name="nome" id="nome" 
                   value="{{ old('nome', $fornecedor->nome ?? '') }}" 
                   class="form-control @error('nome') is-invalid @enderror" 
                   placeholder="Digite o nome do fornecedor" 
                   required>
            @error('nome')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="form-group mb-3">
            <label for="tipo">Tipo</label>
            <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror">
                <option value="">Selecione...</option>
                <option value="ferragem" {{ old('tipo', $fornecedor->tipo ?? '') == 'ferragem' ? 'selected' : '' }}>Ferragem</option>
                <option value="betoneira" {{ old('tipo', $fornecedor->tipo ?? '') == 'betoneira' ? 'selected' : '' }}>Betoneira</option>
                <option value="construcao" {{ old('tipo', $fornecedor->tipo ?? '') == 'construcao' ? 'selected' : '' }}>Construção</option>
                <option value="madeira" {{ old('tipo', $fornecedor->tipo ?? '') == 'madeira' ? 'selected' : '' }}>Madeira</option>
                <option value="agregados" {{ old('tipo', $fornecedor->tipo ?? '') == 'agregados' ? 'selected' : '' }}>Agregados</option>
                <option value="eletrico" {{ old('tipo', $fornecedor->tipo ?? '') == 'eletrico' ? 'selected' : '' }}>Elétrico</option>
                <option value="hidraulico" {{ old('tipo', $fornecedor->tipo ?? '') == 'hidraulico' ? 'selected' : '' }}>Hidráulico</option>
                <option value="diversos" {{ old('tipo', $fornecedor->tipo ?? '') == 'diversos' ? 'selected' : '' }}>Diversos</option>
            </select>
            @error('tipo')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="form-group mb-3">
            <label for="nuit">NUIT</label>
            <input type="text" name="nuit" id="nuit" 
                   value="{{ old('nuit', $fornecedor->nuit ?? '') }}" 
                   class="form-control @error('nuit') is-invalid @enderror"
                   placeholder="000000000">
            @error('nuit')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="contacto">Contacto</label>
            <input type="text" name="contacto" id="contacto" 
                   value="{{ old('contacto', $fornecedor->contacto ?? '') }}" 
                   class="form-control @error('contacto') is-invalid @enderror"
                   placeholder="(00) 0000-0000">
            @error('contacto')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" 
                   value="{{ old('email', $fornecedor->email ?? '') }}" 
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="fornecedor@email.com">
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="website">Website</label>
            <input type="url" name="website" id="website" 
                   value="{{ old('website', $fornecedor->website ?? '') }}" 
                   class="form-control @error('website') is-invalid @enderror"
                   placeholder="https://...">
            @error('website')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="localizacao">Localização</label>
            <input type="text" name="localizacao" id="localizacao" 
                   value="{{ old('localizacao', $fornecedor->localizacao ?? '') }}" 
                   class="form-control @error('localizacao') is-invalid @enderror"
                   placeholder="Endereço completo, cidade, país">
            @error('localizacao')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="status" class="required-field">Status</label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="ativo" {{ old('status', $fornecedor->status ?? 'ativo') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="inativo" {{ old('status', $fornecedor->status ?? '') == 'inativo' ? 'selected' : '' }}>Inativo</option>
            </select>
            @error('status')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>