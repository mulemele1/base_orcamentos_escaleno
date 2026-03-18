<?php

namespace App\Http\Controllers;

use App\Models\CategoriaObra;
use App\Models\Configuracao;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    /**
     * Display the summary of all budget items.
     */
    public function index()
    {
        $categorias = CategoriaObra::with('itens')
            ->orderBy('ordem')
            ->orderBy('codigo')
            ->get();

        $subtotais = [];
        $totalGeral = 0;

        foreach ($categorias as $categoria) {
            $subtotal = $categoria->itens->sum('total');
            $subtotais[$categoria->id] = $subtotal;
            $totalGeral += $subtotal;
        }

        $iva = Configuracao::getValor('iva', 16);
        $contingencia = Configuracao::getValor('contingencia', 8);

        $subTotalA = $totalGeral;
        $valorIva = $subTotalA * ($iva / 100);
        $subTotalB = $subTotalA + $valorIva;
        $valorContingencias = $subTotalB * ($contingencia / 100);
        $grandTotal = $subTotalB + $valorContingencias;

        return view('summary.index', compact(
            'categorias',
            'subtotais',
            'totalGeral',
            'iva',
            'contingencia',
            'subTotalA',
            'valorIva',
            'subTotalB',
            'valorContingencias',
            'grandTotal'
        ));
    }

    /**
     * Export summary to PDF (opcional)
     */
    public function exportPdf()
    {
        return redirect()->back()->with('info', 'Funcionalidade em desenvolvimento');
    }

    /**
     * Export summary to Excel (opcional)
     */
    public function exportExcel()
    {
        return redirect()->back()->with('info', 'Funcionalidade em desenvolvimento');
    }
}