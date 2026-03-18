<?php

namespace App\Http\Controllers;

use App\Models\CategoriaObra;
use App\Models\ItemOrcamento;
use App\Models\Material;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function recuperar(Request $request)
    {
        // Dados para os cards
        $totalCategorias = CategoriaObra::count();
        $totalItens = ItemOrcamento::count();
        $totalMateriais = Material::count();
        
        // Valor total do orçamento
        $totalOrcamento = ItemOrcamento::sum('total');
        
        // Buscar configurações
        $iva = Configuracao::getValor('iva', 16);
        $contingencia = Configuracao::getValor('contingencia', 8);
        
        // Calcular totais com impostos
        $valorIva = $totalOrcamento * ($iva / 100);
        $valorContingencias = ($totalOrcamento + $valorIva) * ($contingencia / 100);
        $grandTotal = $totalOrcamento + $valorIva + $valorContingencias;

        // Dados para o gráfico de pizza por categoria
        $categorias = CategoriaObra::with('itens')->get();
        $categoriaLabels = [];
        $categoriaValores = [];
        $categoriaCores = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
            '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#36A2EB'
        ];
        
        foreach ($categorias as $index => $categoria) {
            $total = $categoria->itens->sum('total');
            if ($total > 0) {
                $categoriaLabels[] = $categoria->nome;
                $categoriaValores[] = $total;
            }
        }

        // Top 10 itens mais caros
        $topItens = ItemOrcamento::with('categoria')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Distribuição por unidade
        $unidades = ItemOrcamento::select('unidade', DB::raw('count(*) as total'))
            ->groupBy('unidade')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Dados mensais (fictícios - você pode ajustar conforme sua necessidade)
        $meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        $valoresMensais = [];
        for ($i = 0; $i < 12; $i++) {
            $valoresMensais[] = ItemOrcamento::whereMonth('created_at', $i + 1)->sum('total');
        }

        return view('home', compact(
            'totalCategorias',
            'totalItens',
            'totalMateriais',
            'totalOrcamento',
            'iva',
            'contingencia',
            'valorIva',
            'valorContingencias',
            'grandTotal',
            'categoriaLabels',
            'categoriaValores',
            'categoriaCores',
            'topItens',
            'unidades',
            'meses',
            'valoresMensais'
        ));
    }
}