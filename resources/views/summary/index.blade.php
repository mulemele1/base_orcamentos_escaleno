<?php

namespace App\Http\Controllers;

use App\Models\CategoriaObra;
use App\Models\Configuracao;
use App\Models\Orcamento;
use App\Models\Subatividade;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    /**
     * Display the summary of all budget items.
     */
    public function index(Request $request)
    {
        // Buscar o orçamento ativo
        $orcamento = Orcamento::with(['orcamentoAtividades.atividade.subatividades.composicaoCustos'])
            ->latest()
            ->first();

        if (!$orcamento) {
            return redirect()->route('projetos.index')
                ->with('error', 'Nenhum orçamento encontrado. Crie um projeto primeiro.');
        }

        // Buscar todas as categorias
        $categorias = CategoriaObra::with(['atividades.subatividades'])->orderBy('ordem')->orderBy('codigo')->get();

        // Calcular subtotais por categoria
        $subtotais = [];
        $totalGeral = 0;
        $categoriasComItens = [];
        $totalItens = 0;

        foreach ($categorias as $categoria) {
            $subtotal = 0;
            $qtdItens = 0;
            
            foreach ($categoria->atividades as $atividade) {
                foreach ($atividade->subatividades as $sub) {
                    $subtotal += $sub->total;
                    $qtdItens++;
                }
            }
            
            if ($subtotal > 0) {
                $subtotais[$categoria->id] = $subtotal;
                $totalGeral += $subtotal;
                $categoriasComItens[] = $categoria;
                $totalItens += $qtdItens;
            }
        }

        // Configurações
        $iva = Configuracao::get('iva', 16);
        $contingencia = Configuracao::get('contingencia', 8);
        $iva = floatval($iva);
        $contingencia = floatval($contingencia);

        // Cálculos
        $subTotalA = $totalGeral;
        $valorIva = $subTotalA * ($iva / 100);
        $subTotalB = $subTotalA + $valorIva;
        $valorContingencias = $subTotalB * ($contingencia / 100);
        $grandTotal = $subTotalB + $valorContingencias;

        return view('summary.index', compact(
            'orcamento',
            'categoriasComItens',
            'subtotais',
            'totalItens',
            'subTotalA',
            'valorIva',
            'subTotalB',
            'valorContingencias',
            'grandTotal',
            'iva',
            'contingencia'
        ));
    }

    /**
     * Export summary to PDF
     */
    public function exportPdf(Request $request)
    {
        $orcamentoId = $request->get('orcamento_id');
        
        if ($orcamentoId) {
            $orcamento = Orcamento::with(['orcamentoAtividades.atividade.subatividades.composicaoCustos.material'])
                ->findOrFail($orcamentoId);
        } else {
            $orcamento = Orcamento::with(['orcamentoAtividades.atividade.subatividades.composicaoCustos.material'])
                ->latest()
                ->first();
        }
        
        if (!$orcamento) {
            return redirect()->back()->with('error', 'Nenhum orçamento encontrado.');
        }

        $categorias = CategoriaObra::with(['atividades.subatividades'])->orderBy('ordem')->orderBy('codigo')->get();
        
        $subtotais = [];
        $totalGeral = 0;
        
        foreach ($categorias as $categoria) {
            $subtotal = 0;
            foreach ($categoria->atividades as $atividade) {
                foreach ($atividade->subatividades as $sub) {
                    $subtotal += $sub->total;
                }
            }
            if ($subtotal > 0) {
                $subtotais[$categoria->id] = $subtotal;
                $totalGeral += $subtotal;
            }
        }
        
        $iva = Configuracao::get('iva', 16);
        $contingencia = Configuracao::get('contingencia', 8);
        $iva = floatval($iva);
        $contingencia = floatval($contingencia);
        
        $subTotalA = $totalGeral;
        $valorIva = $subTotalA * ($iva / 100);
        $subTotalB = $subTotalA + $valorIva;
        $valorContingencias = $subTotalB * ($contingencia / 100);
        $grandTotal = $subTotalB + $valorContingencias;
        
        $pdf = Pdf::loadView('summary.pdf', compact(
            'orcamento', 'categorias', 'subtotais', 'totalGeral',
            'iva', 'contingencia', 'subTotalA', 'valorIva', 'subTotalB',
            'valorContingencias', 'grandTotal'
        ));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download('resumo_orcamento_' . $orcamento->codigo . '.pdf');
    }

    /**
     * Export summary to Excel
     */
    public function exportExcel(Request $request)
    {
        return redirect()->back()->with('info', 'Funcionalidade em desenvolvimento');
    }
}