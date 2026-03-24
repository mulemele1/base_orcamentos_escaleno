@extends('adminlte::page')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-project-diagram mr-2"></i>Projetos</h1>
        <a href="{{ route('projetos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Projeto
        </a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Projetos</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    60d
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Cliente</th>
                        <th>Localização</th>
                        <th>Status</th>
                        <th>Valor Total</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($projetos as $projeto)
                    <tr>
                        <td>{{ $projeto->id }}</td>
                        <td>
                            <strong>{{ $projeto->nome }}</strong>
                            @if($projeto->template)
                                <br><small class="text-muted">Template: {{ $projeto->template->nome }}</small>
                            @endif
                        </td>
                        <td>{{ $projeto->cliente }}</td>
                        <td>{{ $projeto->localizacao }}</td>
                        <td>
                            @php
                                $statusColors = [
                                    'planeamento' => 'info',
                                    'em_andamento' => 'warning',
                                    'concluido' => 'success',
                                    'suspenso' => 'danger',
                                ];
                            @endphp
                            <span class="badge badge-{{ $statusColors[$projeto->status] }}">
                                {{ $projeto->status_formatado }}
                            </span>
                        </td>
                        <td class="text-right">
                            <strong>MT {{ number_format($projeto->valor_total, 2, ',', '.') }}</strong>
                        </td>
                        <td>
                            <a href="{{ route('projetos.show', $projeto->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('projetos.edit', $projeto->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('projetos.destroy', $projeto->id) }}" method="POST" class="d-inline">
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
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                            <p>Nenhum projeto cadastrado.</p>
                            <a href="{{ route('projetos.create') }}" class="btn btn-primary">Criar primeiro projeto</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $projetos->links() }}
        </div>
    </div>
@stop