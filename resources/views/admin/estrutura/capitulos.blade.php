{{-- resources/views/admin/estrutura/capitulos.blade.php --}}
@extends('admin.layouts.admin')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-book"></i> Capítulos
            @if($modulo)
                <small class="text-muted">do módulo: {{ $modulo->nome }}</small>
            @endif
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.estrutura.capitulo.create', $modulo ? $modulo->id : '') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Capítulo
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    60d
                        <th style="width: 50px">Ordem</th>
                        <th>Nome</th>
                        <th>Módulo</th>
                        <th>Descrição</th>
                        <th>Actividades</th>
                        <th>Criado em</th>
                        <th style="width: 100px">Ações</th>
                    </thead>
                <tbody>
                    @forelse($capitulos as $capitulo)
                    <tr>
                        <td class="text-center">
                            <span class="badge badge-secondary">{{ $capitulo->ordem }}</span>
                        </td>
                        <td>
                            <strong>{{ $capitulo->nome }}</strong>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $capitulo->modulo->nome ?? '—' }}</span>
                        </td>
                        <td>{{ Str::limit($capitulo->descricao, 50) ?? '—' }}</td>
                        <td>
                            <span class="badge badge-success">{{ $capitulo->actividades()->count() }}</span>
                        </td>
                        <td>{{ $capitulo->created_at ? $capitulo->created_at->format('d/m/Y') : '—' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.estrutura.actividades', $capitulo->id) }}" class="btn btn-info" title="Ver actividades">
                                    <i class="fas fa-tasks"></i>
                                </a>
                                <a href="{{ route('admin.estrutura.capitulo.edit', $capitulo->id) }}" class="btn btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.estrutura.capitulo.destroy', $capitulo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Excluir" onclick="return confirm('Excluir este capítulo?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-book-open fa-3x mb-3 text-muted"></i>
                            <p>Nenhum capítulo cadastrado.</p>
                            <a href="{{ route('admin.estrutura.capitulo.create', $modulo ? $modulo->id : '') }}" class="btn btn-primary">Criar primeiro capítulo</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection