{{-- resources/views/admin/estrutura/actividades.blade.php --}}
@extends('admin.layouts.admin')

@section('admin-content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-tasks"></i> Actividades
            @if($capitulo)
                <small class="text-muted">do capítulo: {{ $capitulo->nome }}</small>
            @endif
        </h3>
        <div class="card-tools">
            <a href="{{ route('admin.estrutura.actividade.create', $capitulo ? $capitulo->id : '') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nova Actividade
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
                        <th>Capítulo</th>
                        <th>Descrição</th>
                        <th>Grupos</th>
                        <th>Componentes</th>
                        <th style="width: 150px">Ações</th>
                    </thead>
                <tbody>
                    @forelse($actividades as $actividade)
                    60d
                        <td class="text-center">
                            <span class="badge badge-secondary">{{ $actividade->ordem }}</span>
                        </td>
                        <td>
                            <strong>{{ $actividade->nome }}</strong>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $actividade->capitulo->nome ?? '—' }}</span>
                            <br><small class="text-muted">{{ $actividade->capitulo->modulo->nome ?? '' }}</small>
                        </td>
                        <td>{{ Str::limit($actividade->descricao, 60) }}</td>
                        <td class="text-center">
                            <span class="badge badge-warning">{{ $actividade->grupos()->count() }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-success">{{ $actividade->componentes()->count() + $actividade->grupos->sum(fn($g) => $g->componentes->count()) }}</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                {{-- Ver grupos (se houver) --}}
                                @if($actividade->grupos()->count() > 0)
                                    <a href="{{ route('admin.estrutura.grupos', $actividade->id) }}" class="btn btn-warning" title="Ver grupos">
                                        <i class="fas fa-layer-group"></i>
                                    </a>
                                @endif
                                
                                {{-- Ver componentes diretos (sem grupo) --}}
                                <a href="{{ route('admin.estrutura.componentes.por-actividade', $actividade->id) }}" class="btn btn-success" title="Ver componentes">
                                    <i class="fas fa-cube"></i>
                                </a>
                                
                                <a href="{{ route('admin.estrutura.actividade.edit', $actividade->id) }}" class="btn btn-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('admin.estrutura.actividade.destroy', $actividade->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Excluir" onclick="return confirm('Excluir esta actividade?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-tasks fa-3x mb-3 text-muted"></i>
                            <p>Nenhuma actividade cadastrada.</p>
                            <a href="{{ route('admin.estrutura.actividade.create', $capitulo ? $capitulo->id : '') }}" class="btn btn-primary">Criar primeira actividade</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection