@extends('adminlte::page')

@section('title', 'Editar Material')

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

<div class="row">
    <div class="col-12">
        <div class="card card-secondary mt-3">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    Editar Material: {{ $material->nome }}
                </h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('materiais.update', $material->id) }}" method="post">
                @csrf
                @method('PUT')
                @include('materiais.partials.form')
            </form>
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection