<?php

namespace App\Http\Controllers;

use App\Models\CategoriaObra;
use App\Models\ItemOrcamento;
use App\Models\Configuracao;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    /**
     * Generate PDF summary of all budget items
     */
    public function summary()
    {
        $categorias = CategoriaObra::with('itens')
            ->orderBy('ordem')
            ->orderBy('codigo')
            ->get();

        $subtotais = [];
        $totalGeral = 0;
        $totalItens = 0;

        foreach ($categorias as $categoria) {
            $subtotal = $categoria->itens->sum('total');
            $subtotais[$categoria->id] = $subtotal;
            $totalGeral += $subtotal;
            $totalItens += $categoria->itens->count();
        }

        $iva = Configuracao::getValor('iva', 16);
        $contingencia = Configuracao::getValor('contingencia', 8);

        $subTotalA = $totalGeral;
        $valorIva = $subTotalA * ($iva / 100);
        $subTotalB = $subTotalA + $valorIva;
        $valorContingencias = $subTotalB * ($contingencia / 100);
        $grandTotal = $subTotalB + $valorContingencias;

        $data = [
            'categorias' => $categorias,
            'subtotais' => $subtotais,
            'totalGeral' => $totalGeral,
            'totalItens' => $totalItens,
            'iva' => $iva,
            'contingencia' => $contingencia,
            'subTotalA' => $subTotalA,
            'valorIva' => $valorIva,
            'subTotalB' => $subTotalB,
            'valorContingencias' => $valorContingencias,
            'grandTotal' => $grandTotal,
            'data_geracao' => now()->format('d/m/Y H:i:s'),
        ];

        $pdf = Pdf::loadView('pdf.summary', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('resumo_orcamento_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Generate PDF for a specific category
     */
    public function categoria($id)
    {
        $categoria = CategoriaObra::with('itens')->findOrFail($id);
        
        $subtotal = $categoria->itens->sum('total');
        
        $data = [
            'categoria' => $categoria,
            'itens' => $categoria->itens,
            'subtotal' => $subtotal,
            'data_geracao' => now()->format('d/m/Y H:i:s'),
        ];

        $pdf = Pdf::loadView('pdf.categoria', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('categoria_' . $categoria->codigo . '_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Generate PDF for a specific item
     */
    public function item($id)
    {
        $item = ItemOrcamento::with('categoria', 'material')->findOrFail($id);
        
        $data = [
            'item' => $item,
            'data_geracao' => now()->format('d/m/Y H:i:s'),
        ];

        $pdf = Pdf::loadView('pdf.item', $data);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('item_' . $item->item . '_' . date('Y-m-d') . '.pdf');
    }
}