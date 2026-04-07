{{-- resources/views/admin/layouts/admin.blade.php --}}
@extends('adminlte::page')

@section('title', 'Administração - Estrutura')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-sitemap text-primary mr-2"></i>
        Administração da Estrutura
    </h1>
    <div>
        <a href="{{ route('admin.estrutura.index') }}" class="btn btn-info">
            <i class="fas fa-tree"></i> Árvore Completa
        </a>
        <a href="{{ route('admin.estrutura.modulos') }}" class="btn btn-primary">
            <i class="fas fa-layer-group"></i> Módulos
        </a>
        <a href="{{ route('admin.estrutura.capitulos') }}" class="btn btn-secondary">
            <i class="fas fa-book"></i> Capítulos
        </a>
        <a href="{{ route('admin.estrutura.actividades') }}" class="btn btn-success">
            <i class="fas fa-tasks"></i> Actividades
        </a>
        <a href="{{ route('admin.estrutura.grupos') }}" class="btn btn-warning">
            <i class="fas fa-layer-group"></i> Grupos
        </a>
        {{-- CORREÇÃO: Usar a rota de todos os componentes --}}
        <a href="{{ route('admin.estrutura.componentes.todos') }}" class="btn btn-danger">
            <i class="fas fa-cube"></i> Componentes
        </a>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif
        
        @yield('admin-content')
    </div>
</div>
@endsection