{{-- resources/views/admin/estrutura/grupos.blade.php --}}
@extends('admin.layouts.admin')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-layer-group"></i> Grupos
            @if($actividade)
                <small class="text-muted">da actividade: {{ $actividade->nome }}</small>
            @endif
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.estrutura.grupo.create', $actividade ? $actividade->id : '') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Grupo
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
                        <th>Actividade</th>
                        <th>Unidade Padrão</th>
                        <th>Componentes</th>
                        <th style="width: 150px">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grupos as $grupo)
                    <tr>
                        <td class="text-center">
                            <span class="badge badge-secondary">{{ $grupo->ordem }}</span>
                        </td>
                        <td>
                            <strong>{{ $grupo->nome }}</strong>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ Str::limit($grupo->actividade->nome, 40) }}</span>
                            <br><small class="text-muted">{{ $grupo->actividade->capitulo->modulo->nome ?? '' }}</small>
                        </td>
                        <td>
                            <span class="badge badge-success">{{ $grupo->unidade_padrao }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-warning">{{ $grupo->componentes()->count() }}</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                {{-- Ver componentes do grupo --}}
                                <a href="{{ route('admin.estrutura.componentes.por-grupo', $grupo->id) }}" class="btn btn-success" title="Ver componentes">
                                    <i class="fas fa-cube"></i>
                                </a>
                                
                                <a href="{{ route('admin.estrutura.grupo.edit', $grupo->id) }}" class="btn btn-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('admin.estrutura.grupo.destroy', $grupo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Excluir" onclick="return confirm('Excluir este grupo?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-layer-group fa-3x mb-3 text-muted"></i>
                            <p>Nenhum grupo cadastrado.</p>
                            <a href="{{ route('admin.estrutura.grupo.create', $actividade ? $actividade->id : '') }}" class="btn btn-primary">Criar primeiro grupo</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection