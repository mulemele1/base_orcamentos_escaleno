{{-- resources/views/admin/estrutura/modulos.blade.php --}}
@extends('admin.layouts.admin')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-layer-group"></i> Módulos
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.estrutura.modulo.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Módulo
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px">Ordem</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Capítulos</th>
                        <th>Criado em</th>
                        <th style="width: 100px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($modulos as $modulo)
                    <tr>
                        <td class="text-center">
                            <span class="badge badge-secondary">{{ $modulo->ordem }}</span>
                        </td>
                        <td>
                            <strong>{{ $modulo->nome }}</strong>
                        </td>
                        <td>{{ Str::limit($modulo->descricao, 60) ?? '—' }}</td>
                        <td>
                            <span class="badge badge-info">{{ $modulo->capitulos()->count() }}</span>
                        </td>
                        <td>{{ $modulo->created_at ? $modulo->created_at->format('d/m/Y') : '—' }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.estrutura.capitulos', $modulo->id) }}" class="btn btn-info" title="Ver capítulos">
                                    <i class="fas fa-book"></i>
                                </a>
                                <a href="{{ route('admin.estrutura.modulo.edit', $modulo->id) }}" class="btn btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.estrutura.modulo.destroy', $modulo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Excluir" onclick="return confirm('Excluir este módulo?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                            <p>Nenhum módulo cadastrado.</p>
                            <a href="{{ route('admin.estrutura.modulo.create') }}" class="btn btn-primary">Criar primeiro módulo</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection