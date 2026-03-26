@extends('adminlte::page')

@section('title', 'Actividades')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-list-alt mr-2"></i>Actividades</h1>
    <a href="{{ route('subatividades.create', ['atividade_id' => request('atividade_id')]) }}" class="btn btn-success">
        <i class="fas fa-plus mr-1"></i> Nova Actividade
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
                        <h3 class="card-title">
                            @if(request('atividade_id') && isset($atividadeSelecionada))
                                <span class="badge bg-info">
                                    Actividade: {{ $atividadeSelecionada->categoriaObra->codigo }}.{{ $atividadeSelecionada->codigo }} - {{ $atividadeSelecionada->nome }}
                                </span>
                            @else
                                Lista de Actividades
                            @endif
                        </h3>
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('subatividades.index') }}" class="form-inline justify-content-end">
                            <div class="form-group mr-2">
                                <select name="atividade_id" class="form-control" id="atividadeSelect" style="min-width: 300px;">
                                    <option value="">Todas as Atividades</option>
                                    @foreach($atividades as $atividade)
                                        <option value="{{ $atividade->id }}" {{ request('atividade_id') == $atividade->id ? 'selected' : '' }}>
                                            {{ $atividade->categoriaObra->codigo }}.{{ $atividade->codigo }} - {{ $atividade->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if(request('atividade_id'))
                                <a href="{{ route('subatividades.index') }}" class="btn btn-secondary">
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
                            <th>Nome</th>
                            <th width="80">Unidade</th>
                            <th width="120">Quant. Proposta</th>
                            <th width="220">Ações</th>
                        </thead>
                    <tbody>
                        @forelse($subatividades as $sub)
                        <tr>
                            <td><span class="badge bg-primary">{{ $sub->codigo }}</span></td>
                            <td>{{ Str::limit($sub->nome, 50) }}</td>
                            <td>{{ $sub->unidade }}</td>
                            
                            <td class="text-right"><strong>{{ number_format($sub->quantidade_proposta, 2, ',', '.') }}</strong></td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('subatividades.show', $sub->id) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('subatividades.edit', $sub->id) }}" 
                                       class="btn btn-sm btn-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('composicoes.index', ['subatividade_id' => $sub->id]) }}" 
                                       class="btn btn-sm btn-primary" 
                                       title="Composição de custos">
                                        <i class="fas fa-cubes"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $sub->id }}, '{{ addslashes($sub->nome) }}')"
                                            title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $sub->id }}" 
                                      action="{{ route('subatividades.destroy', $sub->id) }}" 
                                      method="POST" 
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle mr-1"></i>
                                Nenhuma subatividade encontrada.
                                @if(request('atividade_id'))
                                    <a href="{{ route('subatividades.index') }}" class="btn btn-sm btn-primary ml-2">
                                        <i class="fas fa-times"></i> Limpar filtro
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($subatividades->hasPages())
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $subatividades->appends(request()->query())->links() }}
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
    if (confirm('Tem certeza que deseja excluir a subatividade "' + nome + '"?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// FILTRO AUTOMÁTICO AO SELECIONAR
document.getElementById('atividadeSelect').addEventListener('change', function() {
    const url = new URL(window.location.href);
    if (this.value) {
        url.searchParams.set('atividade_id', this.value);
    } else {
        url.searchParams.delete('atividade_id');
    }
    window.location.href = url.toString();
});
</script>
@stop