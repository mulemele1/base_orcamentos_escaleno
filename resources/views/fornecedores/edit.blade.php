@extends('adminlte::page')

@section('title', 'Editar Fornecedor')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2>Editar Fornecedor</h2>
            <p class="text-muted">Altere os dados do fornecedor</p>
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
            <form action="{{ route('fornecedores.update', $fornecedor->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                @include('fornecedores.partials.form')
                
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Atualizar
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