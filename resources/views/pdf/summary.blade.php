<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo do Orçamento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #90caf9;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #333;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            margin-top: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #90caf9;
            color: white;
            font-weight: bold;
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .categoria-row {
            background-color: #e3f2fd;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .grand-total {
            font-size: 16px;
            color: #28a745;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
        }
        .info-box table {
            width: 50%;
            float: right;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PROJECTO DE REQUALIFICAÇÃO COM EXPANSÃO - ATL BOQUISSO</h1>
        <h2>Resumo Geral do Orçamento</h2>
        <p>Data de geração: {{ $data_geracao }}</p>
    </div>

    <div class="info-box clearfix">
        <div style="float: left; width: 48%;">
            <table style="width: 100%;">
                <tr>
                    <td><strong>Total de Categorias:</strong></td>
                    <td class="text-right">{{ count($categorias) }}</td>
                </tr>
                <tr>
                    <td><strong>Total de Itens:</strong></td>
                    <td class="text-right">{{ $totalItens }}</td>
                </tr>
                <tr>
                    <td><strong>IVA:</strong></td>
                    <td class="text-right">{{ $iva }}%</td>
                </tr>
                <tr>
                    <td><strong>Contingências:</strong></td>
                    <td class="text-right">{{ $contingencia }}%</td>
                </tr>
            </table>
        </div>
    </div>

    <table>
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
                    <td class="text-center">{{ $categoria->codigo }}</td>
                    <td>{{ $categoria->nome }}</td>
                    <td class="text-center">{{ $categoria->itens->count() }}</td>
                    <td class="text-right">{{ number_format($subtotais[$categoria->id] ?? 0, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 50%; float: right; margin-top: 20px;">
        <tr class="total-row">
            <td><strong>SUB TOTAL A</strong></td>
            <td class="text-right">{{ number_format($subTotalA, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>IVA ({{ $iva }}%)</strong></td>
            <td class="text-right">{{ number_format($valorIva, 2, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td><strong>SUB TOTAL B</strong></td>
            <td class="text-right">{{ number_format($subTotalB, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>CONTINGÊNCIAS ({{ $contingencia }}%)</strong></td>
            <td class="text-right">{{ number_format($valorContingencias, 2, ',', '.') }}</td>
        </tr>
        <tr style="background-color: #e3f2fd;">
            <td><strong>GRAND TOTAL</strong></td>
            <td class="text-right grand-total">{{ number_format($grandTotal, 2, ',', '.') }}</td>
        </tr>
    </table>

    <div class="clearfix"></div>

    <div class="footer">
        <p>Documento gerado pelo Sistema de Orçamentos - ATL Boquisso</p>
        <p>Documento válido apenas com assinatura digital</p>
    </div>
</body>
</html>