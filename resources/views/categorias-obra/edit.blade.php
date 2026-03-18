@extends('adminlte::page')

@section('title', 'Editar Categoria de Obra')

@section('content')
<style>
    .card-secondary.card-outline {
        border-top-color: #6c757d;
    }
    .card-header {
        background-color: #6c757d;
        color: white;
    }
    .card-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }
    .card-header i {
        margin-right: 5px;
    }
    .required-field::after {
        content: " *";
        color: red;
        font-weight: bold;
    }
</style>

<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('categorias-obra.list') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-secondary mt-3">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    Editar Categoria: {{ $categoria->nome }}
                </h3>
            </div>
            <form action="{{ route('categorias-obra.update', $categoria->id) }}" method="post">
                @csrf
                @method('PUT')
                @include('categorias-obra.partials.form')
            </form>
        </div>
    </div>
</div>
@endsection