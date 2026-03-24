@extends('adminlte::page')

@section('title', 'Escaleno - Gestão de Obra')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="m-0 text-dark">
            <i class="fas fa-chart-pie mr-2"></i>Dashboard de Orçamento e Medição
        </h1>
        <small class="text-muted">Visão geral dos projetos e orçamentos</small>
    </div>
    <div class="text-muted bg-white p-2 rounded shadow-sm">
        <i class="fas fa-calendar-alt text-primary mr-1"></i> 
        <span id="data-hora">{{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</span>
    </div>
</div>
@endsection

@section('content')
<style>
    .info-box {
        min-height: 120px;
        border-radius: 15px;
        transition: all 0.3s;
        cursor: pointer;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        position: relative;
        overflow: hidden;
    }
    .info-box:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .info-box-icon {
        border-radius: 15px 0 0 15px;
        font-size: 2.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .info-box-content {
        padding: 15px;
    }
    .info-box-text {
        font-size: 0.9rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .info-box-number {
        font-size: 1.8rem;
        font-weight: 700;
        line-height: 1.2;
    }
    .card {
        border-radius: 15px;
        overflow: hidden;
        border: none;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: all 0.3s;
    }
    .card:hover {
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }
    .card-header {
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        color: white;
        font-weight: 600;
        border-bottom: none;
        padding: 15px 20px;
    }
    .card-header i {
        margin-right: 10px;
        font-size: 1.2rem;
    }
    .card-body {
        padding: 20px;
    }
    .bg-primary-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-success-gradient {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
    .bg-info-gradient {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    .bg-warning-gradient {
        background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
    }
    .bg-dark-gradient {
        background: linear-gradient(135deg, #141e30 0%, #243b55 100%);
    }
    .valor-destaque {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
        margin: 10px 0;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
        transition: all 0.3s;
    }
    .badge-unidade {
        background-color: #e3f2fd;
        color: #1976d2;
        padding: 6px 12px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    .badge-unidade i {
        margin-right: 5px;
        font-size: 0.9rem;
    }
    .btn-acesso {
        border-radius: 12px;
        padding: 20px 10px;
        font-weight: 600;
        transition: all 0.3s;
        border: 2px solid transparent;
    }
    .btn-acesso:hover {
        transform: translateY(-5px);
        border-color: #3498db;
    }
    .btn-acesso i {
        font-size: 2.2rem;
        margin-bottom: 10px;
    }
    .progress {
        border-radius: 10px;
        background-color: #ecf0f1;
    }
    .progress-bar {
        border-radius: 10px;
        background: linear-gradient(90deg, #3498db, #2980b9);
    }
    .quick-stats {
        background: #f8fafc;
        border-radius: 10px;
        padding: 10px;
        margin-top: 10px;
    }
    .stat-item {
        text-align: center;
        padding: 5px;
    }
    .stat-label {
        font-size: 0.75rem;
        color: #7f8c8d;
    }
    .stat-value {
        font-size: 1.1rem;
        font-weight: bold;
        color: #2c3e50;
    }
    .info-box.bg-primary {
        background: linear-gradient(135deg, #2c3e50, #3498db);
    }
    .info-box.bg-success {
        background: linear-gradient(135deg, #27ae60, #2ecc71);
    }
    .info-box.bg-warning {
        background: linear-gradient(135deg, #e67e22, #f39c12);
    }
    .info-box.bg-info {
        background: linear-gradient(135deg, #1abc9c, #16a085);
    }
    .info-box.bg-danger {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
    }
</style>

<!-- Cards de Projetos -->
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="info-box bg-primary">
            <span class="info-box-icon"><i class="fas fa-building"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Projetos</span>
                <span class="info-box-number">{{ $totalProjetos ?? 0 }}</span>
                <div class="progress mt-2" style="height: 5px;">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                    Todos os projetos cadastrados
                </span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-6">
        <div class="info-box bg-success">
            <span class="info-box-icon"><i class="fas fa-play-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Projetos Ativos</span>
                <span class="info-box-number">{{ $projetosAtivos ?? 0 }}</span>
                <div class="progress mt-2" style="height: 5px;">
                    @php $percentAtivos = ($totalProjetos ?? 0) > 0 ? (($projetosAtivos ?? 0) / ($totalProjetos ?? 1)) * 100 : 0; @endphp
                    <div class="progress-bar" style="width: {{ $percentAtivos }}%"></div>
                </div>
                <span class="progress-description">
                    Em andamento / Planeamento
                </span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-6">
        <div class="info-box bg-warning">
            <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Projetos Concluídos</span>
                <span class="info-box-number">{{ $projetosConcluidos ?? 0 }}</span>
                <div class="progress mt-2" style="height: 5px;">
                    @php $percentConcluidos = ($totalProjetos ?? 0) > 0 ? (($projetosConcluidos ?? 0) / ($totalProjetos ?? 1)) * 100 : 0; @endphp
                    <div class="progress-bar" style="width: {{ $percentConcluidos }}%"></div>
                </div>
                <span class="progress-description">
                    Finalizados com sucesso
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Cards de Resumo -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="info-box bg-primary-gradient">
            <span class="info-box-icon"><i class="fas fa-folder-open text-white"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-white">Categorias</span>
                <span class="info-box-number text-white">{{ $totalCategorias ?? 0 }}</span>
                <div class="quick-stats mt-2">
                    <div class="row">
                        <div class="col-6 stat-item">
                            <div class="stat-label">Ativas</div>
                            <div class="stat-value">{{ $totalCategorias ?? 0 }}</div>
                        </div>
                        <div class="col-6 stat-item">
                            <div class="stat-label">Com itens</div>
                            <div class="stat-value">{{ count($categoriaValores ?? []) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="info-box bg-success-gradient">
            <span class="info-box-icon"><i class="fas fa-list text-white"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-white">Itens</span>
                <span class="info-box-number text-white">{{ $totalItens ?? 0 }}</span>
                <div class="quick-stats mt-2">
                    <div class="row">
                        <div class="col-6 stat-item">
                            <div class="stat-label">Com material</div>
                            <div class="stat-value">{{ $itensComMaterial ?? 0 }}</div>
                        </div>
                        <div class="col-6 stat-item">
                            <div class="stat-label">Média/Item</div>
                            <div class="stat-value">MT {{ number_format(($totalItens ?? 0) > 0 ? ($totalOrcamento ?? 0) / ($totalItens ?? 1) : 0, 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="info-box bg-info-gradient">
            <span class="info-box-icon"><i class="fas fa-cubes text-white"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-white">Materiais</span>
                <span class="info-box-number text-white">{{ $totalMateriais ?? 0 }}</span>
                <div class="quick-stats mt-2">
                    <div class="row">
                        <div class="col-6 stat-item">
                            <div class="stat-label">Categorias</div>
                            <div class="stat-value">{{ $categoriasMaterial ?? 0 }}</div>
                        </div>
                        <div class="col-6 stat-item">
                            <div class="stat-label">Preço médio</div>
                            <div class="stat-value">MT {{ number_format($precoMedioMaterial ?? 0, 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="info-box bg-warning-gradient">
            <span class="info-box-icon"><i class="fas fa-chart-line text-white"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-white">Total Orçamento</span>
                <span class="info-box-number text-white">MT {{ number_format($totalOrcamento ?? 0, 2, ',', '.') }}</span>
                <div class="quick-stats mt-2">
                    <div class="row">
                        <div class="col-6 stat-item">
                            <div class="stat-label">+IVA</div>
                            <div class="stat-value text-primary">MT {{ number_format($valorIva ?? 0, 0) }}</div>
                        </div>
                        <div class="col-6 stat-item">
                            <div class="stat-label">Final</div>
                            <div class="stat-value text-success">MT {{ number_format($grandTotal ?? 0, 0) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cards de Valores com Progresso -->
<div class="row mt-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calculator text-primary mr-2"></i>Valor Base
                    </h5>
                    <span class="badge bg-primary">100%</span>
                </div>
                <p class="valor-destaque">MT {{ number_format($totalOrcamento ?? 0, 2, ',', '.') }}</p>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                </div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-info-circle mr-1"></i>Sem impostos
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-percent text-primary mr-2"></i>IVA ({{ $iva ?? 16 }}%)
                    </h5>
                    <span class="badge bg-info">{{ $iva ?? 16 }}%</span>
                </div>
                <p class="valor-destaque text-primary">MT {{ number_format($valorIva ?? 0, 2, ',', '.') }}</p>
                <div class="progress" style="height: 8px;">
                    @php $percentualIva = ($grandTotal ?? 0) > 0 ? (($valorIva ?? 0) / ($grandTotal ?? 1)) * 100 : 0; @endphp
                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $percentualIva }}%"></div>
                </div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-info-circle mr-1"></i>{{ number_format($percentualIva, 1) }}% do total final
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shield-alt text-primary mr-2"></i>Contingências ({{ $contingencia ?? 8 }}%)
                    </h5>
                    <span class="badge bg-warning">{{ $contingencia ?? 8 }}%</span>
                </div>
                <p class="valor-destaque text-warning">MT {{ number_format($valorContingencias ?? 0, 2, ',', '.') }}</p>
                <div class="progress" style="height: 8px;">
                    @php $percentualCont = ($grandTotal ?? 0) > 0 ? (($valorContingencias ?? 0) / ($grandTotal ?? 1)) * 100 : 0; @endphp
                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentualCont }}%"></div>
                </div>
                <small class="text-muted mt-2 d-block">
                    <i class="fas fa-info-circle mr-1"></i>Margem de segurança
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Grand Total com Efeito -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-dark-gradient text-white">
            <div class="card-body text-center py-4">
                <h3 class="card-title text-white mb-3">
                    <i class="fas fa-star"></i> GRAND TOTAL <i class="fas fa-star"></i>
                </h3>
                <h1 class="display-3 font-weight-bold">MT {{ number_format($grandTotal ?? 0, 2, ',', '.') }}</h1>
                <div class="row mt-3">
                    <div class="col-4 offset-4">
                        <div class="d-flex justify-content-between">
                            <small class="text-white-50">Base: {{ number_format($totalOrcamento ?? 0, 0) }}</small>
                            <small class="text-white-50">IVA: {{ number_format($valorIva ?? 0, 0) }}</small>
                            <small class="text-white-50">Cont: {{ number_format($valorContingencias ?? 0, 0) }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos em Grid -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-pie"></i> Distribuição por Categoria
                <small class="float-right">Total: MT {{ number_format($totalOrcamento ?? 0, 0) }}</small>
            </div>
            <div class="card-body">
                <canvas id="categoriaChart" style="min-height: 350px;"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-bar"></i> Top 5 Categorias
                <small class="float-right">Por valor</small>
            </div>
            <div class="card-body">
                <canvas id="topCategoriasChart" style="min-height: 350px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Evolução Mensal -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-line"></i> Evolução Mensal
                <small class="float-right">Valores por mês</small>
            </div>
            <div class="card-body">
                <canvas id="evolucaoMensalChart" style="min-height: 350px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Top Itens e Distribuição -->
<div class="row mt-4">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-trophy"></i> Top 10 Itens Mais Caros
                <small class="float-right">Total: MT {{ number_format($topItens->sum('total'), 0) }}</small>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            60d
                                <th>#</th>
                                <th>Item</th>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th class="text-right">Total (MT)</th>
                                <th class="text-center">%</th>
                            </thead>
                        <tbody>
                            @foreach ($topItens as $index => $item)
                                @php
                                    $percentual = ($grandTotal ?? 0) > 0 ? ($item->total / ($grandTotal ?? 1)) * 100 : 0;
                                @endphp
                                2d
                                    <td>
                                        @if($index < 3)
                                            <span class="badge bg-{{ $index == 0 ? 'warning' : ($index == 1 ? 'secondary' : 'danger') }} text-white">
                                                <i class="fas fa-crown"></i> {{ $index + 1 }}
                                            </span>
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </td>
                                    <td><span class="badge bg-secondary">{{ $item->item }}</span></td>
                                    <td>{{ Str::limit($item->descricao, 25) }}</td>
                                    <td><small>{{ $item->categoria ? $item->categoria->nome : 'N/A' }}</small></td>
                                    <td class="text-right font-weight-bold text-primary">
                                        {{ number_format($item->total, 2, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <small>{{ number_format($percentual, 1) }}%</small>
                                        <div class="progress" style="height: 3px; width: 50px; margin: 0 auto;">
                                            <div class="progress-bar" style="width: {{ $percentual }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-5">
        
        
        <!-- Resumo Rápido -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-simple"></i> Indicadores Rápidos
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="small-box bg-light p-3 rounded">
                            <div class="inner">
                                <p>Média por Item</p>
                                <h4>MT {{ number_format(($totalItens ?? 0) > 0 ? ($totalOrcamento ?? 0) / ($totalItens ?? 1) : 0, 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="small-box bg-light p-3 rounded">
                            <div class="inner">
                                <p>Média por Categoria</p>
                                <h4>MT {{ number_format(($totalCategorias ?? 0) > 0 ? ($totalOrcamento ?? 0) / ($totalCategorias ?? 1) : 0, 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="small-box bg-light p-3 rounded">
                            <div class="inner">
                                <p>Total com IVA</p>
                                <h4>MT {{ number_format($subTotalB ?? 0, 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="small-box bg-light p-3 rounded">
                            <div class="inner">
                                <p>Total Final</p>
                                <h4>MT {{ number_format($grandTotal ?? 0, 2, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Acesso Rápido -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-rocket"></i> Acesso Rápido
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 col-6 mb-3">
                        <a href="{{ route('projetos.index') }}" class="btn btn-outline-primary btn-acesso btn-block">
                            <i class="fas fa-building fa-2x mb-2"></i>
                            <br>Projetos
                            <small class="d-block text-muted">Gerenciar projetos</small>
                        </a>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <a href="{{ route('categorias-obra.list') }}" class="btn btn-outline-primary btn-acesso btn-block">
                            <i class="fas fa-folder-open fa-2x mb-2"></i>
                            <br>Categorias
                            <small class="d-block text-muted">Gerenciar categorias</small>
                        </a>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <a href="{{ route('atividades.index') }}" class="btn btn-outline-success btn-acesso btn-block">
                            <i class="fas fa-tasks fa-2x mb-2"></i>
                            <br>Atividades
                            <small class="d-block text-muted">Lista de atividades</small>
                        </a>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <a href="{{ route('subatividades.index') }}" class="btn btn-outline-info btn-acesso btn-block">
                            <i class="fas fa-list-alt fa-2x mb-2"></i>
                            <br>Subatividades
                            <small class="d-block text-muted">Itens detalhados</small>
                        </a>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <a href="{{ route('materiais.list') }}" class="btn btn-outline-warning btn-acesso btn-block">
                            <i class="fas fa-cubes fa-2x mb-2"></i>
                            <br>Materiais
                            <small class="d-block text-muted">Base de preços</small>
                        </a>
                    </div>
                    <div class="col-md-2 col-6 mb-3">
                        <a href="{{ route('summary.index') }}" class="btn btn-outline-danger btn-acesso btn-block">
                            <i class="fas fa-chart-pie fa-2x mb-2"></i>
                            <br>Resumo
                            <small class="d-block text-muted">Visão consolidada</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer com informações -->
<div class="row mt-4">
    <div class="col-12">
        <div class="small text-muted text-center">
            <i class="fas fa-database mr-1"></i> 
            {{ $totalCategorias ?? 0 }} categorias | 
            {{ $totalItens ?? 0 }} itens | 
            {{ $totalMateriais ?? 0 }} materiais | 
            {{ $totalProjetos ?? 0 }} projetos |
            Última atualização: {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de Pizza por Categoria
        const ctxCategoria = document.getElementById('categoriaChart');
        if (ctxCategoria) {
            const categoriaLabels = {!! json_encode($categoriaLabels ?? []) !!};
            const categoriaValores = {!! json_encode($categoriaValores ?? []) !!};
            const categoriaCores = {!! json_encode($categoriaCores ?? ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']) !!};
            
            if (categoriaLabels.length > 0 && categoriaValores.length > 0) {
                new Chart(ctxCategoria, {
                    type: 'doughnut',
                    data: {
                        labels: categoriaLabels,
                        datasets: [{
                            data: categoriaValores,
                            backgroundColor: categoriaCores,
                            borderWidth: 2,
                            borderColor: '#fff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '60%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: { size: 11 },
                                    padding: 15
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let label = context.label || '';
                                        let value = context.raw || 0;
                                        let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        let percentage = total > 0 ? ((value / total) * 100).toFixed(2) : 0;
                                        return `${label}: MT ${value.toFixed(2)} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                ctxCategoria.parentNode.innerHTML = '<div class="text-center text-muted py-5"><i class="fas fa-chart-pie fa-3x mb-3"></i><br>Nenhum dado disponível para exibir</div>';
            }
        }

        // Gráfico de Barras - Top 5 Categorias
        const ctxTop = document.getElementById('topCategoriasChart');
        if (ctxTop) {
            const topLabels = {!! json_encode($top5Categorias ?? []) !!};
            const topValues = {!! json_encode($top5Valores ?? []) !!};
            
            if (topLabels.length > 0 && topValues.length > 0) {
                new Chart(ctxTop, {
                    type: 'bar',
                    data: {
                        labels: topLabels,
                        datasets: [{
                            label: 'Valor (MT)',
                            data: topValues,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(153, 102, 255, 0.8)'
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 206, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(153, 102, 255)'
                            ],
                            borderWidth: 1,
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'MT ' + context.raw.toFixed(2);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,0.05)' },
                                ticks: {
                                    callback: function(value) {
                                        return 'MT ' + value.toFixed(0);
                                    }
                                }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
            } else {
                ctxTop.parentNode.innerHTML = '<div class="text-center text-muted py-5"><i class="fas fa-chart-bar fa-3x mb-3"></i><br>Nenhum dado disponível para exibir</div>';
            }
        }

        // Gráfico de Evolução Mensal
        const ctxEvolucao = document.getElementById('evolucaoMensalChart');
        if (ctxEvolucao) {
            const meses = {!! json_encode($meses ?? ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez']) !!};
            const valoresMensais = {!! json_encode($evolucaoMensal ?? []) !!};
            
            if (valoresMensais.some(v => v > 0)) {
                new Chart(ctxEvolucao, {
                    type: 'line',
                    data: {
                        labels: meses,
                        datasets: [{
                            label: 'Valor (MT)',
                            data: valoresMensais,
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                            pointBorderColor: '#fff',
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'MT ' + context.raw.toFixed(2);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'MT ' + value.toFixed(0);
                                    }
                                }
                            }
                        }
                    }
                });
            } else {
                ctxEvolucao.parentNode.innerHTML = '<div class="text-center text-muted py-5"><i class="fas fa-chart-line fa-3x mb-3"></i><br>Nenhum dado disponível para exibir</div>';
            }
        }
    });

    // Atualizar hora em tempo real
    function atualizarHora() {
        const agora = new Date();
        const horas = agora.getHours().toString().padStart(2, '0');
        const minutos = agora.getMinutes().toString().padStart(2, '0');
        const segundos = agora.getSeconds().toString().padStart(2, '0');
        
        const elemento = document.getElementById('data-hora');
        if (elemento) {
            elemento.innerHTML = agora.toLocaleDateString('pt-BR') + ' ' + horas + ':' + minutos + ':' + segundos;
        }
    }

    setInterval(atualizarHora, 1000);
</script>
@endsection