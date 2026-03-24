<?php

namespace App\Http\Controllers;

use App\Models\CategoriaObra;
use App\Models\Configuracao;
use App\Models\Orcamento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SummaryController extends Controller
{
    /**
     * Display the summary of all budget items.
     */
    public function index(Request $request)
    {
        // Buscar o orçamento ativo (último criado) ou o que foi selecionado
        $orcamentoId = $request->get('orcamento_id');
        
        if ($orcamentoId) {
            $orcamento = Orcamento::with(['orcamentoAtividades.atividade.subatividades.composicaoCustos'])
                ->findOrFail($orcamentoId);
        } else {
            $orcamento = Orcamento::with(['orcamentoAtividades.atividade.subatividades.composicaoCustos'])
                ->latest()
                ->first();
        }
        
        if (!$orcamento) {
            return redirect()->route('projetos.index')
                ->with('error', 'Nenhum orçamento encontrado. Crie um projeto primeiro.');
        }

        // Buscar todas as categorias
        $categorias = CategoriaObra::with(['atividades.subatividades'])->orderBy('ordem')->orderBy('codigo')->get();

        // Calcular subtotais por categoria baseado nas atividades do orçamento
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

        // Buscar configurações
        $iva = Configuracao::get('iva') ?? 16;
        $contingencia = Configuracao::get('contingencia') ?? 8;

        // Converter para número (float)
        $iva = floatval($iva);
        $contingencia = floatval($contingencia);

        // Calcular totais
        $subTotalA = $totalGeral;
        $valorIva = $subTotalA * ($iva / 100);
        $subTotalB = $subTotalA + $valorIva;
        $valorContingencias = $subTotalB * ($contingencia / 100);
        $grandTotal = $subTotalB + $valorContingencias;

        // Dados para o gráfico
        $categoriaLabels = [];
        $categoriaValores = [];
        foreach ($categoriasComItens as $categoria) {
            $categoriaLabels[] = $categoria->codigo . ' - ' . $categoria->nome;
            $categoriaValores[] = $subtotais[$categoria->id];
        }

        return view('summary.index', compact(
            'orcamento',
            'categorias',
            'categoriasComItens',
            'subtotais',
            'totalGeral',
            'totalItens',
            'iva',
            'contingencia',
            'subTotalA',
            'valorIva',
            'subTotalB',
            'valorContingencias',
            'grandTotal',
            'categoriaLabels',
            'categoriaValores'
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
        
        $iva = Configuracao::get('iva') ?? 16;
        $contingencia = Configuracao::get('contingencia') ?? 8;
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