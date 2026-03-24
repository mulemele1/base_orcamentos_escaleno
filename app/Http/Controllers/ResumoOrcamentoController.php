<?php

namespace App\Http\Controllers;

use App\Models\CategoriaObra;
use App\Models\Configuracao;
use App\Models\Orcamento;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ResumoOrcamentoController extends Controller
{
    public function index(Request $request)
    {
        \$orcamento = Orcamento::with(['orcamentoAtividades.atividade.subatividades.composicaoCustos'])
            ->latest()
            ->first();

        if (!\$orcamento) {
            return redirect()->route('projetos.index')
                ->with('error', 'Nenhum orçamento encontrado.');
        }

        \$categorias = CategoriaObra::with(['atividades.subatividades'])->orderBy('ordem')->orderBy('codigo')->get();

        \$subtotais = [];
        \$totalGeral = 0;
        \$categoriasComItens = [];
        \$totalItens = 0;

        foreach (\$categorias as \$categoria) {
            \$subtotal = 0;
            \$qtdItens = 0;
            
            foreach (\$categoria->atividades as \$atividade) {
                foreach (\$atividade->subatividades as \$sub) {
                    \$subtotal += \$sub->total;
                    \$qtdItens++;
                }
            }
            
            if (\$subtotal > 0) {
                \$subtotais[\$categoria->id] = \$subtotal;
                \$totalGeral += \$subtotal;
                \$categoriasComItens[] = \$categoria;
                \$totalItens += \$qtdItens;
            }
        }

        \$iva = Configuracao::get('iva') ?? 16;
        \$contingencia = Configuracao::get('contingencia') ?? 8;
        \$iva = floatval(\$iva);
        \$contingencia = floatval(\$contingencia);

        \$subTotalA = \$totalGeral;
        \$valorIva = \$subTotalA * (\$iva / 100);
        \$subTotalB = \$subTotalA + \$valorIva;
        \$valorContingencias = \$subTotalB * (\$contingencia / 100);
        \$grandTotal = \$subTotalB + \$valorContingencias;

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

    public function exportPdf(Request \$request)
    {
        return redirect()->back()->with('info', 'PDF em desenvolvimento');
    }

    public function exportExcel(Request \$request)
    {
        return redirect()->back()->with('info', 'Excel em desenvolvimento');
    }
}