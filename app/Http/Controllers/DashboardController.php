<?php

namespace App\Http\Controllers;

use App\Models\CategoriaObra;
use App\Models\ItemOrcamento;      // Mantendo a estrutura existente
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
        $iva = Configuracao::get('iva', 16);
        $contingencia = Configuracao::get('contingencia', 8);
        
        // Converter para float
        $iva = floatval($iva);
        $contingencia = floatval($contingencia);
        
        // Calcular totais com impostos
        $valorIva = $totalOrcamento * ($iva / 100);
        $subTotalB = $totalOrcamento + $valorIva;
        $valorContingencias = $subTotalB * ($contingencia / 100);
        $grandTotal = $subTotalB + $valorContingencias;

        // 🔥 CORREÇÃO: Itens com material (verificando se material_id não é nulo)
        $itensComMaterial = ItemOrcamento::whereNotNull('material_id')->count();
        
        // Preço médio dos materiais
        $precoMedioMaterial = Material::avg('valor_compra') ?? 0;
        
        // Categorias de materiais
        $categoriasMaterial = Material::select('categoria')->distinct()->count();

        // Dados para o gráfico de pizza por categoria
        $categorias = CategoriaObra::with('itens')->get();
        $categoriaLabels = [];
        $categoriaValores = [];
        $categoriaCores = $this->gerarCores($categorias->count());
        
        foreach ($categorias as $categoria) {
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
            ->get();

        // Dados mensais
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
            'subTotalB',
            'valorContingencias',
            'grandTotal',
            'itensComMaterial',
            'precoMedioMaterial',
            'categoriasMaterial',
            'categoriaLabels',
            'categoriaValores',
            'categoriaCores',
            'topItens',
            'unidades',
            'meses',
            'valoresMensais'
        ));
    }

    private function gerarCores($quantidade)
    {
        $cores = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                  '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#36A2EB'];
        
        while (count($cores) < $quantidade) {
            $cores[] = '#' . substr(md5(rand()), 0, 6);
        }
        
        return array_slice($cores, 0, $quantidade);
    }
}