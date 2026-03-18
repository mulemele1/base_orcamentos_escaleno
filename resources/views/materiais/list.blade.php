@extends('adminlte::page')

@section('title', 'Lista de Materiais')

@section('content')
<style>
    /* Estiliza o fundo da tabela */
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

    /* Botões dentro da tabela */
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

    .table-responsive {
        overflow-x: auto;
    }

    .badge-categoria {
        font-size: 0.9em;
        padding: 5px 10px;
    }

    .valor-destaque {
        font-weight: bold;
        color: #28a745;
    }

    /* Cards de estatísticas */
    .small-box {
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .filter-box {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
</style>

<!-- Cards de Estatísticas -->
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total'] }}</h3>
                <p>Total de Materiais</p>
            </div>
            <div class="icon">
                <i class="fas fa-boxes"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['total_categorias'] }}</h3>
                <p>Categorias</p>
            </div>
            <div class="icon">
                <i class="fas fa-tags"></i>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>MT {{ number_format($stats['valor_medio'], 2, ',', '.') }}</h3>
                <p>Valor Médio</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-boxes mr-2"></i>Lista de Materiais
                </h3>
                <div class="card-tools">
                    <a href="{{ route('materiais.create') }}" class="btn-sm bg-lightblue">
                        <i class="fas fa-plus"></i> Adicionar Material
                    </a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <!-- Filtros -->
                <div class="filter-box">
                    <form method="GET" action="{{ route('materiais.list') }}" class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="search">Pesquisar:</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       placeholder="Código, nome ou categoria..." 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="categoria">Categoria:</label>
                                <select class="form-control" id="categoria" name="categoria">
                                    <option value="">Todas as categorias</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria }}" 
                                            {{ request('categoria') == $categoria ? 'selected' : '' }}>
                                            {{ $categoria }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ordenar_por">Ordenar por:</label>
                                <select class="form-control" id="ordenar_por" name="ordenar_por">
                                    <option value="categoria" {{ request('ordenar_por') == 'categoria' ? 'selected' : '' }}>Categoria</option>
                                    <option value="nome" {{ request('ordenar_por') == 'nome' ? 'selected' : '' }}>Nome</option>
                                    <option value="codigo" {{ request('ordenar_por') == 'codigo' ? 'selected' : '' }}>Código</option>
                                    <option value="valor_compra" {{ request('ordenar_por') == 'valor_compra' ? 'selected' : '' }}>Valor</option>
                                </select>
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
                    </form>
                </div>

                <div class="table-responsive">
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 10%">Código</th>
                                <th style="width: 25%">Nome</th>
                                <th style="width: 8%">Unidade</th>
                                <th style="width: 12%">Valor Compra</th>
                                <th style="width: 10%">Rendimento</th>
                                <th style="width: 12%">Custo/m²*</th>
                                <th style="width: 10%">Categoria</th>
                                <th style="width: 8%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($materiais as $material)
                                <tr>
                                    <td>{{ $material->id }}</td>
                                    <td><span class="badge bg-secondary">{{ $material->codigo }}</span></td>
                                    <td class="text-left">{{ $material->nome }}</td>
                                    <td>{{ $material->unidade }}</td>
                                    <td class="valor-destaque">{{ $material->valor_compra_formatado }}</td>
                                    <td>{{ $material->rendimento_formatado }}</td>
                                    <td>
                                        @if($material->rendimento > 0)
                                            MT {{ number_format($material->valor_compra / $material->rendimento, 2, ',', '.') }}
                                            <small class="text-muted">/{{ $material->unidade }}</small>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info badge-categoria">{{ $material->categoria }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a role="button" class="btn bg-lightblue" 
                                               href="{{ route('materiais.edit', $material->id) }}"
                                               title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="btn bg-danger" 
                                                    onclick="confirmDelete({{ $material->id }}, '{{ $material->nome }}')"
                                                    title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- /.table-responsive -->
                
                <!-- Paginação -->
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info" role="status">
                            Mostrando {{ $materiais->firstItem() }} a {{ $materiais->lastItem() }} 
                            de {{ $materiais->total() }} registros
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate paging_simple_numbers">
                            {{ $materiais->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.4/dist/sweetalert2.all.min.js"></script>

<script>
    function confirmDelete(id, nome) {
        Swal.fire({
            title: "Tem certeza?",
            html: `O material <strong>"${nome}"</strong> será deletado permanentemente!`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sim, deletar!",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                // Criar formulário de exclusão
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("materiais.destroy", "") }}/' + id;
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    console.error('CSRF token not found');
                    return;
                }
                
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

    // Mostrar mensagens de sucesso/erro do session
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