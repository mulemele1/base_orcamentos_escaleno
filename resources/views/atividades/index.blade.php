@extends('adminlte::page')

@section('title', 'Atividades')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-tasks mr-2"></i>Atividades</h1>
    <a href="{{ route('atividades.create', ['categoria_id' => request('categoria_id')]) }}" class="btn btn-success">
        <i class="fas fa-plus mr-1"></i> Nova Atividade
    </a>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title">Lista de Atividades</h3>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('atividades.index') }}" class="form-inline justify-content-end">
                            <div class="form-group mr-2">
                                <select name="categoria_id" class="form-control" id="categoriaSelect" style="min-width: 250px;">
                                    <option value="">Todas as Categorias</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" 
                                            {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->codigo }} - {{ $categoria->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if(request('categoria_id'))
                                <a href="{{ route('atividades.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Limpar
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        60d
                            <th width="80">Código</th>
                            <th>Nome da Atividade</th>
                            <th width="100">Unidade</th>
                            <th width="80">NPI</th>
                            <th width="200">Categoria</th>
                            <th width="120">Subatividades</th>
                            <th width="80">Ordem</th>
                            <th width="250">Ações</th>
                        </thead>
                    <tbody>
                        @forelse($atividades as $atividade)
                        2d
                            <td><span class="badge bg-primary">{{ $atividade->codigo }}</span></td>
                            <td>{{ $atividade->nome }}</td>
                            <td>{{ $atividade->unidade ?: 'Vg' }}</td>
                            <td class="text-center">{{ $atividade->npi ?: 1 }}</td>
                            <td>
                                @if($atividade->categoriaObra)
                                    <span class="badge bg-info">
                                        {{ $atividade->categoriaObra->codigo }} - {{ $atividade->categoriaObra->nome }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Sem categoria</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success">{{ $atividade->subatividades_count }}</span>
                            </td>
                            <td class="text-center">{{ $atividade->ordem ?: '-' }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('atividades.show', $atividade->id) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('atividades.edit', $atividade->id) }}" 
                                       class="btn btn-sm btn-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('subatividades.index', ['atividade_id' => $atividade->id]) }}" 
                                       class="btn btn-sm btn-primary" 
                                       title="Ver subatividades">
                                        <i class="fas fa-list"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $atividade->id }}, '{{ addslashes($atividade->nome) }}')"
                                            title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $atividade->id }}" 
                                      action="{{ route('atividades.destroy', $atividade->id) }}" 
                                      method="POST" 
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle mr-1"></i>
                                Nenhuma atividade encontrada.
                                @if(request('categoria_id'))
                                    <a href="{{ route('atividades.index') }}" class="btn btn-sm btn-primary ml-2">
                                        <i class="fas fa-times"></i> Limpar filtro
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($atividades->hasPages())
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $atividades->appends(request()->query())->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@stop

@section('js')
<script>
function confirmDelete(id, nome) {
    if (confirm('Tem certeza que deseja excluir a atividade "' + nome + '"?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// FILTRO AUTOMÁTICO AO SELECIONAR
document.getElementById('categoriaSelect').addEventListener('change', function() {
    const url = new URL(window.location.href);
    if (this.value) {
        url.searchParams.set('categoria_id', this.value);
    } else {
        url.searchParams.delete('categoria_id');
    }
    window.location.href = url.toString();
});
</script>
@stop