<?php

namespace App\Http\Controllers;

use App\Models\CategoriaObra;
use App\Models\Atividade;
use App\Models\Subatividade;
use App\Models\Material;
use App\Models\Orcamento;
use App\Models\Projeto;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function recuperar(Request $request)
    {
        // ========== DADOS DE PROJETOS ==========
        $totalProjetos = Projeto::count();
        $projetosAtivos = Projeto::whereIn('status', ['planeamento', 'em_andamento'])->count();
        $projetosConcluidos = Projeto::where('status', 'concluido')->count();
        
        // ========== DADOS DE ORÇAMENTOS ==========
        $orcamento = Orcamento::with(['orcamentoAtividades.atividade.subatividades.composicaoCustos.material'])
            ->latest()
            ->first();
        
        // ========== DADOS DOS CARDS ==========
        
        // Categorias com atividades (que têm subatividades)
        $categoriasComAtividades = CategoriaObra::has('atividades.subatividades')->get();
        $totalCategorias = $categoriasComAtividades->count();
        
        // Total de subatividades (itens de orçamento)
        $totalItens = Subatividade::count();
        
        // Total de materiais (base de preços)
        $totalMateriais = Material::count();
        
        // Valor total do orçamento (soma de todas as subatividades)
        $totalOrcamento = Subatividade::get()->sum('total');
        
        // Itens com material (subatividades que têm composições)
        $itensComMaterial = Subatividade::has('composicaoCustos')->count();
        
        // Preço médio dos materiais
        $precoMedioMaterial = Material::avg('valor_compra') ?? 0;
        
        // Categorias de materiais (distintas)
        $categoriasMaterial = Material::select('categoria')->distinct()->count();
        
        // ========== CONFIGURAÇÕES ==========
        $iva = Configuracao::get('iva', 16);
        $contingencia = Configuracao::get('contingencia', 8);
        $iva = floatval($iva);
        $contingencia = floatval($contingencia);
        
        // ========== CÁLCULOS DE IMPOSTOS ==========
        $valorIva = $totalOrcamento * ($iva / 100);
        $subTotalB = $totalOrcamento + $valorIva;
        $valorContingencias = $subTotalB * ($contingencia / 100);
        $grandTotal = $subTotalB + $valorContingencias;
        
        // ========== GRÁFICO POR CATEGORIA ==========
        
        $categoriaLabels = [];
        $categoriaValores = [];
        $categoriaCores = $this->gerarCores($categoriasComAtividades->count());
        
        foreach ($categoriasComAtividades as $categoria) {
            $totalCategoria = 0;
            foreach ($categoria->atividades as $atividade) {
                foreach ($atividade->subatividades as $sub) {
                    $totalCategoria += $sub->total;
                }
            }
            if ($totalCategoria > 0) {
                $categoriaLabels[] = $categoria->codigo . ' - ' . $categoria->nome;
                $categoriaValores[] = $totalCategoria;
            }
        }
        
        // ========== TOP 10 ITENS MAIS CAROS ==========
        
        $todasSubatividades = Subatividade::with('atividade.categoriaObra')
            ->get();
        
        $topItens = $todasSubatividades->sortByDesc(function($sub) {
            return $sub->total;
        })->take(10)->map(function($sub) {
            $sub->item = $sub->codigo;
            $sub->descricao = $sub->nome;
            $sub->categoria = $sub->atividade->categoriaObra ?? null;
            return $sub;
        });
        
        // ========== DISTRIBUIÇÃO POR UNIDADE ==========
        
        $unidades = Subatividade::select('unidade', DB::raw('count(*) as total'))
            ->groupBy('unidade')
            ->orderBy('total', 'desc')
            ->get();
        
        // ========== DADOS MENSAIS ==========
        
        $meses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        $valoresMensais = [];
        
        // Buscar valores mensais baseados no created_at das subatividades
        for ($i = 0; $i < 12; $i++) {
            $valoresMensais[] = Subatividade::whereMonth('created_at', $i + 1)
                ->whereYear('created_at', date('Y'))
                ->get()
                ->sum(function($sub) {
                    return $sub->total;
                });
        }
        
        // Se não houver dados mensais, usar dados do orçamento distribuídos igualmente
        $temDadosMensais = array_sum($valoresMensais) > 0;
        if (!$temDadosMensais && $totalOrcamento > 0) {
            $valorPorMes = $totalOrcamento / 12;
            for ($i = 0; $i < 12; $i++) {
                $valoresMensais[$i] = $valorPorMes;
            }
        }
        
        // ========== TOP 5 CATEGORIAS ==========
        
        $top5Categorias = array_slice($categoriaLabels, 0, 5);
        $top5Valores = array_slice($categoriaValores, 0, 5);
        
        // ========== EVOLUÇÃO MENSAL ==========
        
        $evolucaoMensal = [];
        for ($i = 0; $i < 12; $i++) {
            $evolucaoMensal[] = $valoresMensais[$i] ?? 0;
        }
        
        return view('home', compact(
            'totalProjetos',
            'projetosAtivos',
            'projetosConcluidos',
            'orcamento',
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
            'valoresMensais',
            'top5Categorias',
            'top5Valores',
            'evolucaoMensal'
        ));
    }

    private function gerarCores($quantidade)
    {
        $cores = ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                  '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#36A2EB',
                  '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                  '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#36A2EB'];
        
        while (count($cores) < $quantidade) {
            $cores[] = '#' . substr(md5(rand()), 0, 6);
        }
        
        return array_slice($cores, 0, $quantidade);
    }
}