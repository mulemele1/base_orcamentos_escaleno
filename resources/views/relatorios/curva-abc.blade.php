@extends('adminlte::page')

@section('title', 'Curva ABC - Orçamento')

@section('content_header')
    <h1><i class="fas fa-chart-line mr-2"></i>Curva ABC</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Curva ABC de Serviços</h3>
                </div>
                <div class="card-body">
                    <canvas id="curvaABCChart" style="height: 400px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Classificação por Categoria</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead>
                            60d
                                <th>Item</th>
                                <th>Categoria</th>
                                <th>Valor (MT)</th>
                                <th>% Acumulado</th>
                                <th>Classificação</th>
                            </thead>
                        <tbody>
                            @foreach($itens as $item)
                            <tr class="
                                @if($item['classificacao'] == 'A') table-danger
                                @elseif($item['classificacao'] == 'B') table-warning
                                @else table-success
                                @endif
                            ">
                                <td>{{ $item['nome'] }}</td>
                                <td>{{ $item['categoria'] }}</td>
                                <td class="text-right">MT {{ number_format($item['valor'], 2, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($item['percentual_acumulado'], 2) }}%</td>
                                <td>
                                    <span class="badge badge-{{ $item['classificacao'] == 'A' ? 'danger' : ($item['classificacao'] == 'B' ? 'warning' : 'success') }}">
                                        Classe {{ $item['classificacao'] }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('curvaABCChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Percentual Acumulado (%)',
                data: @json($valores),
                borderColor: '#1c6ef3',
                backgroundColor: 'rgba(28, 110, 243, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Percentual Acumulado (%)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Itens (Ordenados por valor decrescente)'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw.toFixed(2) + '%';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection