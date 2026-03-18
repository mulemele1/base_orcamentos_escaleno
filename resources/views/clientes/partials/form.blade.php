<style>
    .btn-custom {
        width: 70px;
        height: 30px;
        margin-top: 6px;
        justify-content: center;
        align-items: center;
        display: flex;
        margin-right: 10px;
    }
    .button-container {
        display: flex;
        margin-top: 2px;
    }
    .required-field::after {
        content: " *";
        color: red;
    }
</style>

<div class="card-body">
    @include('clientes.partials.validations')
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="nome" class="required-field">Nome</label>
                <input type="text" name="nome" value="{{ $cliente->nome ?? old('nome') }}" 
                    class="form-control @error('nome') is-invalid @enderror" id="nome"
                    placeholder="Digite o nome completo" required>
                @error('nome')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{ $cliente->email ?? old('email') }}" 
                    class="form-control @error('email') is-invalid @enderror" id="email"
                    placeholder="Digite o email">
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="tipo_pessoa" class="required-field">Tipo Pessoa</label>
                <select name="tipo_pessoa" id="tipo_pessoa" class="form-control @error('tipo_pessoa') is-invalid @enderror" required>
                    <option value="fisica" {{ old('tipo_pessoa', $cliente->tipo_pessoa ?? '') == 'fisica' ? 'selected' : '' }}>Pessoa Física</option>
                    <option value="juridica" {{ old('tipo_pessoa', $cliente->tipo_pessoa ?? '') == 'juridica' ? 'selected' : '' }}>Pessoa Jurídica</option>
                </select>
                @error('tipo_pessoa')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="cpf_cnpj">CPF/CNPJ</label>
                <input type="text" name="cpf_cnpj" id="cpf_cnpj" value="{{ $cliente->cpf_cnpj ?? old('cpf_cnpj') }}" 
                    class="form-control cpf_cnpj @error('cpf_cnpj') is-invalid @enderror" 
                    placeholder="Digite CPF ou CNPJ">
                @error('cpf_cnpj')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="rg_ie">RG/IE</label>
                <input type="text" name="rg_ie" id="rg_ie" value="{{ $cliente->rg_ie ?? old('rg_ie') }}" 
                    class="form-control @error('rg_ie') is-invalid @enderror" 
                    placeholder="Digite RG ou IE">
                @error('rg_ie')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone" value="{{ $cliente->telefone ?? old('telefone') }}" 
                    class="form-control telefone @error('telefone') is-invalid @enderror" 
                    placeholder="(00) 0000-0000">
                @error('telefone')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="celular">Celular</label>
                <input type="text" name="celular" id="celular" value="{{ $cliente->celular ?? old('celular') }}" 
                    class="form-control celular @error('celular') is-invalid @enderror" 
                    placeholder="(00) 00000-0000">
                @error('celular')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="data_nascimento">Data Nascimento</label>
                <input type="date" name="data_nascimento" id="data_nascimento" value="{{ $cliente->data_nascimento ?? old('data_nascimento') }}" 
                    class="form-control @error('data_nascimento') is-invalid @enderror">
                @error('data_nascimento')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label for="cep">CEP</label>
                <input type="text" name="cep" id="cep" value="{{ $cliente->cep ?? old('cep') }}" 
                    class="form-control cep @error('cep') is-invalid @enderror" 
                    placeholder="00000-000">
                @error('cep')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-5">
            <div class="form-group">
                <label for="endereco">Endereço</label>
                <input type="text" name="endereco" id="endereco" value="{{ $cliente->endereco ?? old('endereco') }}" 
                    class="form-control @error('endereco') is-invalid @enderror" 
                    placeholder="Digite o endereço">
                @error('endereco')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="numero">Número</label>
                <input type="text" name="numero" id="numero" value="{{ $cliente->numero ?? old('numero') }}" 
                    class="form-control @error('numero') is-invalid @enderror" 
                    placeholder="Nº">
                @error('numero')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="complemento">Complemento</label>
                <input type="text" name="complemento" id="complemento" value="{{ $cliente->complemento ?? old('complemento') }}" 
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
            <div class="form-group">
                <label for="bairro">Bairro</label>
                <input type="text" name="bairro" id="bairro" value="{{ $cliente->bairro ?? old('bairro') }}" 
                    class="form-control @error('bairro') is-invalid @enderror" 
                    placeholder="Digite o bairro">
                @error('bairro')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="cidade">Cidade</label>
                <input type="text" name="cidade" id="cidade" value="{{ $cliente->cidade ?? old('cidade') }}" 
                    class="form-control @error('cidade') is-invalid @enderror" 
                    placeholder="Digite a cidade">
                @error('cidade')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="estado">UF</label>
                <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror">
                    <option value="">Selecione</option>
                    @foreach(['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'] as $uf)
                        <option value="{{ $uf }}" {{ old('estado', $cliente->estado ?? '') == $uf ? 'selected' : '' }}>{{ $uf }}</option>
                    @endforeach
                </select>
                @error('estado')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="status" class="required-field">Status</label>
                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                    <option value="ativo" {{ old('status', $cliente->status ?? '') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="inativo" {{ old('status', $cliente->status ?? '') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                </select>
                @error('status')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="profissao">Profissão</label>
                <input type="text" name="profissao" id="profissao" value="{{ $cliente->profissao ?? old('profissao') }}" 
                    class="form-control @error('profissao') is-invalid @enderror" 
                    placeholder="Digite a profissão">
                @error('profissao')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="empresa">Empresa</label>
                <input type="text" name="empresa" id="empresa" value="{{ $cliente->empresa ?? old('empresa') }}" 
                    class="form-control @error('empresa') is-invalid @enderror" 
                    placeholder="Digite a empresa onde trabalha">
                @error('empresa')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea name="observacoes" id="observacoes" rows="3" 
                    class="form-control @error('observacoes') is-invalid @enderror" 
                    placeholder="Digite observações adicionais">{{ $cliente->observacoes ?? old('observacoes') }}</textarea>
                @error('observacoes')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="card-footer">
    <button type="submit" class="btn btn-secondary" id="btnSalvar">
        <i class="fas fa-save"></i> Salvar
    </button>
    <a href="{{ route('clientes.list') }}" class="btn btn-default">
    <i class="fas fa-times"></i> Cancelar
</a>
</div>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $(document).ready(function() {
        // Máscaras
        $('.telefone').mask('(00) 0000-0000');
        $('.celular').mask('(00) 00000-0000');
        $('.cep').mask('00000-000');
        
        // Máscara dinâmica para CPF/CNPJ
        $('#tipo_pessoa').change(function() {
            if($(this).val() == 'fisica') {
                $('.cpf_cnpj').mask('000.000.000-00', {reverse: true});
                $('#rg_ie').attr('placeholder', 'Digite o RG');
            } else {
                $('.cpf_cnpj').mask('00.000.000/0000-00', {reverse: true});
                $('#rg_ie').attr('placeholder', 'Digite a Inscrição Estadual');
            }
        }).trigger('change');

        // Botão Salvar com SweetAlert
        $('#btnSalvar').click(function(e) {
            e.preventDefault();
            
            // Validação básica
            let nome = $('#nome').val();
            if (!nome) {
                Swal.fire({
                    title: 'Erro!',
                    text: 'O campo Nome é obrigatório.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Dispara o submit do formulário
            $(this).closest('form').submit();
        });

        // Busca automática de CEP
        $('#cep').blur(function() {
            let cep = $(this).val().replace(/\D/g, '');
            if (cep.length === 8) {
                $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                    if (!data.erro) {
                        $('#endereco').val(data.logradouro);
                        $('#bairro').val(data.bairro);
                        $('#cidade').val(data.localidade);
                        $('#estado').val(data.uf);
                    } else {
                        Swal.fire({
                            title: 'Atenção!',
                            text: 'CEP não encontrado.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });

    // Função para o SweetAlert após salvar (se quiser manter)
    function salvar() {
        // Esta função pode ser removida se não for mais necessária
        // ou adaptada para confirmar antes de enviar
        const form = document.querySelector('form');
        if (form) {
            Swal.fire({
                title: 'Salvar?',
                text: "Deseja salvar as alterações?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    }
</script>