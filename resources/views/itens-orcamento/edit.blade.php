@extends('adminlte::page')

@section('title', 'Editar Item - ' . $categoria->nome)

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
    .info-box {
        min-height: 70px;
    }
    .info-box .info-box-text {
        font-size: 0.9rem;
    }
    .info-box .info-box-number {
        font-size: 1.2rem;
        font-weight: bold;
    }
</style>

<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('itens-orcamento.list', ['categoria_id' => $categoria->id]) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar para Lista
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-secondary mt-3">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    Editar Item: {{ $item->item }} - {{ $item->descricao }}
                </h3>
            </div>
            <form action="{{ route('itens-orcamento.update', $item->id) }}" method="post">
                @csrf
                @method('PUT')
                @include('itens-orcamento.partials.form')
            </form>
        </div>
    </div>
</div>
@endsection