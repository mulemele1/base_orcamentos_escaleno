<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $categoria->nome }} - Itens de Orçamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 16px;
        }
        .header h2 {
            margin: 5px 0 0;
            color: #7f8c8d;
            font-size: 14px;
            font-weight: normal;
        }
        .info {
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
            padding: 8px;
            text-align: left;
            font-size: 9px;
        }
        td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .total-row {
            background-color: #e9ecef;
            font-weight: bold;
        }
        .total-row td {
            padding: 8px;
            border-top: 2px solid #333;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
        <h2>{{ $categoria->nome }} - Lista de Itens</h2>
    </div>

    <div class="info">
        <p><strong>Código:</strong> {{ $categoria->codigo }}</p>
        <p><strong>Data de Geração:</strong> {{ $data_geracao }}</p>
        <p><strong>Total de Itens:</strong> {{ $itens->count() }}</p>
        <p><strong>Valor Subtotal:</strong> MT {{ number_format($subtotal, 2, ',', '.') }}</p>
    </div>

    @if($itens->count() > 0)
    <table>
        <thead>
            <tr>
                <th width="5%">Item</th>
                <th width="30%">Descrição</th>
                <th width="8%">Unid.</th>
                <th width="8%">NPI</th>
                <th width="6%">Comp.</th>
                <th width="6%">Larg.</th>
                <th width="6%">Alt.</th>
                <th width="8%">Quant.</th>
                <th width="11%">Preço Unit.</th>
                <th width="12%">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($itens as $item)
            <tr>
                <td>{{ $item->item }}</td>
                <td>{{ $item->descricao }}</td>
                <td>{{ $item->unidade }}</td>
                <td>{{ $item->npi ?? '-' }}</td>
                <td>{{ $item->comprimento ?? '-' }}</td>
                <td>{{ $item->largura ?? '-' }}</td>
                <td>{{ $item->altura ?? '-' }}</td>
                <td class="text-right">{{ number_format($item->quantidade_proposta, 2, ',', '.') }}</td>
                <td class="text-right">MT {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                <td class="text-right">MT {{ number_format($item->total, 2, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="9" class="text-right"><strong>Subtotal:</strong></td>
                <td class="text-right"><strong>MT {{ number_format($subtotal, 2, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
    @else
    <p style="text-align: center; color: #999;">Nenhum item encontrado para esta categoria.</p>
    @endif

    <div class="footer">
        <p>Documento gerado em {{ $data_geracao }} - {{ config('app.name') }} - Todos os direitos reservados</p>
        <p>Página {PAGE_NUM} de {PAGE_COUNT}</p>
    </div>
</body>
</html>