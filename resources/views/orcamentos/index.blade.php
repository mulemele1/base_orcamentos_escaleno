@extends('adminlte::page')

@section('title', 'Orçamentos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-file-invoice-dollar mr-2"></i>Orçamentos</h1>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Orçamentos</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    60d
                        <th>Código</th>
                        <th>Projeto</th>
                        <th>Cliente</th>
                        <th>Data Emissão</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orcamentos as $orcamento)
                    <tr>
                        <td>{{ $orcamento->codigo }}</td>
                        <td>{{ $orcamento->nome_projeto }}</td>
                        <td>{{ $orcamento->cliente }}</td>
                        <td>{{ $orcamento->data_emissao->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge badge-secondary">{{ $orcamento->status }}</span>
                        </td>
                        <td class="text-right">MT {{ number_format($orcamento->grand_total, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('orcamentos.show', $orcamento->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('orcamentos.pdf', $orcamento->id) }}" class="btn btn-sm btn-danger">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                            <p>Nenhum orçamento cadastrado.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $orcamentos->links() }}
        </div>
    </div>
@stop