@extends('adminlte::page')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-project-diagram mr-2"></i>{{ $projeto->nome }}</h1>
        <div>
            <a href="{{ route('projetos.edit', $projeto->id) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
            @if($orcamentoAtivo)
                <a href="{{ route('orcamentos.edit', $orcamentoAtivo->id) }}" class="btn btn-success">
                    <i class="fas fa-chart-line"></i> Editar Orçamento
                </a>
                <a href="{{ route('orcamentos.pdf', $orcamentoAtivo->id) }}" class="btn btn-danger">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#novaVersaoModal">
                    <i class="fas fa-copy"></i> Nova Versão
                </button>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalAplicarTemplate">
                    <i class="fas fa-copy"></i> Usar Template
                </button>
            @endif
        </div>
    </div>
@stop

@section('content')
    <!-- Cards de Resumo -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $projeto->data_inicio ? $projeto->data_inicio->format('d/m/Y') : '-' }}</h3>
                    <p>Data de Início</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $projeto->data_fim ? $projeto->data_fim->format('d/m/Y') : '-' }}</h3>
                    <p>Data de Fim</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>MT {{ number_format($projeto->valor_total, 2, ',', '.') }}</h3>
                    <p>Valor Total</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>v{{ $orcamentoAtivo ? $orcamentoAtivo->versao : 0 }}</h3>
                    <p>Versão Atual</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações do Projeto -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informações do Projeto</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Cliente:</strong> {{ $projeto->cliente }}</p>
                    <p><strong>Localização:</strong> {{ $projeto->localizacao }}</p>
                    <p><strong>Status:</strong> 
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
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Template:</strong> {{ $projeto->template ? $projeto->template->nome : 'Nenhum' }}</p>
                    <p><strong>IVA:</strong> {{ $projeto->configuracoes['iva'] ?? 16 }}%</p>
                    <p><strong>Contingência:</strong> {{ $projeto->configuracoes['contingencia'] ?? 8 }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Histórico de Orçamentos -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Histórico de Orçamentos</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    60d
                        <th>Versão</th>
                        <th>Código</th>
                        <th>Data Emissão</th>
                        <th>Status</th>
                        <th>Subtotal</th>
                        <th>Grand Total</th>
                        <th>Ações</th>
                    </thead>
                <tbody>
                    @forelse($projeto->orcamentos as $orcamento)
                    2d
                        <td>v{{ $orcamento->versao }}</td>
                        <td>{{ $orcamento->codigo }}</td>
                        <td>{{ $orcamento->data_emissao->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $statusColors = [
                                    'rascunho' => 'secondary',
                                    'em_analise' => 'info',
                                    'aprovado' => 'success',
                                    'rejeitado' => 'danger',
                                ];
                            @endphp
                            <span class="badge badge-{{ $statusColors[$orcamento->status] }}">
                                {{ $orcamento->status }}
                            </span>
                        </td>
                        <td class="text-right">MT {{ number_format($orcamento->subtotal, 2, ',', '.') }}</td>
                        <td class="text-right">MT {{ number_format($orcamento->grand_total, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('orcamentos.show', $orcamento->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('orcamentos.pdf', $orcamento->id) }}" class="btn btn-sm btn-danger">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-folder-open fa-3x mb-3 text-muted"></i>
                            <p>Nenhum orçamento associado a este projeto.</p>
                            <a href="{{ route('projetos.edit', $projeto->id) }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Criar Orçamento
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Nova Versão -->
    <div class="modal fade" id="novaVersaoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nova Versão do Orçamento</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja criar uma nova versão do orçamento?</p>
                    <p>A versão atual será mantida como histórico e uma nova versão será criada para edição.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a href="{{ route('projetos.nova-versao', $projeto->id) }}" class="btn btn-primary">
                        Criar Nova Versão
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Aplicar Template -->
    <div class="modal fade" id="modalAplicarTemplate" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-copy"></i> Aplicar Template</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="formAplicarTemplate" action="{{ route('templates.aplicar', '__TEMPLATE_ID__') }}" method="POST">
                        @csrf
                        <input type="hidden" name="projeto_id" value="{{ $projeto->id }}">
                        <div class="form-group">
                            <label for="template_id">Selecione um Template</label>
                            <select name="template_id" id="template_id" class="form-control" required>
                                <option value="">-- Selecione --</option>
                                @foreach($templates as $template)
                                    <option value="{{ $template->id }}">
                                        {{ $template->nome }} 
                                        @if($template->tipo_projeto) ({{ $template->tipo_projeto }}) @endif
                                        - {{ $template->user->name ?? 'Desconhecido' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            O template criará um novo orçamento para este projeto com todas as atividades e subatividades.
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="aplicarTemplate()">Aplicar Template</button>
                </div>
            </div>
        </div>
    </div>
@stop

<script>
function aplicarTemplate() {
    const templateId = document.getElementById('template_id').value;
    if (!templateId) {
        alert('Selecione um template');
        return;
    }
    
    const form = document.getElementById('formAplicarTemplate');
    const action = form.getAttribute('action').replace('__TEMPLATE_ID__', templateId);
    form.setAttribute('action', action);
    form.submit();
}
</script>