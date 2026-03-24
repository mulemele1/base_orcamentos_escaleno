<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelatorioCurvaABCController extends Controller
{
    // app/Http/Controllers/RelatorioCurvaABCController.php

public function index(Request $request)
{
    $orcamentoId = $request->get('orcamento_id');
    $orcamento = Orcamento::findOrFail($orcamentoId);
    
    // Buscar todas as subatividades com seus valores
    $itens = [];
    foreach ($orcamento->orcamentoAtividades as $oa) {
        foreach ($oa->atividade->subatividades as $sub) {
            $itens[] = [
                'nome' => $sub->codigo . ' - ' . $sub->nome,
                'categoria' => $oa->categoriaObra->nome,
                'valor' => $sub->total,
            ];
        }
    }
    
    // Ordenar por valor decrescente
    usort($itens, function($a, $b) {
        return $b['valor'] <=> $a['valor'];
    });
    
    // Calcular percentuais acumulados
    $total = array_sum(array_column($itens, 'valor'));
    $acumulado = 0;
    $labels = [];
    $valores = [];
    
    foreach ($itens as $index => &$item) {
        $acumulado += $item['valor'];
        $percentual = ($acumulado / $total) * 100;
        $item['percentual_acumulado'] = $percentual;
        
        // Classificação ABC
        if ($percentual <= 80) {
            $item['classificacao'] = 'A';
        } elseif ($percentual <= 95) {
            $item['classificacao'] = 'B';
        } else {
            $item['classificacao'] = 'C';
        }
        
        $labels[] = $index + 1;
        $valores[] = round($percentual, 2);
    }
    
    return view('relatorios.curva-abc', compact('itens', 'labels', 'valores'));
}
}
