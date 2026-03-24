<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Orçamento {{ $orcamento->codigo }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 5px; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .total-row { background-color: #f9f9f9; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Orçamento {{ $orcamento->codigo }}</h2>
        <p>{{ $orcamento->nome_projeto }} | {{ $orcamento->cliente }}</p>
        <p>Data: {{ $orcamento->data_emissao->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
             <tr>
                <th>Código</th>
                <th>Descrição</th>
                <th>Unidade</th>
                <th>Quantidade</th>
                <th>Preço Unit.</th>
                <th>Total</th>
             </tr>
        </thead>
        <tbody>
            @foreach($atividadesPorCategoria as $categoriaId => $atividades)
                @php $categoria = $atividades->first()->categoriaObra; @endphp
                <tr style="background-color: #e9ecef;">
                    <td colspan="6"><strong>{{ $categoria->codigo }} - {{ $categoria->nome }}</strong></td>
                </tr>
                @foreach($atividades as $oa)
                    <tr>
                        <td>{{ $oa->atividade->codigo }}</td>
                        <td>{{ $oa->atividade->nome }}</td>
                        <td>{{ $oa->atividade->unidade }}</td>
                        <td class="text-right">-</td>
                        <td class="text-right">-</td>
                        <td class="text-right">MT {{ number_format($oa->subtotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endforeach
            <tr class="total-row">
                <td colspan="5" class="text-right"><strong>Subtotal</strong></td>
                <td class="text-right">MT {{ number_format($orcamento->subtotal, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">IVA ({{ $orcamento->iva_percentual }}%)</td>
                <td class="text-right">MT {{ number_format($orcamento->valor_iva, 2, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">Contingência ({{ $orcamento->contingencia_percentual }}%)</td>
                <td class="text-right">MT {{ number_format($orcamento->valor_contingencia, 2, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="5" class="text-right"><strong>GRAND TOTAL</strong></td>
                <td class="text-right"><strong>MT {{ number_format($orcamento->grand_total, 2, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>