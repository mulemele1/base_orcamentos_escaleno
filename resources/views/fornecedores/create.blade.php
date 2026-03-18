@extends('adminlte::page')

@section('title', 'Editar Fornecedor')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>Novo Fornecedor</h2>
            <p class="text-muted">Cadastre um novo fornecedor no sistema</p>
        </div>
        <div class="col text-end">
            <a href="{{ route('fornecedores.list') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Dados do Fornecedor</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('fornecedores.store') }}" method="POST">
                @csrf
                
                @include('fornecedores.partials.form')
                
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Salvar Fornecedor
                    </button>
                    <a href="{{ route('fornecedores.list') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection