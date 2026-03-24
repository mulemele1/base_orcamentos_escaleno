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

    public function index(Request $request)
    {
        $subatividadeId = $request->get('subatividade_id');
        $subatividades = Subatividade::with('atividade.categoriaObra')->orderBy('atividade_id')->orderBy('codigo')->get();

        $composicoes = ComposicaoCusto::with(['subatividade.atividade.categoriaObra', 'material'])
            ->when($subatividadeId, function ($query, $subatividadeId) {
                return $query->where('subatividade_id', $subatividadeId);
            })
            ->paginate(20);

        return view('composicoes.index', compact('composicoes', 'subatividades', 'subatividadeId'));
    }

    public function create(Request $request)
    {
        $subatividades = Subatividade::with('atividade.categoriaObra')->orderBy('atividade_id')->orderBy('codigo')->get();
        $materiais = Material::orderBy('categoria')->orderBy('nome')->get();
        $subatividadeId = $request->get('subatividade_id');

        return view('composicoes.create', compact('subatividades', 'materiais', 'subatividadeId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subatividade_id' => 'required|exists:subatividades,id',
            'material_id' => 'required|exists:materiais,id',
            'quantidade' => 'required|numeric|min:0.001',
            'unidade' => 'required|string|max:10',
            'custo_unitario' => 'nullable|numeric|min:0',
            'tipo' => 'required|in:material,mao_obra,equipamento',
            'mao_obra_percentual' => 'nullable|numeric|min:0|max:100',
        ]);

        $composicao = new ComposicaoCusto();
        $composicao->subatividade_id = $request->subatividade_id;
        $composicao->material_id = $request->material_id;
        $composicao->quantidade = $request->quantidade;
        $composicao->unidade = $request->unidade;
        $composicao->tipo = $request->tipo;
        $composicao->mao_obra_percentual = $request->mao_obra_percentual ?? 0;
        
        // Se não forneceu custo unitário, pegar da base de preços
        if (!$request->filled('custo_unitario')) {
            $material = Material::find($request->material_id);
            $composicao->custo_unitario = $material->valor_compra;
        } else {
            $composicao->custo_unitario = $request->custo_unitario;
        }
        
        // 🔥 O MODEL VAI CALCULAR O CUSTO_TOTAL AUTOMATICAMENTE NO EVENTO saving
        $composicao->save();

        // 🔥 O MODEL VAI RECALCULAR A SUBATIVIDADE NO EVENTO saved

        return redirect()->route('composicoes.index', ['subatividade_id' => $request->subatividade_id])
            ->with('success', 'Material vinculado com sucesso!');
    }

    public function edit(ComposicaoCusto $composicao)
    {
        $subatividades = Subatividade::with('atividade.categoriaObra')->orderBy('atividade_id')->orderBy('codigo')->get();
        $materiais = Material::orderBy('categoria')->orderBy('nome')->get();
        
        return view('composicoes.edit', compact('composicao', 'subatividades', 'materiais'));
    }

    public function update(Request $request, ComposicaoCusto $composicao)
    {
        $request->validate([
            'subatividade_id' => 'required|exists:subatividades,id',
            'material_id' => 'required|exists:materiais,id',
            'quantidade' => 'required|numeric|min:0.001',
            'unidade' => 'required|string|max:10',
            'custo_unitario' => 'nullable|numeric|min:0',
            'tipo' => 'required|in:material,mao_obra,equipamento',
            'mao_obra_percentual' => 'nullable|numeric|min:0|max:100',
        ]);

        $composicao->subatividade_id = $request->subatividade_id;
        $composicao->material_id = $request->material_id;
        $composicao->quantidade = $request->quantidade;
        $composicao->unidade = $request->unidade;
        $composicao->tipo = $request->tipo;
        $composicao->mao_obra_percentual = $request->mao_obra_percentual ?? 0;
        
        // Se não forneceu custo unitário, pegar da base de preços
        if (!$request->filled('custo_unitario')) {
            $material = Material::find($request->material_id);
            $composicao->custo_unitario = $material->valor_compra;
        } else {
            $composicao->custo_unitario = $request->custo_unitario;
        }
        
        // 🔥 O MODEL VAI CALCULAR O CUSTO_TOTAL AUTOMATICAMENTE
        $composicao->save();

        return redirect()->route('composicoes.index', ['subatividade_id' => $composicao->subatividade_id])
            ->with('success', 'Composição atualizada com sucesso!');
    }

    public function destroy(ComposicaoCusto $composicao)
    {
        $subatividadeId = $composicao->subatividade_id;
        
        // 🔥 O MODEL VAI RECALCULAR A SUBATIVIDADE NO EVENTO deleted
        $composicao->delete();

        return redirect()->route('composicoes.index', ['subatividade_id' => $subatividadeId])
            ->with('success', 'Material removido com sucesso!');
    }

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