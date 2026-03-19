@extends('adminlte::page')

@section('title', 'Subatividades')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-list-alt mr-2"></i>Subatividades</h1>
    <a href="{{ route('subatividades.create', ['atividade_id' => $atividadeId]) }}" class="btn btn-success">
        <i class="fas fa-plus mr-1"></i> Nova Subatividade
    </a>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <form method="GET" action="{{ route('subatividades.index') }}" class="form-inline">
                        <div class="input-group mr-2" style="width: 400px;">
                            <select name="atividade_id" class="form-control">
                                <option value="">Todas as Atividades</option>
                                @foreach($atividades as $atividade)
                                    <option value="{{ $atividade->id }}" {{ $atividadeId == $atividade->id ? 'selected' : '' }}>
                                        {{ $atividade->categoriaObra->codigo }}.{{ $atividade->codigo }} - {{ $atividade->nome }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th width="80">Código</th>
                            <th>Nome</th>
                            <th width="80">Unidade</th>
                            <th width="60">NPI</th>
                            <th width="100">C x L x H</th>
                            <th width="100">Elementar</th>
                            <th width="100">Parcial</th>
                            <th width="100">Perda %</th>
                            <th width="120">Quant. Proposta</th>
                            <th width="200">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subatividades as $sub)
                        <tr>
                            <td><span class="badge bg-primary">{{ $sub->codigo }}</span></td>
                            <td>{{ $sub->nome }}</td>
                            <td>{{ $sub->unidade }}</td>
                            <td class="text-center">{{ $sub->npi }}</td>
                            <td class="text-center">
                                @if($sub->comprimento)
                                    {{ $sub->comprimento }} x {{ $sub->largura ?? '-' }} x {{ $sub->altura ?? '-' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-right">{{ number_format($sub->elementar, 2, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($sub->parcial, 2, ',', '.') }}</td>
                            <td class="text-center">{{ $sub->perda_percentual }}%</td>
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
                                            onclick="confirmDelete({{ $sub->id }}, '{{ $sub->nome }}')"
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
                            <td colspan="11" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle mr-1"></i>
                                Nenhuma subatividade encontrada.
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
</script>
@stop