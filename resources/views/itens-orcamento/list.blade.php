@extends('adminlte::page')

@section('title', 'Itens de Orçamento - ' . $categoria->nome)

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
        font-size: 0.85rem;
        white-space: nowrap;
    }
    .table td {
        background-color: #e3f2fd;
        color: #000;
        text-align: center;
        vertical-align: middle;
        font-size: 0.85rem;
    }
    .table .btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 30px;
        height: 30px;
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
    .resumo-card {
        background-color: #fff;
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .valor-total {
        font-size: 1.5em;
        font-weight: bold;
        color: #28a745;
    }
    .badge-item {
        font-size: 0.9em;
        padding: 5px 8px;
    }
    .table-responsive {
        overflow-x: auto;
    }
</style>

<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('itens-orcamento.list') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar para Categorias
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
    <h3 class="card-title">
        <i class="fas fa-list mr-2"></i>
        {{ $categoria->nome }} - Itens de Orçamento
        <span class="badge badge-info ml-2">{{ $itens->total() }} itens</span>
    </h3>
    <div class="card-tools">
        <a href="{{ route('itens-orcamento.export', $categoria->id) }}" 
           class="btn-sm bg-success mr-2"
           title="Exportar para Excel">
            <i class="fas fa-file-excel"></i> Exportar Excel
        </a>
        <a href="{{ route('itens-orcamento.create', ['categoria_id' => $categoria->id]) }}" 
           class="btn-sm bg-lightblue">
            <i class="fas fa-plus"></i> Novo Item
        </a>
    </div>
</div>
            <div class="card-body">
                <!-- Resumo -->
                <div class="resumo-card">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Total de Itens:</strong> {{ $itens->total() }}
                        </div>
                        <div class="col-md-6 text-right">
                            <strong>Subtotal da Categoria:</strong> 
                            <span class="valor-total">MT {{ number_format($subtotal, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Filtros Avançados -->
<div class="filter-box">
    <form method="GET" action="{{ route('itens-orcamento.list', ['categoria_id' => $categoria->id]) }}" class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label for="search">Pesquisar:</label>
                <input type="text" class="form-control" id="search" name="search" 
                       placeholder="Item, descrição ou comentários..." 
                       value="{{ request('search') }}">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="ordenar_por">Ordenar por:</label>
                <select class="form-control" id="ordenar_por" name="ordenar_por">
                    <option value="item" {{ request('ordenar_por') == 'item' ? 'selected' : '' }}>Item</option>
                    <option value="descricao" {{ request('ordenar_por') == 'descricao' ? 'selected' : '' }}>Descrição</option>
                    <option value="total" {{ request('ordenar_por') == 'total' ? 'selected' : '' }}>Total</option>
                    <option value="created_at" {{ request('ordenar_por') == 'created_at' ? 'selected' : '' }}>Data de Criação</option>
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="ordenar_dir">Direção:</label>
                <select class="form-control" id="ordenar_dir" name="ordenar_dir">
                    <option value="asc" {{ request('ordenar_dir') == 'asc' ? 'selected' : '' }}>Crescente</option>
                    <option value="desc" {{ request('ordenar_dir') == 'desc' ? 'selected' : '' }}>Decrescente</option>
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
    <div class="row mt-2">
        <div class="col-12">
            <a href="{{ route('itens-orcamento.list', ['categoria_id' => $categoria->id]) }}" 
               class="btn btn-sm btn-default">
                <i class="fas fa-times"></i> Limpar Filtros
            </a>
        </div>
    </div>
</div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Descrição</th>
                                <th>Un</th>
                                <th>NPI</th>
                                <th>Dimensões (C x L x H)</th>
                                <th>Elementar</th>
                                <th>Parcial</th>
                                <th>Perdas</th>
                                <th>Quant.</th>
                                <th>C. Fornec.</th>
                                <th>C. M.O.</th>
                                <th>Preço Unit.</th>
                                <th>Total</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($itens as $item)
                                <tr>
                                    <td><span class="badge bg-secondary badge-item">{{ $item->item }}</span></td>
                                    <td class="text-left">{{ $item->descricao }}</td>
                                    <td>{{ $item->unidade }}</td>
                                    <td>{{ $item->npi ?? '-' }}</td>
                                    <td>
                                        @if($item->comprimento || $item->largura || $item->altura)
                                            {{ $item->comprimento ?? '-' }} x 
                                            {{ $item->largura ?? '-' }} x 
                                            {{ $item->altura ?? '-' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $item->elementar ? number_format($item->elementar, 2, ',', '.') : '-' }}</td>
                                    <td>{{ $item->parcial ? number_format($item->parcial, 2, ',', '.') : '-' }}</td>
                                    <td>{{ $item->perdas != 1 ? $item->perdas : '-' }}</td>
                                    <td>{{ number_format($item->quantidade_proposta, 2, ',', '.') }}</td>
                                    <td>{{ $item->custo_fornecimento ? 'MT ' . number_format($item->custo_fornecimento, 2, ',', '.') : '-' }}</td>
                                    <td>{{ $item->custo_mao_obra ? 'MT ' . number_format($item->custo_mao_obra, 2, ',', '.') : '-' }}</td>
                                    <td>MT {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                                    <td class="font-weight-bold">MT {{ number_format($item->total, 2, ',', '.') }}</td>
                                    <td>
    <div class="btn-group">
        <a role="button" class="btn bg-lightblue" 
           href="{{ route('itens-orcamento.edit', $item->id) }}"
           title="Editar">
            <i class="fas fa-pencil-alt"></i>
        </a>
        <a role="button" class="btn bg-purple" 
           href="{{ route('itens-orcamento.duplicate', $item->id) }}"
           title="Duplicar"
           onclick="return confirm('Duplicar este item?')">
            <i class="fas fa-copy"></i>
        </a>
        <a role="button" class="btn bg-danger" 
           href="{{ route('pdf.item', $item->id) }}"
           target="_blank"
           title="PDF do Item">
            <i class="fas fa-file-pdf"></i>
        </a>
        <button type="button" class="btn bg-danger" 
                onclick="confirmDelete({{ $item->id }}, '{{ $item->item }}')"
                title="Excluir">
            <i class="fas fa-trash"></i>
        </button>
    </div>
</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="14" class="text-center">
                                        Nenhum item encontrado.
                                        <a href="{{ route('itens-orcamento.create', ['categoria_id' => $categoria->id]) }}">
                                            Clique aqui para adicionar o primeiro item.
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginação -->
                <div class="row mt-3">
                    <div class="col-sm-12 col-md-5">
                        <div class="dataTables_info">
                            Mostrando {{ $itens->firstItem() }} a {{ $itens->lastItem() }} 
                            de {{ $itens->total() }} registros
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <div class="dataTables_paginate">
                            {{ $itens->appends(request()->query())->links() }}
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
    function confirmDelete(id, item) {
        Swal.fire({
            title: "Tem certeza?",
            html: `O item <strong>"${item}"</strong> será deletado permanentemente!`,
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
                form.action = '{{ route("itens-orcamento.destroy", "") }}/' + id;
                
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