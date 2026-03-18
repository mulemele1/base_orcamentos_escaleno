<?php

namespace App\Http\Controllers;

use App\Models\ItemOrcamento;
use App\Models\CategoriaObra;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Exports\ItensOrcamentoExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemOrcamentoController extends Controller
{
    /**
     * Display a listing of items for a specific category.
     */
  /**
 * Display a listing of items for a specific category.
 */
public function list(Request $request, $categoria_id = null)
{
    if (!$categoria_id) {
        $categorias = CategoriaObra::orderBy('ordem')->orderBy('codigo')->get();
        return view('itens-orcamento.selecionar-categoria', compact('categorias'));
    }

    $categoria = CategoriaObra::findOrFail($categoria_id);
    $query = ItemOrcamento::where('categoria_obra_id', $categoria_id);

    // Busca por termo
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('item', 'like', "%{$search}%")
              ->orWhere('descricao', 'like', "%{$search}%")
              ->orWhere('comentarios', 'like', "%{$search}%");
        });
    }

    // Ordenação - NOVO CÓDIGO
    $ordenarPor = $request->get('ordenar_por', 'item');
    $ordenarDir = $request->get('ordenar_dir', 'asc');
    
    // Validar se a coluna existe para evitar erros
    $colunasPermitidas = ['item', 'descricao', 'total', 'created_at'];
    if (!in_array($ordenarPor, $colunasPermitidas)) {
        $ordenarPor = 'item';
    }
    
    $ordenarDir = in_array(strtolower($ordenarDir), ['asc', 'desc']) ? $ordenarDir : 'asc';
    
    $query->orderBy($ordenarPor, $ordenarDir);

    $itens = $query->paginate(15)->withQueryString();
    $subtotal = $itens->sum('total');

    return view('itens-orcamento.list', compact('itens', 'categoria', 'subtotal'));
}

    /**
     * Show the form for creating a new item.
     */
    public function create($categoria_id)
    {
        $categoria = CategoriaObra::findOrFail($categoria_id);
        $materiais = Material::orderBy('categoria')->orderBy('nome')->get();
        $unidades = ['m²', 'm³', 'un', 'ml', 'Vg', 'kg', 'l', 'saco', 'rolo', 'caixa', 'pacote', 'jogo', 'par'];
        
        return view('itens-orcamento.create', compact('categoria', 'materiais', 'unidades'));
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoria_obra_id' => 'required|exists:categorias_obra,id',
            'item' => 'required|string|max:50',
            'descricao' => 'required|string|max:255',
            'unidade' => 'required|string|max:20',
            'npi' => 'nullable|integer|min:1',
            'comprimento' => 'nullable|numeric|min:0',
            'largura' => 'nullable|numeric|min:0',
            'altura' => 'nullable|numeric|min:0',
            'perdas' => 'nullable|numeric|min:0|max:100',
            'quantidade_proposta' => 'required|numeric|min:0',
            'custo_fornecimento' => 'nullable|numeric|min:0',
            'custo_mao_obra' => 'nullable|numeric|min:0',
            'preco_unitario' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'comentarios' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $elementar = null;
            $parcial = null;
            
            if ($request->comprimento && $request->largura && $request->altura) {
                $elementar = $request->comprimento * $request->largura * $request->altura;
            } elseif ($request->comprimento && $request->largura) {
                $elementar = $request->comprimento * $request->largura;
            } elseif ($request->comprimento) {
                $elementar = $request->comprimento;
            }
            
            if ($elementar && $request->npi) {
                $parcial = $elementar * $request->npi;
            }

            ItemOrcamento::create([
                'categoria_obra_id' => $request->categoria_obra_id,
                'material_id' => $request->material_id,
                'item' => $request->item,
                'descricao' => $request->descricao,
                'unidade' => $request->unidade,
                'npi' => $request->npi,
                'comprimento' => $request->comprimento,
                'largura' => $request->largura,
                'altura' => $request->altura,
                'elementar' => $elementar,
                'parcial' => $parcial,
                'perdas' => $request->perdas ?? 1,
                'quantidade_proposta' => $request->quantidade_proposta,
                'custo_fornecimento' => $request->custo_fornecimento,
                'custo_mao_obra' => $request->custo_mao_obra,
                'preco_unitario' => $request->preco_unitario,
                'total' => $request->total,
                'comentarios' => $request->comentarios,
            ]);

            return redirect()->route('itens-orcamento.list', ['categoria_id' => $request->categoria_obra_id])
                ->with('success', 'Item adicionado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao adicionar item: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit($id)
    {
        $item = ItemOrcamento::findOrFail($id);
        $categoria = CategoriaObra::findOrFail($item->categoria_obra_id);
        $materiais = Material::orderBy('categoria')->orderBy('nome')->get();
        $unidades = ['m²', 'm³', 'un', 'ml', 'Vg', 'kg', 'l', 'saco', 'rolo', 'caixa', 'pacote', 'jogo', 'par'];
        
        return view('itens-orcamento.edit', compact('item', 'categoria', 'materiais', 'unidades'));
    }

    /**
     * Update the specified item in storage.
     */
    public function update(Request $request, $id)
    {
        $item = ItemOrcamento::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'item' => 'required|string|max:50',
            'descricao' => 'required|string|max:255',
            'unidade' => 'required|string|max:20',
            'npi' => 'nullable|integer|min:1',
            'comprimento' => 'nullable|numeric|min:0',
            'largura' => 'nullable|numeric|min:0',
            'altura' => 'nullable|numeric|min:0',
            'perdas' => 'nullable|numeric|min:0|max:100',
            'quantidade_proposta' => 'required|numeric|min:0',
            'custo_fornecimento' => 'nullable|numeric|min:0',
            'custo_mao_obra' => 'nullable|numeric|min:0',
            'preco_unitario' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'comentarios' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $elementar = null;
            $parcial = null;
            
            if ($request->comprimento && $request->largura && $request->altura) {
                $elementar = $request->comprimento * $request->largura * $request->altura;
            } elseif ($request->comprimento && $request->largura) {
                $elementar = $request->comprimento * $request->largura;
            } elseif ($request->comprimento) {
                $elementar = $request->comprimento;
            }
            
            if ($elementar && $request->npi) {
                $parcial = $elementar * $request->npi;
            }

            $item->update([
                'material_id' => $request->material_id,
                'item' => $request->item,
                'descricao' => $request->descricao,
                'unidade' => $request->unidade,
                'npi' => $request->npi,
                'comprimento' => $request->comprimento,
                'largura' => $request->largura,
                'altura' => $request->altura,
                'elementar' => $elementar,
                'parcial' => $parcial,
                'perdas' => $request->perdas ?? 1,
                'quantidade_proposta' => $request->quantidade_proposta,
                'custo_fornecimento' => $request->custo_fornecimento,
                'custo_mao_obra' => $request->custo_mao_obra,
                'preco_unitario' => $request->preco_unitario,
                'total' => $request->total,
                'comentarios' => $request->comentarios,
            ]);

            return redirect()->route('itens-orcamento.list', ['categoria_id' => $item->categoria_obra_id])
                ->with('success', 'Item atualizado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar item: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy($id)
    {
        try {
            $item = ItemOrcamento::findOrFail($id);
            $categoria_id = $item->categoria_obra_id;
            $item->delete();

            return redirect()->route('itens-orcamento.list', ['categoria_id' => $categoria_id])
                ->with('success', 'Item removido com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao remover item: ' . $e->getMessage());
        }
    }


    /**
 * Duplicate an existing item
 */
public function duplicate($id)
{
    try {
        $item = ItemOrcamento::findOrFail($id);
        $novoItem = $item->replicate();
        $novoItem->item = $item->item . '-copia';
        $novoItem->created_at = now();
        $novoItem->updated_at = now();
        $novoItem->save();

        return redirect()->route('itens-orcamento.list', ['categoria_id' => $item->categoria_obra_id])
            ->with('success', 'Item duplicado com sucesso!');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Erro ao duplicar item: ' . $e->getMessage());
    }
}


/**
 * Export items to Excel
 */
public function export($categoria_id)
{
    try {
        $categoria = CategoriaObra::findOrFail($categoria_id);
        
        return Excel::download(
            new ItensOrcamentoExport($categoria_id), 
            'itens_' . $categoria->codigo . '_' . date('Y-m-d') . '.xlsx'
        );

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Erro ao exportar: ' . $e->getMessage());
    }
}

    /**
     * Calculate values based on dimensions and quantities (AJAX)
     */
    public function calcular(Request $request)
    {
        $npi = $request->npi ?? 1;
        $comprimento = $request->comprimento ?? 0;
        $largura = $request->largura ?? 0;
        $altura = $request->altura ?? 0;
        $perdas = $request->perdas ?? 1;
        $preco_unitario = $request->preco_unitario ?? 0;

        if ($comprimento && $largura && $altura) {
            $elementar = $comprimento * $largura * $altura;
        } elseif ($comprimento && $largura) {
            $elementar = $comprimento * $largura;
        } elseif ($comprimento) {
            $elementar = $comprimento;
        } else {
            $elementar = 0;
        }

        $parcial = $elementar * $npi;
        $quantidade_proposta = $parcial * $perdas;
        $total = $quantidade_proposta * $preco_unitario;

        return response()->json([
            'elementar' => number_format($elementar, 2, ',', '.'),
            'parcial' => number_format($parcial, 2, ',', '.'),
            'quantidade_proposta' => number_format($quantidade_proposta, 2, ',', '.'),
            'total' => number_format($total, 2, ',', '.'),
            'total_raw' => $total
        ]);
    }
}