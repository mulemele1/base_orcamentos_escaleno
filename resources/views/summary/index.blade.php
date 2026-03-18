@extends('adminlte::page')

@section('title', 'Resumo do Orçamento')

@section('content')
<style>
    .card-header {
        background-color: #6c757d;
        color: white;
    }
    .card-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }
    .card-header i {
        margin-right: 5px;
    }
    .table-summary {
        background-color: #fff;
    }
    .table-summary th {
        background-color: #90caf9;
        color: #fff;
        text-align: center;
    }
    .table-summary td {
        vertical-align: middle;
    }
    .valor-destaque {
        font-weight: bold;
        color: #28a745;
        font-size: 1.1em;
    }
    .total-geral {
        font-size: 1.3em;
        font-weight: bold;
        color: #17a2b8;
    }
    .grand-total {
        font-size: 1.5em;
        font-weight: bold;
        color: #dc3545;
    }
    .categoria-row {
        background-color: #e3f2fd;
        font-weight: 600;
    }
    .resumo-card {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .resumo-item {
        text-align: center;
        padding: 10px;
        border-right: 1px solid #dee2e6;
    }
    .resumo-item:last-child {
        border-right: none;
    }
    .resumo-label {
        font-size: 0.9rem;
        color: #6c757d;
    }
    .resumo-valor {
        font-size: 1.3rem;
        font-weight: bold;
    }
</style>

<div class="row mb-3">
    <div class="col-12">
        <a href="{{ url('/home') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
    <h3 class="card-title">
        <i class="fas fa-chart-pie"></i>
        Resumo Geral do Orçamento
    </h3>
    <div class="card-tools">
        <a href="{{ route('pdf.summary') }}" class="btn-sm bg-danger mr-2" target="_blank">
            <i class="fas fa-file-pdf"></i> PDF Resumo
        </a>
        <a href="{{ route('summary.excel') }}" class="btn-sm bg-success">
            <i class="fas fa-file-excel"></i> Excel
        </a>
    </div>
</div>
            <div class="card-body">
                <!-- Cards de Resumo -->
                <div class="resumo-card">
                    <div class="row">
                        <div class="col-md-3 resumo-item">
                            <div class="resumo-label">Total de Categorias</div>
                            <div class="resumo-valor">{{ $categorias->count() }}</div>
                        </div>
                        <div class="col-md-3 resumo-item">
                            <div class="resumo-label">Total de Itens</div>
                            <div class="resumo-valor">{{ $categorias->sum(function($c) { return $c->itens->count(); }) }}</div>
                        </div>
                        <div class="col-md-3 resumo-item">
                            <div class="resumo-label">IVA</div>
                            <div class="resumo-valor">{{ $iva }}%</div>
                        </div>
                        <div class="col-md-3 resumo-item">
                            <div class="resumo-label">Contingências</div>
                            <div class="resumo-valor">{{ $contingencia }}%</div>
                        </div>
                    </div>
                </div>

                <!-- Tabela Resumo por Categoria -->
                <div class="table-responsive">
                    <table class="table table-bordered table-summary">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Categoria</th>
                                <th>Quantidade de Itens</th>
                                <th>Subtotal (MT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorias as $categoria)
                                <tr class="categoria-row">
                                    <td><span class="badge bg-secondary">{{ $categoria->codigo }}</span></td>
                                    <td>{{ $categoria->nome }}</td>
                                    <td class="text-center">{{ $categoria->itens->count() }}</td>
                                    <td class="text-right valor-destaque">
                                        MT {{ number_format($subtotais[$categoria->id] ?? 0, 2, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Totais e Impostos -->
                <div class="row mt-4">
                    <div class="col-md-6 offset-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <td><strong>SUB TOTAL A</strong></td>
                                <td class="text-right">MT {{ number_format($subTotalA, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>IVA ({{ $iva }}%)</strong></td>
                                <td class="text-right">MT {{ number_format($valorIva, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>SUB TOTAL B</strong></td>
                                <td class="text-right total-geral">MT {{ number_format($subTotalB, 2, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td><strong>CONTINGÊNCIAS ({{ $contingencia }}%)</strong></td>
                                <td class="text-right">MT {{ number_format($valorContingencias, 2, ',', '.') }}</td>
                            </tr>
                            <tr class="bg-light">
                                <td><strong>GRAND TOTAL</strong></td>
                                <td class="text-right grand-total">MT {{ number_format($grandTotal, 2, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Gráfico Simples (opcional) -->
                <div class="row mt-4">
                    <div class="col-12">
                        <canvas id="graficoResumo" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('graficoResumo').getContext('2d');
        
        // Preparar dados para o gráfico
        const categorias = @json($categorias->pluck('nome'));
        const valores = @json($categorias->map(function($c) use ($subtotais) {
            return $subtotais[$c->id] ?? 0;
        }));

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: categorias,
                datasets: [{
                    label: 'Valor por Categoria (MT)',
                    data: valores,
                    backgroundColor: 'rgba(144, 202, 249, 0.5)',
                    borderColor: 'rgba(144, 202, 249, 1)',
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

@include('layouts.datatable')
@endsection