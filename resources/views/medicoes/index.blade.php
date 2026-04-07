@extends('adminlte::page')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-ruler"></i> Medições</h1>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Medições</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Projeto</th>
                        <th>Versão</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th class="text-right">Itens</th>
                        <th class="text-right">Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($medicoes as $medicao)
                        <tr>
                            <td><strong>{{ $medicao->codigo }}</strong></td>
                            <td>{{ $medicao->projeto->nome }}</td>
                            <td>v{{ $medicao->versao }}</td>
                            <td>{{ $medicao->created_at->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'rascunho' => 'secondary',
                                        'aprovado' => 'success',
                                        'revisto' => 'warning',
                                    ];
                                @endphp
                                <span class="badge badge-{{ $statusColors[$medicao->status] }}">
                                    {{ ucfirst($medicao->status) }}
                                </span>
                            </td>
                            <td class="text-right">{{ $medicao->itens->count() }}</td>
                            <td class="text-right">{{ number_format($medicao->total_medicao, 2, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('medicoes.show', $medicao->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('medicoes.edit', $medicao->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('medicoes.destroy', $medicao->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                                <p>Nenhuma medição cadastrada.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $medicoes->links() }}
        </div>
    </div>
@stop