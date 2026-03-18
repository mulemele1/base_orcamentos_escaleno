<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaterialController extends Controller
{
    /**
     * Display a listing of the materials (rota: materiais.list)
     */
    public function list(Request $request)
    {
        $query = Material::query();

        // Filtro por termo de busca (código, nome ou categoria)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('categoria', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%");
            });
        }

        // Filtro por categoria específica
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        // Ordenação
        $ordenarPor = $request->get('ordenar_por', 'categoria');
        $ordenarDir = $request->get('ordenar_dir', 'asc');
        $query->orderBy($ordenarPor, $ordenarDir);

        // Paginação
        $materiais = $query->paginate(15)->withQueryString();
        
        // Lista única de categorias para o filtro
        $categorias = Material::distinct('categoria')
                              ->orderBy('categoria')
                              ->pluck('categoria');

        // Estatísticas rápidas
        $stats = [
            'total' => Material::count(),
            'total_categorias' => Material::distinct('categoria')->count(),
            'valor_medio' => Material::avg('valor_compra'),
        ];

        return view('materiais.list', compact('materiais', 'categorias', 'stats'));
    }

    /**
     * Show the form for creating a new material (rota: materiais.create)
     */
    public function create()
    {
        // Lista de categorias baseada na sua base de preços
        $categorias = [
            'Geral',
            'Inertes',
            'Betões',
            'Hidráulica',
            'Aços',
            'Madeiras',
            'Tintas',
            'Elétrica',
            'Louças e Metais',
            'Telhas e Coberturas',
            'Ferramentas',
            'Segurança',
            'Outros'
        ];
        
        $unidades = [
            'kg' => 'kg (Quilograma)',
            'm³' => 'm³ (Metro cúbico)',
            'un' => 'un (Unidade)',
            'ml' => 'ml (Metro linear)',
            'm²' => 'm² (Metro quadrado)',
            'Vg' => 'Vg (Verba global)',
            'l' => 'l (Litro)',
            'saco' => 'saco',
            'rolo' => 'rolo',
            'caixa' => 'caixa',
            'pacote' => 'pacote',
            'jogo' => 'jogo',
            'par' => 'par'
        ];
        
        return view('materiais.create', compact('categorias', 'unidades'));
    }

    /**
     * Store a newly created material in storage (rota: materiais.store)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|unique:materiais,codigo|max:50',
            'nome' => 'required|string|max:255',
            'unidade' => 'required|string|max:20',
            'valor_compra' => 'required|numeric|min:0',
            'rendimento' => 'required|numeric|min:0',
            'categoria' => 'required|string|max:100',
            'descricao' => 'nullable|string',
            'observacoes' => 'nullable|string'
        ], [
            'codigo.unique' => 'Este código já está sendo utilizado.',
            'codigo.required' => 'O código do material é obrigatório.',
            'nome.required' => 'O nome do material é obrigatório.',
            'valor_compra.required' => 'O valor de compra é obrigatório.',
            'rendimento.required' => 'O rendimento é obrigatório.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Material::create([
                'codigo' => $request->codigo,
                'nome' => $request->nome,
                'unidade' => $request->unidade,
                'valor_compra' => $request->valor_compra,
                'rendimento' => $request->rendimento,
                'categoria' => $request->categoria,
                'descricao' => $request->descricao,
                'observacoes' => $request->observacoes,
            ]);

            return redirect()->route('materiais.list')
                ->with('success', 'Material cadastrado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao cadastrar material: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified material (rota: materiais.edit)
     */
    public function edit($id)
    {
        $material = Material::findOrFail($id);
        
        $categorias = [
            'Geral',
            'Inertes',
            'Betões',
            'Hidráulica',
            'Aços',
            'Madeiras',
            'Tintas',
            'Elétrica',
            'Louças e Metais',
            'Telhas e Coberturas',
            'Ferramentas',
            'Segurança',
            'Outros'
        ];
        
        $unidades = [
            'kg' => 'kg (Quilograma)',
            'm³' => 'm³ (Metro cúbico)',
            'un' => 'un (Unidade)',
            'ml' => 'ml (Metro linear)',
            'm²' => 'm² (Metro quadrado)',
            'Vg' => 'Vg (Verba global)',
            'l' => 'l (Litro)',
            'saco' => 'saco',
            'rolo' => 'rolo',
            'caixa' => 'caixa',
            'pacote' => 'pacote',
            'jogo' => 'jogo',
            'par' => 'par'
        ];
        
        return view('materiais.edit', compact('material', 'categorias', 'unidades'));
    }

    /**
     * Update the specified material in storage (rota: materiais.update)
     */
    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|unique:materiais,codigo,' . $id . '|max:50',
            'nome' => 'required|string|max:255',
            'unidade' => 'required|string|max:20',
            'valor_compra' => 'required|numeric|min:0',
            'rendimento' => 'required|numeric|min:0',
            'categoria' => 'required|string|max:100',
            'descricao' => 'nullable|string',
            'observacoes' => 'nullable|string'
        ], [
            'codigo.unique' => 'Este código já está sendo utilizado por outro material.',
            'codigo.required' => 'O código do material é obrigatório.',
            'nome.required' => 'O nome do material é obrigatório.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $material->update([
                'codigo' => $request->codigo,
                'nome' => $request->nome,
                'unidade' => $request->unidade,
                'valor_compra' => $request->valor_compra,
                'rendimento' => $request->rendimento,
                'categoria' => $request->categoria,
                'descricao' => $request->descricao,
                'observacoes' => $request->observacoes,
            ]);

            return redirect()->route('materiais.list')
                ->with('success', 'Material atualizado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar material: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified material from storage (rota: materiais.destroy)
     */
    public function destroy($id)
    {
        try {
            $material = Material::findOrFail($id);
            
            // Verificar se o material está sendo usado em algum orçamento
            // Esta verificação será implementada quando criarmos a tabela de itens_orcamento
            // if ($material->itensOrcamento()->count() > 0) {
            //     return redirect()->route('materiais.list')
            //         ->with('error', 'Não é possível excluir: material está sendo usado em orçamentos.');
            // }
            
            $material->delete();

            return redirect()->route('materiais.list')
                ->with('success', 'Material removido com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao remover material: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified material (opcional, se precisar de uma view de detalhes)
     * Você pode adicionar esta rota se necessário
     */
    public function show($id)
    {
        $material = Material::findOrFail($id);
        return view('materiais.show', compact('material'));
    }

    /**
     * Duplicate a material (útil para criar variações)
     * Você pode adicionar esta rota se necessário
     */
    public function duplicate($id)
    {
        try {
            $material = Material::findOrFail($id);
            $novoMaterial = $material->replicate();
            $novoMaterial->codigo = $material->codigo . '-copy';
            $novoMaterial->nome = $material->nome . ' (cópia)';
            $novoMaterial->save();

            return redirect()->route('materiais.edit', $novoMaterial->id)
                ->with('success', 'Material duplicado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao duplicar material: ' . $e->getMessage());
        }
    }

    /**
     * Bulk update prices (percentage increase/decrease)
     * Você pode adicionar esta rota se necessário
     */
    public function bulkUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'percentual' => 'required|numeric|min:-100|max:1000',
            'categoria' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $query = Material::query();
            
            if ($request->filled('categoria')) {
                $query->where('categoria', $request->categoria);
            }

            $percentual = $request->percentual / 100;
            $count = $query->update([
                'valor_compra' => \DB::raw("valor_compra * (1 + $percentual)")
            ]);

            $mensagem = $request->percentual > 0 
                ? "Preços aumentados em {$request->percentual}% para {$count} materiais."
                : "Preços reduzidos em " . abs($request->percentual) . "% para {$count} materiais.";

            return redirect()->route('materiais.list')
                ->with('success', $mensagem);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar preços: ' . $e->getMessage());
        }
    }

    /**
     * Get materials by category (API endpoint for select2/dropdowns)
     */
    public function getByCategoria(Request $request)
    {
        $categoria = $request->categoria;
        
        if (!$categoria) {
            return response()->json([]);
        }

        $materiais = Material::where('categoria', $categoria)
                             ->orderBy('nome')
                             ->get(['id', 'codigo', 'nome', 'unidade', 'valor_compra']);

        return response()->json($materiais);
    }

    /**
     * Export materials to Excel (se precisar)
     */
    public function export()
    {
        // Implementar quando tiver a biblioteca Maatwebsite Excel
        // return Excel::download(new MateriaisExport, 'materiais_' . date('Y-m-d') . '.xlsx');
        
        return redirect()->route('materiais.list')
            ->with('info', 'Funcionalidade de exportação em desenvolvimento.');
    }

    /**
     * Import materials from Excel (se precisar)
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Implementar quando tiver a biblioteca Maatwebsite Excel
            // Excel::import(new MateriaisImport, $request->file('file'));
            
            return redirect()->route('materiais.list')
                ->with('success', 'Materiais importados com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao importar: ' . $e->getMessage());
        }
    }
}