@extends('adminlte::page')

@section('title', 'Detalhes do Cliente')

@section('content_header')
    <h1>Detalhes do Cliente</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">{{ $cliente->nome }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 150px;">ID</th>
                                    <td>{{ $cliente->id }}</td>
                                </tr>
                                <tr>
                                    <th>Nome</th>
                                    <td>{{ $cliente->nome }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $cliente->email ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>Telefone</th>
                                    <td>{{ $cliente->telefone ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>Celular</th>
                                    <td>{{ $cliente->celular ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>CPF/CNPJ</th>
                                    <td>{{ $cliente->cpf_cnpj ?? 'Não informado' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 150px;">Tipo Pessoa</th>
                                    <td>{{ $cliente->tipo_pessoa == 'fisica' ? 'Pessoa Física' : 'Pessoa Jurídica' }}</td>
                                </tr>
                                <tr>
                                    <th>RG/IE</th>
                                    <td>{{ $cliente->rg_ie ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>Data Nascimento</th>
                                    <td>{{ $cliente->data_nascimento ? $cliente->data_nascimento->format('d/m/Y') : 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if($cliente->status == 'ativo')
                                            <span class="badge badge-success">Ativo</span>
                                        @else
                                            <span class="badge badge-danger">Inativo</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Endereço</h4>
                                </div>
                                <div class="card-body">
                                    <p>
                                        {{ $cliente->endereco ?? 'Não informado' }}, {{ $cliente->numero ?? 'S/N' }}
                                        {{ $cliente->complemento ? ' - ' . $cliente->complemento : '' }}<br>
                                        {{ $cliente->bairro ?? 'Não informado' }}<br>
                                        {{ $cliente->cidade ?? 'Não informado' }}/{{ $cliente->estado ?? 'UF' }} - CEP: {{ $cliente->cep ?? 'Não informado' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @if($cliente->observacoes)
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Observações</h4>
                                </div>
                                <div class="card-body">
                                    <p>{{ $cliente->observacoes }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection