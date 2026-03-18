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
                @foreach($tipos as $key => $value)
                    <option value="{{ $key }}" {{ old('tipo', $fornecedor->tipo ?? '') == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
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
                   class="form-control contacto @error('contacto') is-invalid @enderror"
                   placeholder="(00) 0000-0000">
            @error('contacto')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="celular">Celular</label>
            <input type="text" name="celular" id="celular" 
                   value="{{ old('celular', $fornecedor->celular ?? '') }}" 
                   class="form-control celular @error('celular') is-invalid @enderror"
                   placeholder="(00) 00000-0000">
            @error('celular')
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
</div>

<div class="row">
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

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="pessoa_contacto">Pessoa de Contacto</label>
            <input type="text" name="pessoa_contacto" id="pessoa_contacto" 
                   value="{{ old('pessoa_contacto', $fornecedor->pessoa_contacto ?? '') }}" 
                   class="form-control @error('pessoa_contacto') is-invalid @enderror"
                   placeholder="Nome da pessoa para contacto">
            @error('pessoa_contacto')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
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

<div class="row">
    <div class="col-md-3">
        <div class="form-group mb-3">
            <label for="cep">CEP</label>
            <input type="text" name="cep" id="cep" 
                   value="{{ old('cep', $fornecedor->cep ?? '') }}" 
                   class="form-control cep @error('cep') is-invalid @enderror" 
                   placeholder="00000-000">
            @error('cep')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-5">
        <div class="form-group mb-3">
            <label for="endereco">Endereço</label>
            <input type="text" name="endereco" id="endereco" 
                   value="{{ old('endereco', $fornecedor->endereco ?? '') }}" 
                   class="form-control @error('endereco') is-invalid @enderror" 
                   placeholder="Digite o endereço">
            @error('endereco')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group mb-3">
            <label for="numero">Número</label>
            <input type="text" name="numero" id="numero" 
                   value="{{ old('numero', $fornecedor->numero ?? '') }}" 
                   class="form-control @error('numero') is-invalid @enderror" 
                   placeholder="Nº">
            @error('numero')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group mb-3">
            <label for="complemento">Complemento</label>
            <input type="text" name="complemento" id="complemento" 
                   value="{{ old('complemento', $fornecedor->complemento ?? '') }}" 
                   class="form-control @error('complemento') is-invalid @enderror" 
                   placeholder="Complemento">
            @error('complemento')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="bairro">Bairro</label>
            <input type="text" name="bairro" id="bairro" 
                   value="{{ old('bairro', $fornecedor->bairro ?? '') }}" 
                   class="form-control @error('bairro') is-invalid @enderror" 
                   placeholder="Digite o bairro">
            @error('bairro')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group mb-3">
            <label for="cidade">Cidade</label>
            <input type="text" name="cidade" id="cidade" 
                   value="{{ old('cidade', $fornecedor->cidade ?? '') }}" 
                   class="form-control @error('cidade') is-invalid @enderror" 
                   placeholder="Digite a cidade">
            @error('cidade')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group mb-3">
            <label for="estado">UF</label>
            <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror">
                <option value="">Selecione</option>
                @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                    <option value="{{ $uf }}" {{ old('estado', $fornecedor->estado ?? '') == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                @endforeach
            </select>
            @error('estado')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group mb-3">
            <label for="pais">País</label>
            <input type="text" name="pais" id="pais" 
                   value="{{ old('pais', $fornecedor->pais ?? 'Moçambique') }}" 
                   class="form-control @error('pais') is-invalid @enderror" 
                   placeholder="País">
            @error('pais')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group mb-3">
            <label for="banco">Banco</label>
            <input type="text" name="banco" id="banco" 
                   value="{{ old('banco', $fornecedor->banco ?? '') }}" 
                   class="form-control @error('banco') is-invalid @enderror" 
                   placeholder="Banco">
            @error('banco')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group mb-3">
            <label for="iban">IBAN</label>
            <input type="text" name="iban" id="iban" 
                   value="{{ old('iban', $fornecedor->iban ?? '') }}" 
                   class="form-control @error('iban') is-invalid @enderror" 
                   placeholder="IBAN">
            @error('iban')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group mb-3">
            <label for="swift">SWIFT</label>
            <input type="text" name="swift" id="swift" 
                   value="{{ old('swift', $fornecedor->swift ?? '') }}" 
                   class="form-control @error('swift') is-invalid @enderror" 
                   placeholder="SWIFT">
            @error('swift')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="observacoes">Observações</label>
            <textarea name="observacoes" id="observacoes" rows="3" 
                class="form-control @error('observacoes') is-invalid @enderror" 
                placeholder="Digite observações adicionais sobre o fornecedor">{{ old('observacoes', $fornecedor->observacoes ?? '') }}</textarea>
            @error('observacoes')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>