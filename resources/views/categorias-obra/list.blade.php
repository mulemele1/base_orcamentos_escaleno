@extends('adminlte::page')

@section('title', 'Categorias de Obra')

@section('content')
<style>
    .table {
        background-color: #e3f2fd;
        color: #333;
    }
    .table th {
        background-color: #90caf9;
        color: #fff;
        text-align: center;
    }
    .table td {
        background-color: #e3f2fd;
        color: #000;
        text-align: center;
        vertical-align: middle;
    }
    .table .btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 35px;
        height: 35px;
        border-radius: 4px;
    }
    .btn-group {
        display: inline-block;
        justify-content: center;
    }
    .filter-box {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
</style>

<div class="row mb-3">
    <div class="col-12">
        <a href="{{ url('/home') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-folder mr-2"></i>Categorias de Obra
                </h3>
                <div class="card-tools">
                    <a href="{{ route('categorias-obra.create') }}" class="btn-sm bg-lightblue">
                        <i class="fas fa-plus"></i> Nova Categoria
                    </a>
                </div>
            </div>
            <div class="card-body">
                <!-- Filtros -->
                <div class="filter-box">
                    <form method="GET" action="{{ route('categorias-obra.list') }}" class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="search">Pesquisar:</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       placeholder="Código, nome ou descrição..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-info form-control">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <a href="{{ route('categorias-obra.list') }}" class="btn btn-default form-control">
                                    <i class="fas fa-times"></i> Limpar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 10%">Código</th>
                                <th style="width: 30%">Nome</th>
                                <th style="width: 10%">Ordem</th>
                                <th style="width: 30%">Descrição</th>
                                <th style="width: 15%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categorias as $categoria)
                                <tr>
                                    <td>{{ $categoria->id }}</td>
                                    <td><span class="badge bg-secondary">{{ $categoria->codigo }}</span></td>
                                    <td class="text-left">{{ $categoria->nome }}</td>
                                    <td>{{ $categoria->ordem }}</td>
                                    <td class="text-left">{{ $categoria->descricao ?? '-' }}</td>
                                    <td>
    <div class="btn-group">
        <a role="button" class="btn bg-lightblue" 
           href="{{ route('categorias-obra.edit', $categoria->id) }}"
           title="Editar">
            <i class="fas fa-pencil-alt"></i>
        </a>
        <a role="button" class="btn bg-danger" 
           href="{{ route('pdf.categoria', $categoria->id) }}"
           target="_blank"
           title="PDF da Categoria">
            <i class="fas fa-file-pdf"></i>
        </a>
        <button type="button" class="btn bg-danger" 
                onclick="confirmDelete({{ $categoria->id }}, '{{ $categoria->nome }}')"
                title="Excluir">
            <i class="fas fa-trash"></i>
        </button>
    </div>
</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Nenhuma categoria encontrada</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginação -->
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info">
                            Mostrando {{ $categorias->firstItem() }} a {{ $categorias->lastItem() }} 
                            de {{ $categorias->total() }} registros
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate">
                            {{ $categorias->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>

<script>
    function confirmDelete(id, nome) {
        Swal.fire({
            title: "Tem certeza?",
            html: `A categoria <strong>"${nome}"</strong> será deletada permanentemente!`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sim, deletar!",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("categorias-obra.destroy", "") }}/' + id;
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) return;
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.getAttribute('content');
                
                form.appendChild(methodInput);
                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Sucesso!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erro!',
            text: '{{ session('error') }}',
            showConfirmButton: true
        });
    @endif
</script>

@include('layouts.datatable')
@endsection