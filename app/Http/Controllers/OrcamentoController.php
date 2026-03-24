<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\Projeto;
use App\Models\CategoriaObra;
use App\Models\Atividade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrcamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Listar todos os orçamentos
     */
    public function index(Request $request)
    {
        $query = Orcamento::with(['projeto', 'user'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('nome_projeto', 'like', "%{$search}%")
                  ->orWhere('cliente', 'like', "%{$search}%");
            });
        }

        $orcamentos = $query->paginate(15);
        $statuses = ['rascunho', 'em_analise', 'aprovado', 'rejeitado'];

        return view('orcamentos.index', compact('orcamentos', 'statuses'));
    }

    /**
     * Visualizar orçamento
     */
    // app/Http/Controllers/OrcamentoController.php

public function show($id)
{
    $orcamento = Orcamento::with([
        'projeto',
        'user',
        'orcamentoAtividades.atividade.subatividades.composicaoCustos.material',
        'orcamentoAtividades.categoriaObra'
    ])->findOrFail($id);

    // Organizar os dados hierarquicamente, filtrando apenas categorias com atividades
    $dadosHierarquicos = [];
    
    foreach ($orcamento->orcamentoAtividades as $oa) {
        $categoriaId = $oa->categoria_obra_id;
        $categoria = $oa->categoriaObra;
        
        if (!isset($dadosHierarquicos[$categoriaId])) {
            $dadosHierarquicos[$categoriaId] = [
                'categoria' => $categoria,
                'atividades' => []
            ];
        }
        
        $atividade = $oa->atividade;
        $atividade->subtotal = $oa->subtotal;
        
        // Calcular total da atividade baseado nas subatividades
        $totalAtividade = 0;
        foreach ($atividade->subatividades as $sub) {
            $totalAtividade += $sub->total;
        }
        $atividade->total_calculado = $totalAtividade;
        
        $dadosHierarquicos[$categoriaId]['atividades'][] = $atividade;
    }
    
    // Carregar todas as categorias para o modal de adicionar
    $todasCategorias = CategoriaObra::orderBy('ordem')->get();
    
    // Carregar todas as atividades para os modais
    $todasAtividades = Atividade::with('categoriaObra')->orderBy('categoria_obra_id')->orderBy('codigo')->get();
    
     // Carregar materiais para o modal
    $materiais = \App\Models\Material::orderBy('categoria')->orderBy('nome')->get();
    
    return view('orcamentos.show', compact('orcamento', 'dadosHierarquicos', 'todasCategorias', 'todasAtividades', 'materiais'));
}

    /**
     * Formulário para criar novo orçamento
     */
    public function create()
    {
        $projetos = Projeto::orderBy('nome')->get();
        $categorias = CategoriaObra::orderBy('ordem')->get();
        $atividades = Atividade::with('subatividades')->get();

        return view('orcamentos.create', compact('projetos', 'categorias', 'atividades'));
    }

    /**
     * Salvar novo orçamento
     */
    public function store(Request $request)
    {
        $request->validate([
            'projeto_id' => 'required|exists:projetos,id',
            'nome_projeto' => 'required|string|max:255',
            'cliente' => 'required|string|max:255',
            'localizacao' => 'required|string|max:255',
            'data_validade' => 'nullable|date',
            'iva_percentual' => 'nullable|numeric|min:0|max:100',
            'contingencia_percentual' => 'nullable|numeric|min:0|max:100',
        ]);

        try {
            $projeto = Projeto::findOrFail($request->projeto_id);
            
            $orcamento = new Orcamento();
            $orcamento->projeto_id = $projeto->id;
            $orcamento->codigo = Orcamento::gerarCodigo();
            $orcamento->versao = 1;
            $orcamento->nome_projeto = $request->nome_projeto;
            $orcamento->cliente = $request->cliente;
            $orcamento->localizacao = $request->localizacao;
            $orcamento->data_emissao = now();
            $orcamento->data_validade = $request->data_validade;
            $orcamento->status = 'rascunho';
            $orcamento->iva_percentual = $request->iva_percentual ?? 16;
            $orcamento->contingencia_percentual = $request->contingencia_percentual ?? 8;
            $orcamento->user_id = auth()->id();
            $orcamento->subtotal = 0;
            $orcamento->valor_iva = 0;
            $orcamento->valor_contingencia = 0;
            $orcamento->grand_total = 0;
            $orcamento->save();

            return redirect()->route('orcamentos.edit', $orcamento->id)
                ->with('success', 'Orçamento criado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao criar orçamento: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Editar orçamento
     */
    public function edit($id)
    {
        $orcamento = Orcamento::with([
            'projeto',
            'orcamentoAtividades.atividade.subatividades.composicaoCustos'
        ])->findOrFail($id);

        $categorias = CategoriaObra::orderBy('ordem')->get();
        $atividades = Atividade::with('subatividades.composicaoCustos.material')->get();

        return view('orcamentos.edit', compact('orcamento', 'categorias', 'atividades'));
    }

    /**
     * Atualizar orçamento
     */
    public function update(Request $request, $id)
    {
        $orcamento = Orcamento::findOrFail($id);

        $request->validate([
            'nome_projeto' => 'required|string|max:255',
            'cliente' => 'required|string|max:255',
            'localizacao' => 'nullable|string',
            'data_validade' => 'nullable|date',
            'observacoes' => 'nullable|string',
        ]);

        try {
            $orcamento->update([
                'nome_projeto' => $request->nome_projeto,
                'cliente' => $request->cliente,
                'localizacao' => $request->localizacao,
                'data_validade' => $request->data_validade,
                'observacoes' => $request->observacoes,
            ]);

            return redirect()->route('orcamentos.show', $orcamento->id)
                ->with('success', 'Orçamento atualizado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar orçamento: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Deletar orçamento
     */
    public function destroy($id)
    {
        $orcamento = Orcamento::findOrFail($id);

        try {
            $orcamento->delete();

            return redirect()->route('orcamentos.index')
                ->with('success', 'Orçamento removido com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao remover orçamento: ' . $e->getMessage());
        }
    }

    /**
     * Calcular orçamento
     */
    public function calcular($id)
    {
        $orcamento = Orcamento::with('orcamentoAtividades.atividade.subatividades.composicaoCustos')
            ->findOrFail($id);

        DB::beginTransaction();
        try {
            $subtotal = 0;

            foreach ($orcamento->orcamentoAtividades as $oa) {
                $totalAtividade = 0;

                foreach ($oa->atividade->subatividades as $subatividade) {
                    // Calcular quantidade proposta
                    $elementar = $subatividade->comprimento * $subatividade->largura * $subatividade->altura ?: 
                                 $subatividade->comprimento * $subatividade->largura ?:
                                 $subatividade->comprimento ?: 1;
                    
                    $parcial = $subatividade->npi * $elementar;
                    $quantidadeProposta = $parcial * (1 + ($subatividade->perda_percentual / 100));
                    
                    // Calcular custo total da subatividade
                    $custoTotal = 0;
                    foreach ($subatividade->composicaoCustos as $comp) {
                        $custoUnitario = $comp->material ? $comp->material->valor_compra : $comp->custo_unitario;
                        $custo = $quantidadeProposta * $comp->quantidade * $custoUnitario;
                        $custoTotal += $custo;
                    }
                    
                    $totalAtividade += $custoTotal;
                }
                
                $oa->subtotal = $totalAtividade;
                $oa->save();
                $subtotal += $totalAtividade;
            }

            // Calcular impostos
            $valorIva = $subtotal * ($orcamento->iva_percentual / 100);
            $valorContingencia = ($subtotal + $valorIva) * ($orcamento->contingencia_percentual / 100);
            $grandTotal = $subtotal + $valorIva + $valorContingencia;

            // Atualizar orçamento
            $orcamento->subtotal = $subtotal;
            $orcamento->valor_iva = $valorIva;
            $orcamento->valor_contingencia = $valorContingencia;
            $orcamento->grand_total = $grandTotal;
            $orcamento->save();

            DB::commit();

            return redirect()->route('orcamentos.show', $orcamento->id)
                ->with('success', 'Orçamento calculado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erro ao calcular orçamento: ' . $e->getMessage());
        }
    }

    /**
     * Alterar status do orçamento
     */
    public function alterarStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:rascunho,em_analise,aprovado,rejeitado',
        ]);

        $orcamento = Orcamento::findOrFail($id);
        $orcamento->status = $request->status;
        $orcamento->save();

        return redirect()->route('orcamentos.show', $orcamento->id)
            ->with('success', 'Status atualizado para: ' . $orcamento->status);
    }

    /**
     * Exportar para PDF
     */
    public function exportarPdf($id)
    {
        $orcamento = Orcamento::with([
            'projeto',
            'user',
            'orcamentoAtividades.atividade.subatividades.composicaoCustos.material',
            'orcamentoAtividades.categoriaObra'
        ])->findOrFail($id);

        $atividadesPorCategoria = $orcamento->orcamentoAtividades->groupBy('categoria_obra_id');

        $pdf = Pdf::loadView('orcamentos.pdf', compact('orcamento', 'atividadesPorCategoria'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('orcamento_' . $orcamento->codigo . '.pdf');
    }

    /**
     * Exportar para Excel
     */
    public function exportarExcel($id)
    {
        // Temporário: redirecionar com mensagem
        return redirect()->back()->with('info', 'Exportação Excel em desenvolvimento');
    }

    /**
     * Adicionar atividade ao orçamento
     */
    public function adicionarAtividade(Request $request, $id)
    {
        $request->validate([
            'atividade_id' => 'required|exists:atividades,id',
            'categoria_obra_id' => 'required|exists:categorias_obra,id',
        ]);

        $orcamento = Orcamento::findOrFail($id);

        // Verificar se já existe
        $existe = $orcamento->orcamentoAtividades()
            ->where('atividade_id', $request->atividade_id)
            ->exists();

        if ($existe) {
            return redirect()->back()->with('error', 'Atividade já adicionada ao orçamento.');
        }

        $orcamento->orcamentoAtividades()->create([
            'atividade_id' => $request->atividade_id,
            'categoria_obra_id' => $request->categoria_obra_id,
            'subtotal' => 0,
        ]);

        return redirect()->route('orcamentos.edit', $orcamento->id)
            ->with('success', 'Atividade adicionada com sucesso!');
    }

    /**
     * Remover atividade do orçamento
     */
    public function removerAtividade($orcamentoId, $atividadeId)
    {
        $orcamento = Orcamento::findOrFail($orcamentoId);
        
        $orcamento->orcamentoAtividades()
            ->where('atividade_id', $atividadeId)
            ->delete();

        return redirect()->route('orcamentos.edit', $orcamento->id)
            ->with('success', 'Atividade removida com sucesso!');
    }
}