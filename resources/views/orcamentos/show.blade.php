@extends('adminlte::page')

@section('title', 'Orçamento ' . $orcamento->codigo)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-file-invoice-dollar mr-2"></i>Orçamento: {{ $orcamento->codigo }}</h1>
        
<div>
    <form action="{{ route('orcamentos.calcular', $orcamento->id) }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-success">
            <i class="fas fa-calculator"></i> Calcular Orçamento
        </button>
    </form>
    <a href="{{ route('orcamentos.pdf', $orcamento->id) }}" class="btn btn-danger">
        <i class="fas fa-file-pdf"></i> PDF
    </a>
    <!-- BOTÃO SALVAR COMO TEMPLATE -->
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalSalvarTemplate">
        <i class="fas fa-save"></i> Salvar como Template
    </button>
            <a href="{{ route('projetos.show', $orcamento->projeto_id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar ao Projeto
            </a>
</div>
    </div>


    <!-- Modal Salvar como Template -->
<div class="modal fade" id="modalSalvarTemplate" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-save"></i> Salvar como Template</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="{{ route('templates.store') }}" method="POST">
                @csrf
                <input type="hidden" name="orcamento_id" value="{{ $orcamento->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nome">Nome do Template *</label>
                        <input type="text" name="nome" id="nome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="tipo_projeto">Tipo de Projeto</label>
                        <select name="tipo_projeto" id="tipo_projeto" class="form-control">
                            <option value="">-- Selecione --</option>
                            <option value="residencial">Residencial</option>
                            <option value="comercial">Comercial</option>
                            <option value="industrial">Industrial</option>
                            <option value="institucional">Institucional</option>
                            <option value="infraestrutura">Infraestrutura</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea name="descricao" id="descricao" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="publico" id="publico" class="form-check-input" value="1">
                        <label class="form-check-label" for="publico">
                            <i class="fas fa-globe"></i> Tornar público (outros usuários poderão usar)
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Template</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('content')
<style>
    /* ============================================
       ESTILOS DO ACORDEÃO
    ============================================ */
    
    .accordion-categoria {
        margin-bottom: 16px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .accordion-categoria:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    }
    
    .categoria-header {
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        color: white;
        padding: 16px 20px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .categoria-header:hover {
        background: linear-gradient(135deg, #1e2a36 0%, #2980b9 100%);
    }
    
    .categoria-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .categoria-header .badge-categoria {
        background: rgba(255,255,255,0.2);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
    }
    
    .categoria-header .total {
        font-size: 1.1rem;
        font-weight: bold;
    }
    
    .categoria-header i {
        transition: transform 0.3s ease;
    }
    
    .categoria-header.active i {
        transform: rotate(90deg);
    }
    
    .categoria-content {
        display: none;
        background: #fff;
        border: 1px solid #e0e0e0;
        border-top: none;
    }
    
    .categoria-content.show {
        display: block;
    }
    
    /* Atividades */
    .atividade-item {
        border-bottom: 1px solid #e0e0e0;
    }
    
    .atividade-item:last-child {
        border-bottom: none;
    }
    
    .atividade-header {
        background: #f8f9fa;
        padding: 12px 20px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    
    .atividade-header:hover {
        background: #e9ecef;
        border-left-color: #3498db;
    }
    
    .atividade-header h4 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    
    .atividade-header .badge-atividade {
        background: #e9ecef;
        color: #2c3e50;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
    }
    
    .atividade-header .total-atividade {
        font-weight: 600;
        color: #27ae60;
    }
    
    .atividade-header i {
        transition: transform 0.3s ease;
        color: #7f8c8d;
    }
    
    .atividade-header.active i {
        transform: rotate(90deg);
    }
    
    .atividade-content {
        display: none;
        padding: 15px 20px;
        background: #fff;
    }
    
    .atividade-content.show {
        display: block;
    }
    
    /* Subatividades */
    .subatividade-card {
        background: #ffffff;
        border: 1px solid #e8eef2;
        border-radius: 10px;
        margin-bottom: 12px;
        padding: 12px 15px;
        transition: all 0.2s ease;
        position: relative;
    }
    
    .subatividade-card:hover {
        border-color: #cbd5e0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }
    
    .subatividade-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px dashed #e2e8f0;
    }
    
    .subatividade-info {
        flex: 1;
    }
    
    .subatividade-codigo {
        display: inline-block;
        background: #e8f0fe;
        color: #1e40af;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 12px;
        margin-right: 8px;
    }
    
    .subatividade-nome {
        font-weight: 600;
        color: #1a202c;
        font-size: 0.9rem;
    }
    
    .subatividade-detalhes {
        font-size: 0.75rem;
        color: #64748b;
        margin-top: 4px;
    }
    
    .subatividade-valores {
        text-align: right;
    }
    
    .subatividade-total {
        font-size: 1rem;
        font-weight: 700;
        color: #059669;
    }
    
    .subatividade-unitario {
        font-size: 0.7rem;
        color: #6b7280;
    }
    
    .subatividade-actions {
        position: absolute;
        top: 12px;
        right: 12px;
        display: none;
        gap: 5px;
    }
    
    .subatividade-card:hover .subatividade-actions {
        display: flex;
    }
    
    .btn-icon-sm {
        width: 28px;
        height: 28px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
    }
    
    /* Tabela de Materiais */
    .materiais-table {
        margin-top: 12px;
    }
    
    .materiais-table table {
        width: 100%;
        font-size: 0.75rem;
        border-collapse: collapse;
        background: #fafcff;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .materiais-table th {
        background: #f1f5f9;
        padding: 8px 10px;
        text-align: left;
        font-weight: 600;
        color: #334155;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .materiais-table td {
        padding: 8px 10px;
        border-bottom: 1px solid #eef2f6;
        color: #1e293b;
    }
    
    .badge-material {
        background: #dbeafe;
        color: #1e40af;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.65rem;
        font-weight: 600;
    }
    
    .badge-mao-obra {
        background: #fef3c7;
        color: #b45309;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.65rem;
        font-weight: 600;
    }
    
    .badge-servico {
        background: #e0e7ff;
        color: #3730a3;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 0.65rem;
        font-weight: 600;
    }
    
    .info-box {
        transition: all 0.3s ease;
        border-radius: 12px;
    }
    
    .info-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    
    .btn-expand-all {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #495057;
        transition: all 0.2s;
    }
    
    .btn-expand-all:hover {
        background: #e9ecef;
        transform: translateY(-1px);
    }
    
    .editable {
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .editable:hover {
        background: rgba(52, 152, 219, 0.1);
        border-radius: 4px;
        padding: 2px 4px;
    }
    
    .edit-input {
        border: 1px solid #3498db;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 0.9rem;
        width: auto;
        min-width: 150px;
    }
    
    .edit-buttons {
        display: inline-flex;
        gap: 5px;
        margin-left: 8px;
    }
</style>

<!-- Informações Gerais -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Informações Gerais</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <p><strong>Código:</strong> {{ $orcamento->codigo }}</p>
                        <p><strong>Versão:</strong> v{{ $orcamento->versao }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Projeto:</strong> {{ $orcamento->nome_projeto }}</p>
                        <p><strong>Cliente:</strong> {{ $orcamento->cliente }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>Localização:</strong> {{ $orcamento->localizacao }}</p>
                        <p><strong>Data Emissão:</strong> {{ $orcamento->data_emissao->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-3">
                        <p><strong>IVA:</strong> {{ $orcamento->iva_percentual }}%</p>
                        <p><strong>Contingência:</strong> {{ $orcamento->contingencia_percentual }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cards de Resumo Financeiro -->
<div class="row">
    <div class="col-md-3">
        <div class="info-box bg-info">
            <span class="info-box-icon"><i class="fas fa-chart-line"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Subtotal</span>
                <span class="info-box-number">MT {{ number_format($orcamento->subtotal, 2, ',', '.') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box bg-warning">
            <span class="info-box-icon"><i class="fas fa-percent"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">IVA ({{ $orcamento->iva_percentual }}%)</span>
                <span class="info-box-number">MT {{ number_format($orcamento->valor_iva, 2, ',', '.') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box bg-warning">
            <span class="info-box-icon"><i class="fas fa-shield-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Contingência ({{ $orcamento->contingencia_percentual }}%)</span>
                <span class="info-box-number">MT {{ number_format($orcamento->valor_contingencia, 2, ',', '.') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="fas fa-calculator"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">GRAND TOTAL</span>
                <span class="info-box-number">MT {{ number_format($orcamento->grand_total, 2, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Botões de Ação Rápida -->
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddCategoria">
                        <i class="fas fa-plus-circle"></i> Adicionar Categoria
                    </button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAddAtividade">
                        <i class="fas fa-plus-circle"></i> Adicionar Atividade
                    </button>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalAddSubatividade">
                        <i class="fas fa-plus-circle"></i> Adicionar Subatividade
                    </button>
                    <button type="button" class="btn btn-info" id="expandAllBtn">
                        <i class="fas fa-expand-alt"></i> Expandir Tudo
                    </button>
                    <button type="button" class="btn btn-secondary" id="collapseAllBtn">
                        <i class="fas fa-compress-alt"></i> Recolher Tudo
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estrutura do Orçamento em Acordeão -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tasks mr-2"></i>Estrutura do Orçamento
                </h3>
            </div>
            <div class="card-body">
                @if(empty($dadosHierarquicos))
                    <div class="alert alert-info text-center py-5">
                        <i class="fas fa-info-circle fa-3x mb-3"></i>
                        <h5>Nenhuma atividade adicionada</h5>
                        <p>Clique nos botões acima para adicionar categorias, atividades ou subatividades.</p>
                    </div>
                @else
                    <!-- Acordeão de Categorias -->
                    @foreach($dadosHierarquicos as $categoriaId => $data)
                        @php 
                            $categoria = $data['categoria'];
                            $totalCategoria = collect($data['atividades'])->sum('subtotal');
                        @endphp
                        <div class="accordion-categoria" data-categoria-id="{{ $categoriaId }}">
                            <div class="categoria-header">
                                <h3>
                                    <i class="fas fa-chevron-right"></i>
                                    <span class="badge-categoria">{{ $categoria->codigo }}</span>
                                    <span class="categoria-nome editable" data-id="{{ $categoria->id }}" data-tipo="categoria" data-campo="nome">{{ $categoria->nome }}</span>
                                </h3>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="total">
                                        <span class="badge bg-success">MT {{ number_format($totalCategoria, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light" onclick="editarInline(this, 'categoria', {{ $categoria->id }}, 'nome')" title="Editar Nome">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light" onclick="adicionarAtividadeModal({{ $categoria->id }})" title="Adicionar Atividade">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="categoria-content">
                                @foreach($data['atividades'] as $atividade)
                                    @php $totalAtividade = $atividade->subtotal ?: $atividade->total_calculado; @endphp
                                    <div class="atividade-item">
                                        <div class="atividade-header">
                                            <h4>
                                                <i class="fas fa-chevron-right"></i>
                                                <span class="badge-atividade">{{ $atividade->codigo }}</span>
                                                <span class="atividade-nome editable" data-id="{{ $atividade->id }}" data-tipo="atividade" data-campo="nome">{{ $atividade->nome }}</span>
                                                <span class="badge bg-secondary">{{ $atividade->unidade }}</span>
                                            </h4>
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="total-atividade">MT {{ number_format($totalAtividade, 2, ',', '.') }}</span>
                                                <span class="badge bg-secondary ml-2">{{ $atividade->subatividades->count() }} itens</span>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-light" onclick="editarInline(this, 'atividade', {{ $atividade->id }}, 'nome')" title="Editar Nome">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-light" onclick="adicionarSubatividadeModal({{ $atividade->id }})" title="Adicionar Subatividade">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="removerAtividade({{ $orcamento->id }}, {{ $atividade->id }})" title="Remover do Orçamento">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="atividade-content">
                                            @foreach($atividade->subatividades as $subatividade)
                                                <div class="subatividade-card">
                                                    <div class="subatividade-header">
                                                        <div class="subatividade-info">
                                                            <span class="subatividade-codigo">{{ $subatividade->codigo }}</span>
                                                            <span class="subatividade-nome editable" data-id="{{ $subatividade->id }}" data-tipo="subatividade" data-campo="nome">{{ $subatividade->nome }}</span>
                                                            <div class="subatividade-detalhes">
                                                                Quantidade: <span class="editable" data-id="{{ $subatividade->id }}" data-tipo="subatividade" data-campo="quantidade_proposta">{{ number_format($subatividade->quantidade_proposta, 2, ',', '.') }}</span> {{ $subatividade->unidade }}
                                                                @if($subatividade->perda_percentual > 0)
                                                                    <span class="text-warning ml-2">(+<span class="editable" data-id="{{ $subatividade->id }}" data-tipo="subatividade" data-campo="perda_percentual">{{ $subatividade->perda_percentual }}</span>% perda)</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="subatividade-valores">
                                                            <div class="subatividade-total">MT {{ number_format($subatividade->total, 2, ',', '.') }}</div>
                                                            <div class="subatividade-unitario">Preço unitário: MT {{ number_format($subatividade->preco_unitario, 2, ',', '.') }}</div>
                                                        </div>
                                                    </div>
                                                    <div class="subatividade-actions">
                                                        <button type="button" class="btn btn-sm btn-warning btn-icon-sm" onclick="editarInline(this, 'subatividade', {{ $subatividade->id }}, 'nome')" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger btn-icon-sm" onclick="excluirSubatividade({{ $subatividade->id }})" title="Excluir">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    
                                                    @if($subatividade->composicaoCustos->count() > 0)
                                                        <div class="materiais-table">
                                                            <table class="table table-sm">
                                                                <thead>
                                                                    60d
                                                                        <th>Material / Insumo</th>
                                                                        <th width="80">Quantidade</th>
                                                                        <th width="60">Unidade</th>
                                                                        <th width="100">Custo Unit.</th>
                                                                        <th width="120">Custo Total</th>
                                                                        <th width="100">Tipo</th>
                                                                        <th width="60">Ação</th>
                                                                    </thead>
                                                                <tbody>
                                                                    @foreach($subatividade->composicaoCustos as $comp)
                                                                        @php
                                                                            $tipoClass = $comp->tipo == 'material' ? 'badge-material' : ($comp->tipo == 'mao_obra' ? 'badge-mao-obra' : 'badge-servico');
                                                                        @endphp
                                                                         <tr>
                                                                             <td>
                                                                                <strong>{{ $comp->material->nome ?? 'Mão de Obra' }}</strong>
                                                                                @if($comp->material)
                                                                                    <br><small class="text-muted">Cód: {{ $comp->material->codigo }}</small>
                                                                                @endif
                                                                              </td>
                                                                            <td class="text-right editable" data-id="{{ $comp->id }}" data-tipo="composicao" data-campo="quantidade">{{ number_format($comp->quantidade, 3, ',', '.') }}</td>
                                                                            <td class="text-center">{{ $comp->unidade }}</td>
                                                                            <td class="text-right editable" data-id="{{ $comp->id }}" data-tipo="composicao" data-campo="custo_unitario">MT {{ number_format($comp->custo_unitario, 2, ',', '.') }}</td>
                                                                            <td class="text-right text-primary">MT {{ number_format($comp->custo_total, 2, ',', '.') }}</td>
                                                                            <td class="text-center">
                                                                                <span class="{{ $tipoClass }}">{{ ucfirst(str_replace('_', ' ', $comp->tipo)) }}</span>
                                                                             </td>
                                                                            <td class="text-center">
                                                                                <button type="button" class="btn btn-xs btn-danger" onclick="removerMaterial({{ $comp->id }})">
                                                                                    <i class="fas fa-trash"></i>
                                                                                </button>
                                                                             </td>
                                                                          </tr>
                                                                    @endforeach
                                                                </tbody>
                                                                <tfoot>
                                                                     <tr class="bg-light">
                                                                        <td colspan="4" class="text-right"><strong>Total da Subatividade</strong></td>
                                                                        <td class="text-right"><strong>MT {{ number_format($subatividade->total, 2, ',', '.') }}</strong></td>
                                                                        <td colspan="2"></td>
                                                                      </tr>
                                                                </tfoot>
                                                             </table>
                                                        </div>
                                                    @else
                                                        <div class="alert alert-warning mb-0 py-2">
                                                            <i class="fas fa-exclamation-triangle mr-1"></i> 
                                                            Nenhum material ou insumo cadastrado.
                                                            <button type="button" class="btn btn-xs btn-primary ml-2" onclick="adicionarMaterialModal({{ $subatividade->id }})">
                                                                <i class="fas fa-plus"></i> Adicionar Material
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modais para Adicionar -->
<div class="modal fade" id="modalAddCategoria" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Adicionar Nova Categoria</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formAddCategoria">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cat_codigo">Código *</label>
                        <input type="text" name="codigo" id="cat_codigo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="cat_nome">Nome da Categoria *</label>
                        <input type="text" name="nome" id="cat_nome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="cat_descricao">Descrição</label>
                        <textarea name="descricao" id="cat_descricao" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cat_ordem">Ordem</label>
                        <input type="number" name="ordem" id="cat_ordem" class="form-control" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Categoria</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddAtividade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Adicionar Nova Atividade</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formAddAtividade">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ativ_categoria_id">Categoria *</label>
                        <select name="categoria_obra_id" id="ativ_categoria_id" class="form-control" required>
                            <option value="">Selecione...</option>
                            @foreach($todasCategorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->codigo }} - {{ $cat->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ativ_codigo">Código *</label>
                        <input type="text" name="codigo" id="ativ_codigo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ativ_nome">Nome da Atividade *</label>
                        <input type="text" name="nome" id="ativ_nome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ativ_unidade">Unidade</label>
                        <input type="text" name="unidade" id="ativ_unidade" class="form-control" value="Vg">
                    </div>
                    <div class="form-group">
                        <label for="ativ_npi">NPI</label>
                        <input type="number" name="npi" id="ativ_npi" class="form-control" value="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Atividade</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddSubatividade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Adicionar Nova Subatividade</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formAddSubatividade">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="sub_atividade_id">Atividade *</label>
                        <select name="atividade_id" id="sub_atividade_id" class="form-control" required>
                            <option value="">Selecione...</option>
                            @foreach($todasAtividades as $atv)
                                <option value="{{ $atv->id }}">{{ $atv->categoriaObra->codigo }}.{{ $atv->codigo }} - {{ $atv->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sub_codigo">Código *</label>
                        <input type="text" name="codigo" id="sub_codigo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="sub_nome">Nome *</label>
                        <input type="text" name="nome" id="sub_nome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="sub_unidade">Unidade</label>
                        <input type="text" name="unidade" id="sub_unidade" class="form-control" value="Vg">
                    </div>
                    <div class="form-group">
                        <label for="sub_quantidade">Quantidade Proposta</label>
                        <input type="number" name="quantidade_proposta" id="sub_quantidade" class="form-control" step="0.01" value="1">
                    </div>
                    <div class="form-group">
                        <label for="sub_perda">Perda (%)</label>
                        <input type="number" name="perda_percentual" id="sub_perda" class="form-control" step="0.1" value="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Subatividade</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddMaterial" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Adicionar Material</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formAddMaterial">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="subatividade_id" id="mat_subatividade_id">
                    <div class="form-group">
                        <label for="mat_material_id">Material *</label>
                        <select name="material_id" id="mat_material_id" class="form-control" required>
                            <option value="">Selecione...</option>
                            @foreach($materiais ?? [] as $mat)
                                <option value="{{ $mat->id }}">{{ $mat->codigo }} - {{ $mat->nome }} ({{ $mat->unidade }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mat_quantidade">Quantidade *</label>
                        <input type="number" name="quantidade" id="mat_quantidade" class="form-control" step="0.001" required>
                    </div>
                    <div class="form-group">
                        <label for="mat_unidade">Unidade</label>
                        <input type="text" name="unidade" id="mat_unidade" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="mat_tipo">Tipo</label>
                        <select name="tipo" id="mat_tipo" class="form-control">
                            <option value="material">Material</option>
                            <option value="mao_obra">Mão de Obra</option>
                            <option value="equipamento">Equipamento</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
<script>
let currentEditElement = null;

$(document).ready(function() {
    // Estado inicial: todas recolhidas
    $('.categoria-content').hide();
    $('.atividade-content').hide();
    
    // Expandir tudo
    $('#expandAllBtn').click(function() {
        $('.categoria-content').slideDown(300);
        $('.categoria-header').addClass('active');
        $('.categoria-header i:first').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        
        setTimeout(function() {
            $('.atividade-content').slideDown(300);
            $('.atividade-header').addClass('active');
            $('.atividade-header i:first').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        }, 100);
    });
    
    // Recolher tudo
    $('#collapseAllBtn').click(function() {
        $('.atividade-content').slideUp(300);
        $('.atividade-header').removeClass('active');
        $('.atividade-header i:first').removeClass('fa-chevron-down').addClass('fa-chevron-right');
        
        setTimeout(function() {
            $('.categoria-content').slideUp(300);
            $('.categoria-header').removeClass('active');
            $('.categoria-header i:first').removeClass('fa-chevron-down').addClass('fa-chevron-right');
        }, 100);
    });
    
    // Acordeão para Categorias
    $('.categoria-header').click(function(e) {
        if ($(e.target).closest('.btn-group').length || $(e.target).closest('.editable').length) return;
        
        const $content = $(this).next('.categoria-content');
        const $icon = $(this).find('h3 i:first');
        
        $content.slideToggle(300);
        $(this).toggleClass('active');
        $icon.toggleClass('fa-chevron-right fa-chevron-down');
    });
    
    // Acordeão para Atividades
    $('.atividade-header').click(function(e) {
        if ($(e.target).closest('.btn-group').length || $(e.target).closest('.editable').length) return;
        
        e.stopPropagation();
        const $content = $(this).next('.atividade-content');
        const $icon = $(this).find('h4 i:first');
        
        $content.slideToggle(300);
        $(this).toggleClass('active');
        $icon.toggleClass('fa-chevron-right fa-chevron-down');
    });
    
    // Forms de adicionar
    $('#formAddCategoria').submit(function(e) {
        e.preventDefault();
        $.post('{{ route("categorias-obra.store") }}', $(this).serialize())
            .done(() => location.reload())
            .fail(err => alert('Erro: ' + err.responseJSON?.message));
    });
    
    $('#formAddAtividade').submit(function(e) {
        e.preventDefault();
        $.post('{{ route("atividades.store") }}', $(this).serialize())
            .done(() => location.reload())
            .fail(err => alert('Erro: ' + err.responseJSON?.message));
    });
    
    $('#formAddSubatividade').submit(function(e) {
        e.preventDefault();
        $.post('{{ route("subatividades.store") }}', $(this).serialize())
            .done(() => location.reload())
            .fail(err => alert('Erro: ' + err.responseJSON?.message));
    });
    
    $('#formAddMaterial').submit(function(e) {
        e.preventDefault();
        $.post('{{ route("composicoes.store") }}', $(this).serialize())
            .done(() => location.reload())
            .fail(err => alert('Erro: ' + err.responseJSON?.message));
    });
    
    // Auto preencher unidade ao selecionar material
    $('#mat_material_id').change(function() {
        const option = $(this).find('option:selected');
        const unidade = option.text().match(/\((.*?)\)/);
        if (unidade) $('#mat_unidade').val(unidade[1]);
    });
});

// Função de edição inline
function editarInline(element, tipo, id, campo) {
    const $span = $(element).closest('div').find('.editable[data-id="' + id + '"][data-campo="' + campo + '"]');
    if (!$span.length) return;
    
    const valorAtual = $span.text().trim().replace('MT', '').replace(',', '.').trim();
    const $input = $('<input>', {
        type: 'text',
        value: valorAtual,
        class: 'edit-input',
        css: { width: $span.width() + 20 }
    });
    
    const $saveBtn = $('<button>', {
        class: 'btn btn-sm btn-success',
        html: '<i class="fas fa-check"></i>',
        click: function() { salvarEdicao(id, tipo, campo, $input.val(), $span, $wrapper); }
    });
    
    const $cancelBtn = $('<button>', {
        class: 'btn btn-sm btn-secondary',
        html: '<i class="fas fa-times"></i>',
        click: function() { $wrapper.replaceWith($span); }
    });
    
    const $wrapper = $('<div>', { class: 'edit-wrapper d-inline-flex align-items-center gap-1' })
        .append($input, $saveBtn, $cancelBtn);
    
    $span.replaceWith($wrapper);
    $input.focus();
}

function salvarEdicao(id, tipo, campo, valor, $span, $wrapper) {
    const url = tipo === 'categoria' ? '/categorias-obra/' + id :
                tipo === 'atividade' ? '/atividades/' + id :
                tipo === 'subatividade' ? '/subatividades/' + id :
                '/composicoes/' + id;
    
    const dados = {};
    if (campo === 'custo_unitario') {
        dados[campo] = parseFloat(valor.replace('MT', '').replace(',', '.').trim());
    } else if (campo === 'quantidade' || campo === 'quantidade_proposta' || campo === 'perda_percentual') {
        dados[campo] = parseFloat(valor.replace(',', '.'));
    } else {
        dados[campo] = valor;
    }
    
    $.ajax({
        url: url,
        method: 'PUT',
        data: dados,
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function() {
            $span.text(campo === 'custo_unitario' ? 'MT ' + parseFloat(valor).toFixed(2) : valor);
            $wrapper.replaceWith($span);
            location.reload();
        },
        error: function(xhr) {
            alert('Erro: ' + (xhr.responseJSON?.message || 'Erro ao salvar'));
            $wrapper.replaceWith($span);
        }
    });
}

function adicionarAtividadeModal(categoriaId) {
    $('#ativ_categoria_id').val(categoriaId);
    $('#modalAddAtividade').modal('show');
}

function adicionarSubatividadeModal(atividadeId) {
    $('#sub_atividade_id').val(atividadeId);
    $('#modalAddSubatividade').modal('show');
}

function adicionarMaterialModal(subatividadeId) {
    $('#mat_subatividade_id').val(subatividadeId);
    $('#modalAddMaterial').modal('show');
}

function excluirSubatividade(id) {
    if (confirm('Tem certeza que deseja excluir esta subatividade?')) {
        $.ajax({
            url: '/subatividades/' + id,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: () => location.reload(),
            error: () => alert('Erro ao excluir')
        });
    }
}

function removerAtividade(orcamentoId, atividadeId) {
    if (confirm('Tem certeza que deseja remover esta atividade do orçamento?')) {
        $.ajax({
            url: '/orcamentos/' + orcamentoId + '/atividades/' + atividadeId,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: () => location.reload(),
            error: () => alert('Erro ao remover')
        });
    }
}

function removerMaterial(composicaoId) {
    if (confirm('Tem certeza que deseja remover este material?')) {
        $.ajax({
            url: '/composicoes/' + composicaoId,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: () => location.reload(),
            error: () => alert('Erro ao remover')
        });
    }
}
</script>
@endsection

@stop