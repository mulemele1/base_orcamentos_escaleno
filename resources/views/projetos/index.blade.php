@extends('adminlte::page')

@section('title', 'Meus Projetos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <i class="fas fa-project-diagram text-primary mr-2"></i>
            Meus Projetos
        </h1>
        <a href="{{ route('projetos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Projeto
        </a>
    </div>
@stop

@section('content')
    @if($projetos->isEmpty())
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-folder-open fa-4x mb-3 text-muted"></i>
                <h5>Nenhum projeto cadastrado</h5>
                <p class="text-muted">Clique no botão abaixo para criar seu primeiro projeto</p>
                <a href="{{ route('projetos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Criar Projeto
                </a>
            </div>
        </div>
    @else
        <div class="row">
            @foreach($projetos as $projeto)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-building text-primary"></i>
                                    {{ Str::limit($projeto->nome, 30) }}
                                </h5>
                                <span class="badge badge-{{ $projeto->status == 'concluido' ? 'success' : ($projeto->status == 'orcamento' ? 'warning' : ($projeto->status == 'medicao' ? 'info' : 'secondary')) }}">
                                    {{ $projeto->status_formatado }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($projeto->cliente)
                                <p class="mb-1">
                                    <i class="fas fa-user text-muted"></i>
                                    <small>{{ $projeto->cliente }}</small>
                                </p>
                            @endif
                            @if($projeto->localizacao)
                                <p class="mb-2">
                                    <i class="fas fa-map-marker-alt text-muted"></i>
                                    <small>{{ Str::limit($projeto->localizacao, 40) }}</small>
                                </p>
                            @endif
                            
                            <div class="mt-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Progresso da Medição</small>
                                    <small class="text-primary">{{ $projeto->progresso_medicao }}%</small>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar progress-bar-striped bg-success" 
                                         style="width: {{ $projeto->progresso_medicao }}%"></div>
                                </div>
                            </div>
                            
                            @if($projeto->valor_total > 0)
                                <div class="mt-3 pt-2 border-top">
                                    <div class="text-right">
                                        <small class="text-muted">Valor Total</small>
                                        <h5 class="mb-0 text-success">
                                            MT {{ number_format($projeto->valor_total, 2, ',', '.') }}
                                        </h5>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer bg-white">
                            <div class="btn-group btn-group-sm w-100">
                                <a href="{{ route('projetos.show', $projeto) }}" class="btn btn-info" title="Ver detalhes">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('projetos.edit', $projeto) }}" class="btn btn-primary" title="Editar">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
@if($projeto->status == 'rascunho' || $projeto->status == 'medicao')
    <a href="{{ route('medicoes.dashboard', ['projeto' => $projeto->id]) }}" class="btn btn-success" title="Iniciar Medição">
        <i class="fas fa-ruler-combined"></i> Medir
    </a>
@endif
                                @if($projeto->status == 'orcamento' && $projeto->orcamentos->isEmpty())
                                    <a href="{{ route('orcamentos.gerar', $projeto) }}" class="btn btn-warning" title="Gerar Orçamento">
                                        <i class="fas fa-chart-line"></i> Orçar
                                    </a>
                                @endif
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-{{ $projeto->id }}" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Modal de confirmação de exclusão --}}
                <div class="modal fade" id="modal-delete-{{ $projeto->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirmar exclusão</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Tem certeza que deseja excluir o projeto <strong>{{ $projeto->nome }}</strong>?</p>
                                <p class="text-danger">Esta ação não poderá ser desfeita.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <form action="{{ route('projetos.destroy', $projeto) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-3">
            {{ $projetos->links() }}
        </div>
    @endif
@stop