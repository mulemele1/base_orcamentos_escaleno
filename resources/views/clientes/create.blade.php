@extends('adminlte::page')

@section('title', 'Adicionar Cliente')

@section('content_header')
    <h1>Adicionar Cliente</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Novo Cliente</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf
                    @include('clientes.partials.form')
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection