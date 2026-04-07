<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\Orcamento;
use App\Models\OrcamentoItem;
use App\Models\PrecoMaterial;
use App\Models\PrecoHistorico;
use App\Models\Configuracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrcamentoExport;

class OrcamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Gerar orçamento a partir das medições
     */
    public function gerar(Projeto $projeto, Request $request)
    {
        $this->authorize('view', $projeto);
        
        // Verificar se há medições
        $medicoes = $projeto->medicoes()->with('componente')->get();
        
        if ($medicoes->isEmpty()) {
            return redirect()->route('medicoes.dashboard', $projeto)
                ->with('error', 'Não há medições para gerar orçamento. Adicione medições primeiro.');
        }
        
        // Buscar preços dos materiais
        $precosMateriais = PrecoMaterial::with('categoria')->orderBy('nome')->get();
        
        // Buscar configurações de IVA e contingência
        $iva = Configuracao::get('iva', 16);
        $contingencia = Configuracao::get('contingencia', 8);
        
        // Agrupar medições por categoria
        $medicoesPorCategoria = [];
        foreach ($medicoes as $medicao) {
            $categoria = $medicao->componente->grupo?->actividade->capitulo ?? $medicao->componente->actividade->capitulo;
            $categoriaNome = $categoria->nome;
            
            if (!isset($medicoesPorCategoria[$categoriaNome])) {
                $medicoesPorCategoria[$categoriaNome] = [];
            }
            $medicoesPorCategoria[$categoriaNome][] = $medicao;
        }
        
        return view('orcamentos.gerar', compact('projeto', 'medicoes', 'medicoesPorCategoria', 'precosMateriais', 'iva', 'contingencia'));
    }
    
    /**
     * Salvar orçamento gerado
     */
    public function salvar(Projeto $projeto, Request $request)
    {
        $this->authorize('update', $projeto);
        
        $request->validate([
            'nome' => 'required|string|max:255',
            'itens' => 'required|array',
            'itens.*.medicao_id' => 'required|exists:medicoes,id',
            'itens.*.preco_material_id' => 'required|exists:precos_materiais,id',
            'itens.*.preco_unitario' => 'required|numeric|min:0',
            'iva' => 'required|numeric|min:0',
            'contingencia' => 'required|numeric|min:0',
        ]);
        
        DB::beginTransaction();
        
        try {
            $subtotal = 0;
            $itensOrcamento = [];
            
            foreach ($request->itens as $item) {
                $medicao = $projeto->medicoes()->find($item['medicao_id']);
                $total = $medicao->quantidade * $item['preco_unitario'];
                $subtotal += $total;
                
                $itensOrcamento[] = [
                    'medicao_id' => $medicao->id,
                    'preco_material_id' => $item['preco_material_id'],
                    'preco_unitario' => $item['preco_unitario'],
                    'quantidade' => $medicao->quantidade,
                    'total' => $total,
                ];
            }
            
            $valorIva = $subtotal * ($request->iva / 100);
            $subTotalB = $subtotal + $valorIva;
            $valorContingencias = $subTotalB * ($request->contingencia / 100);
            $totalGeral = $subTotalB + $valorContingencias;
            
            $orcamento = Orcamento::create([
                'projeto_id' => $projeto->id,
                'nome' => $request->nome,
                'data_orcamento' => now(),
                'subtotal' => $subtotal,
                'iva' => $valorIva,
                'contingencias' => $valorContingencias,
                'total_geral' => $totalGeral,
                'status' => 'final',
            ]);
            
            foreach ($itensOrcamento as $item) {
                OrcamentoItem::create([
                    'orcamento_id' => $orcamento->id,
                    'medicao_id' => $item['medicao_id'],
                    'preco_material_id' => $item['preco_material_id'],
                    'preco_unitario' => $item['preco_unitario'],
                    'quantidade' => $item['quantidade'],
                    'total' => $item['total'],
                ]);
            }
            
            // Atualizar status do projeto
            $projeto->update(['status' => 'concluido']);
            
            DB::commit();
            
            return redirect()->route('orcamentos.show', [$projeto, $orcamento])
                ->with('success', 'Orçamento gerado com sucesso!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao gerar orçamento: ' . $e->getMessage());
        }
    }
    
    /**
     * Visualizar orçamento
     */
    public function show(Projeto $projeto, Orcamento $orcamento)
    {
        $this->authorize('view', $projeto);
        
        $orcamento->load(['itens.medicao.componente', 'itens.precoMaterial']);
        
        return view('orcamentos.show', compact('projeto', 'orcamento'));
    }
    
    /**
     * Exportar orçamento para PDF
     */
    public function exportPdf(Projeto $projeto, Orcamento $orcamento)
    {
        $this->authorize('view', $projeto);
        
        $orcamento->load(['itens.medicao.componente', 'itens.precoMaterial']);
        
        $pdf = Pdf::loadView('orcamentos.pdf', compact('projeto', 'orcamento'));
        
        return $pdf->download("orcamento_{$projeto->nome}_{$orcamento->data_orcamento->format('d_m_Y')}.pdf");
    }
    
    /**
     * Exportar orçamento para Excel
     */
    public function exportExcel(Projeto $projeto, Orcamento $orcamento)
    {
        $this->authorize('view', $projeto);
        
        return Excel::download(new OrcamentoExport($orcamento), "orcamento_{$projeto->nome}_{$orcamento->data_orcamento->format('d_m_Y')}.xlsx");
    }
}