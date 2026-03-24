@extends('adminlte::page')

@section('title', 'Composição de Custos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-cubes mr-2"></i>Composição de Custos</h1>
    <a href="{{ route('composicoes.create', ['subatividade_id' => $subatividadeId]) }}" class="btn btn-success">
        <i class="fas fa-plus mr-1"></i> Adicionar Composição
    </a>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <form method="GET" action="{{ route('composicoes.index') }}" class="form-inline">
                        <div class="input-group mr-2" style="width: 500px;">
                            <select name="subatividade_id" class="form-control">
                                <option value="">Todas as Subatividades</option>
                                @foreach($subatividades as $sub)
                                    <option value="{{ $sub->id }}" {{ $subatividadeId == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->atividade->categoriaObra->codigo }}.{{ $sub->atividade->codigo }}.{{ $sub->codigo }} - {{ $sub->nome }}
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
                            <th>Subatividade</th>
                            <th>Material</th>
                            <th width="100">Quantidade</th>
                            <th width="80">Unidade</th>
                            <th width="120">Custo Unit. (MT)</th>
                            <th width="120">Custo Total (MT)</th>
                            <th width="100">Tipo</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($composicoes as $comp)
                        <tr>
                            <td>
                                <small class="text-muted">
                                    {{ $comp->subatividade->atividade->categoriaObra->codigo }}.
                                    {{ $comp->subatividade->atividade->codigo }}.
                                    {{ $comp->subatividade->codigo }}
                                </small>
                                <br>
                                <span class="badge bg-info">{{ Str::limit($comp->subatividade->nome, 30) }}</span>
                            </td>
                            <td>
                                <strong>{{ $comp->material->nome ?? 'N/A' }}</strong>
                                <br>
                                <small class="text-muted">Cód: {{ $comp->material->codigo ?? '-' }}</small>
                            </td>
                            <td class="text-right">{{ number_format($comp->quantidade, 3, ',', '.') }}</td>
                            <td>{{ $comp->unidade }}</td>
                            <td class="text-right">MT {{ number_format($comp->custo_unitario, 2, ',', '.') }}</td>
                            <td class="text-right"><strong>MT {{ number_format($comp->custo_total, 2, ',', '.') }}</strong></td>
                            <td>
                                @if($comp->tipo == 'material')
                                    <span class="badge bg-primary">Material</span>
                                @elseif($comp->tipo == 'mao_obra')
                                    <span class="badge bg-success">Mão de Obra</span>
                                @else
                                    <span class="badge bg-warning">Equipamento</span>
                                @endif
                                @if($comp->tipo == 'material' && $comp->mao_obra_percentual > 0)
                                    <br><small class="text-muted">Mão obra: {{ $comp->mao_obra_percentual }}%</small>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('composicoes.edit', $comp->id) }}" 
                                       class="btn btn-sm btn-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger" 
                                            onclick="confirmDelete({{ $comp->id }})"
                                            title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $comp->id }}" 
                                      action="{{ route('composicoes.destroy', $comp->id) }}" 
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
                                Nenhum material vinculado.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($composicoes->hasPages())
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $composicoes->appends(request()->query())->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if($subatividadeId)
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success">
                <h3 class="card-title">Resumo da Subatividade</h3>
            </div>
            <div class="card-body">
                @php
                    $sub = $subatividades->find($subatividadeId);
                @endphp
                @if($sub)
                <table class="table">
                    <tr>
                        <th>Subatividade:</th>
                        <td>{{ $sub->codigo }} - {{ $sub->nome }}</td>
                    </tr>
                    <tr>
                        <th>Quantidade Proposta:</th>
                        <td>{{ number_format($sub->quantidade_proposta, 2, ',', '.') }} {{ $sub->unidade }}</td>
                    </tr>
                    <tr>
                        <th>Total Materiais:</th>
                        <td>MT {{ number_format($sub->total_materiais, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total Mão Obra:</th>
                        <td>MT {{ number_format($sub->total_mao_obra, 2, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-light">
                        <th>Preço Unitário:</th>
                        <td><strong>MT {{ number_format($sub->preco_unitario, 2, ',', '.') }}</strong></td>
                    </tr>
                    <tr class="bg-success text-white">
                        <th>TOTAL:</th>
                        <td><strong>MT {{ number_format($sub->total, 2, ',', '.') }}</strong></td>
                    </tr>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@stop

@section('js')
<script>
function confirmDelete(id) {
    if (confirm('Tem certeza que deseja remover este material da composição?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@stop