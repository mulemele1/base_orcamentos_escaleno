<?php

namespace App\Http\Controllers;

use App\Models\ComposicaoCusto;
use App\Models\Subatividade;
use App\Models\Material;
use Illuminate\Http\Request;

class ComposicaoCustoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lista composições por subatividade.
     */
    public function index(Request $request)
    {
        $subatividadeId = $request->get('subatividade_id');
        $subatividades = Subatividade::with('atividade.categoriaObra')->orderBy('atividade_id')->orderBy('codigo')->get();

        $composicoes = ComposicaoCusto::with('subatividade.atividade.categoriaObra', 'material')
            ->when($subatividadeId, function ($query, $subatividadeId) {
                return $query->where('subatividade_id', $subatividadeId);
            })
            ->paginate(20);

        return view('composicoes.index', compact('composicoes', 'subatividades', 'subatividadeId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $subatividades = Subatividade::with('atividade.categoriaObra')->orderBy('atividade_id')->orderBy('codigo')->get();
        $materiais = Material::orderBy('categoria')->orderBy('nome')->get();
        $subatividadeId = $request->get('subatividade_id');

        return view('composicoes.create', compact('subatividades', 'materiais', 'subatividadeId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subatividade_id' => 'required|exists:subatividades,id',
            'material_id' => 'required|exists:materiais,id',
            'quantidade' => 'required|numeric|min:0',
            'unidade' => 'required|string|max:10',
            'custo_unitario' => 'nullable|numeric|min:0',
            'tipo' => 'required|in:material,mao_obra,equipamento',
            'mao_obra_percentual' => 'nullable|numeric|min:0|max:100',
        ]);

        $composicao = new ComposicaoCusto($request->all());
        
        // Se não forneceu custo unitário, pegar da base de preços
        if (!$request->filled('custo_unitario') && $request->material_id) {
            $material = Material::find($request->material_id);
            $composicao->custo_unitario = $material->valor_compra;
        }

        $composicao->save();

        return redirect()->route('composicoes.index', ['subatividade_id' => $request->subatividade_id])
            ->with('success', 'Material vinculado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComposicaoCusto $composicao)
    {
        $subatividades = Subatividade::with('atividade.categoriaObra')->orderBy('atividade_id')->orderBy('codigo')->get();
        $materiais = Material::orderBy('categoria')->orderBy('nome')->get();
        
        return view('composicoes.edit', compact('composicao', 'subatividades', 'materiais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComposicaoCusto $composicao)
    {
        $request->validate([
            'subatividade_id' => 'required|exists:subatividades,id',
            'material_id' => 'required|exists:materiais,id',
            'quantidade' => 'required|numeric|min:0',
            'unidade' => 'required|string|max:10',
            'custo_unitario' => 'nullable|numeric|min:0',
            'tipo' => 'required|in:material,mao_obra,equipamento',
            'mao_obra_percentual' => 'nullable|numeric|min:0|max:100',
        ]);

        $composicao->update($request->all());

        return redirect()->route('composicoes.index', ['subatividade_id' => $composicao->subatividade_id])
            ->with('success', 'Composição atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComposicaoCusto $composicao)
    {
        $subatividadeId = $composicao->subatividade_id;
        $composicao->delete();

        return redirect()->route('composicoes.index', ['subatividade_id' => $subatividadeId])
            ->with('success', 'Material removido com sucesso!');
    }

    /**
     * Buscar dados do material para preencher formulário via AJAX
     */
    public function getMaterialData($id)
    {
        $material = Material::find($id);
        if (!$material) {
            return response()->json(['error' => 'Material não encontrado'], 404);
        }

        return response()->json([
            'id' => $material->id,
            'unidade' => $material->unidade,
            'valor_compra' => $material->valor_compra,
        ]);
    }
}