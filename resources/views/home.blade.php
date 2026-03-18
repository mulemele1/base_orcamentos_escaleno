@extends('adminlte::page')

@section('title', 'Dashboard - Orçamento de Obra')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Dashboard do Orçamento</h1>
    <div class="text-muted">
        <i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    </div>
</div>
@endsection

@section('content')
<style>
    .info-box {
        min-height: 100px;
        border-radius: 10px;
        transition: all 0.3s;
        cursor: pointer;
        border: 1px solid rgba(0,0,0,0.1);
    }
    .info-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    .info-box-icon {
        border-radius: 10px 0 0 10px;
        font-size: 2.5rem;
    }
    .card {
        border-radius: 10px;
        overflow: hidden;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        border-bottom: none;
    }
    .card-header i {
        margin-right: 10px;
    }
    .bg-primary-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-success-gradient {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
    }
    .bg-info-gradient {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .bg-warning-gradient {
        background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
    }
    .valor-destaque {
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(102, 126, 234, 0.1);
        transition: all 0.3s;
    }
    .badge-unidade {
        background-color: #e3f2fd;
        color: #1976d2;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.9rem;
    }
</style>

<!-- Cards de Resumo -->
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="info-box bg-primary-gradient">
            <span class="info-box-icon"><i class="fas fa-folder-open text-white"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-white">Categorias</span>
                <span class="info-box-number text-white">{{ $totalCategorias }}</span>
                <span class="info-box-text text-white-50">Total de categorias</span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="info-box bg-success-gradient">
            <span class="info-box-icon"><i class="fas fa-list text-white"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-white">Itens</span>
                <span class="info-box-number text-white">{{ $totalItens }}</span>
                <span class="info-box-text text-white-50">Total de itens</span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="info-box bg-info-gradient">
            <span class="info-box-icon"><i class="fas fa-cubes text-white"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-white">Materiais</span>
                <span class="info-box-number text-white">{{ $totalMateriais }}</span>
                <span class="info-box-text text-white-50">Na base de dados</span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="info-box bg-warning-gradient">
            <span class="info-box-icon"><i class="fas fa-chart-line text-white"></i></span>
            <div class="info-box-content">
                <span class="info-box-text text-white">Total Orçamento</span>
                <span class="info-box-number text-white">MT {{ number_format($totalOrcamento, 2, ',', '.') }}</span>
                <span class="info-box-text text-white-50">Sem impostos</span>
            </div>
        </div>
    </div>
</div>

<!-- Cards de Valores com Impostos -->
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Valor Base</h5>
                <p class="valor-destaque">MT {{ number_format($totalOrcamento, 2, ',', '.') }}</p>
                <small class="text-muted">Sem impostos</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">IVA ({{ $iva }}%)</h5>
                <p class="valor-destaque text-primary">MT {{ number_format($valorIva, 2, ',', '.') }}</p>
                <small class="text-muted">Imposto sobre valor acrescentado</small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="card-title">Contingências ({{ $contingencia }}%)</h5>
                <p class="valor-destaque text-warning">MT {{ number_format($valorContingencias, 2, ',', '.') }}</p>
                <small class="text-muted">Margem de segurança</small>
            </div>
        </div>
    </div>
</div>

<!-- Grand Total -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-success text-white">
            <div class="card-body text-center py-4">
                <h3 class="card-title text-white mb-3">GRAND TOTAL</h3>
                <h1 class="display-4 font-weight-bold">MT {{ number_format($grandTotal, 2, ',', '.') }}</h1>
                <small class="text-white-50">Valor final com impostos e contingências</small>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="row">
    <!-- Gráfico de Pizza por Categoria -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-pie"></i> Distribuição por Categoria
            </div>
            <div class="card-body">
                <canvas id="categoriaChart" style="min-height: 300px;"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Gráfico de Barras Mensal -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-bar"></i> Evolução Mensal
            </div>
            <div class="card-body">
                <canvas id="mensalChart" style="min-height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Top 10 Itens Mais Caros -->
<div class="row mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-trophy"></i> Top 10 Itens Mais Caros
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th>Descrição</th>
                                <th>Categoria</th>
                                <th class="text-right">Total (MT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topItens as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><span class="badge bg-secondary">{{ $item->item }}</span></td>
                                    <td>{{ Str::limit($item->descricao, 30) }}</td>
                                    <td>{{ $item->categoria->nome ?? 'N/A' }}</td>
                                    <td class="text-right font-weight-bold">
                                        {{ number_format($item->total, 2, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Distribuição por Unidade -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-cubes"></i> Distribuição por Unidade
            </div>
            <div class="card-body">
                @foreach ($unidades as $unidade)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge-unidade">
                                <i class="fas fa-cube"></i> {{ $unidade->unidade }}
                            </span>
                            <span class="font-weight-bold">{{ $unidade->total }}</span>
                        </div>
                        <div class="progress mt-1" style="height: 10px;">
                            @php
                                $percentual = ($unidade->total / $totalItens) * 100;
                            @endphp
                            <div class="progress-bar bg-primary" 
                                 role="progressbar" 
                                 style="width: {{ $percentual }}%"
                                 aria-valuenow="{{ $percentual }}" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                @endforeach
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
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('categorias-obra.list') }}" class="btn btn-outline-primary btn-block py-3">
                            <i class="fas fa-folder-open fa-2x mb-2"></i>
                            <br>Categorias
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('itens-orcamento.list') }}" class="btn btn-outline-success btn-block py-3">
                            <i class="fas fa-list fa-2x mb-2"></i>
                            <br>Itens
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('materiais.list') }}" class="btn btn-outline-info btn-block py-3">
                            <i class="fas fa-cubes fa-2x mb-2"></i>
                            <br>Materiais
                        </a>
                    </div>
                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('summary.index') }}" class="btn btn-outline-warning btn-block py-3">
                            <i class="fas fa-chart-pie fa-2x mb-2"></i>
                            <br>Resumo
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de Pizza por Categoria
        const ctxCategoria = document.getElementById('categoriaChart').getContext('2d');
        new Chart(ctxCategoria, {
            type: 'pie',
            data: {
                labels: @json($categoriaLabels),
                datasets: [{
                    data: @json($categoriaValores),
                    backgroundColor: @json($categoriaCores),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            font: {
                                size: 10
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.raw || 0;
                                let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                let percentage = ((value / total) * 100).toFixed(2);
                                return `${label}: MT ${value.toFixed(2)} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });

        // Gráfico de Barras Mensal
        const ctxMensal = document.getElementById('mensalChart').getContext('2d');
        new Chart(ctxMensal, {
            type: 'bar',
            data: {
                labels: @json($meses),
                datasets: [{
                    label: 'Valor (MT)',
                    data: @json($valoresMensais),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'MT ' + value.toFixed(2);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'MT ' + context.raw.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<script>
    // Atualizar hora em tempo real (mantendo do código original)
    function atualizarHora() {
        const agora = new Date();
        const horas = agora.getHours().toString().padStart(2, '0');
        const minutos = agora.getMinutes().toString().padStart(2, '0');
        const segundos = agora.getSeconds().toString().padStart(2, '0');
        
        document.querySelector('.content-header .text-muted').innerHTML = 
            '<i class="fas fa-calendar-alt"></i> ' + agora.toLocaleDateString('pt-BR') + ' ' + horas + ':' + minutos + ':' + segundos;
    }

    setInterval(atualizarHora, 1000);
</script>
@endsection