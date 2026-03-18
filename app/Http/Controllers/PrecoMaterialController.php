<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PrecoMaterial;
use App\Models\Material;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PrecoMaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = PrecoMaterial::with(['material', 'fornecedor'])
            ->where('estado', 'ativo');

        // Filtros
        if ($request->has('material_id') && $request->material_id != '') {
            $query->where('material_id', $request->material_id);
        }

        if ($request->has('fornecedor_id') && $request->fornecedor_id != '') {
            $query->where('fornecedor_id', $request->fornecedor_id);
        }

        if ($request->has('data_inicio') && $request->data_inicio != '') {
            $query->whereDate('data_cotacao', '>=', $request->data_inicio);
        }

        if ($request->has('data_fim') && $request->data_fim != '') {
            $query->whereDate('data_cotacao', '<=', $request->data_fim);
        }

        $precos = $query->orderBy('data_cotacao', 'desc')->paginate(20);
        
        $materiais = Material::orderBy('nome')->get();
        $fornecedores = Fornecedor::orderBy('nome')->get();

        return view('admin.precos.index', compact('precos', 'materiais', 'fornecedores'));
    }

    public function create()
    {
        $materiais = Material::orderBy('nome')->get();
        $fornecedores = Fornecedor::orderBy('nome')->get();
        
        $unidades = ['saco', 'm³', 'kg', 'un', 'rolo', 'm', 'm²', 'l', 'caixa', 'pacote'];
        
        return view('admin.precos.create', compact('materiais', 'fornecedores', 'unidades'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'material_id' => 'required|exists:materiais,id',
            'fornecedor_id' => 'required|exists:fornecedores,id',
            'preco' => 'required|numeric|min:0',
            'unidade_compra' => 'required|string',
            'quantidade_compra' => 'required|numeric|min:0.01',
            'data_cotacao' => 'required|date',
            'referencia' => 'nullable|string|max:100',
            'observacoes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Desativar preço anterior do mesmo material/fornecedor (se existir)
        PrecoMaterial::where('material_id', $request->material_id)
            ->where('fornecedor_id', $request->fornecedor_id)
            ->update(['estado' => 'historico']);

        // Criar novo preço
        PrecoMaterial::create([
            'material_id' => $request->material_id,
            'fornecedor_id' => $request->fornecedor_id,
            'preco' => $request->preco,
            'unidade_compra' => $request->unidade_compra,
            'quantidade_compra' => $request->quantidade_compra,
            'data_cotacao' => $request->data_cotacao,
            'referencia' => $request->referencia,
            'observacoes' => $request->observacoes,
            'estado' => 'ativo'
        ]);

        return redirect()->route('admin.precos.index')
            ->with('success', 'Preço cadastrado com sucesso!');
    }

    public function edit(PrecoMaterial $preco)
    {
        $materiais = Material::orderBy('nome')->get();
        $fornecedores = Fornecedor::orderBy('nome')->get();
        $unidades = ['saco', 'm³', 'kg', 'un', 'rolo', 'm', 'm²', 'l', 'caixa', 'pacote'];
        
        return view('admin.precos.edit', compact('preco', 'materiais', 'fornecedores', 'unidades'));
    }

    public function update(Request $request, PrecoMaterial $preco)
    {
        $validator = Validator::make($request->all(), [
            'material_id' => 'required|exists:materiais,id',
            'fornecedor_id' => 'required|exists:fornecedores,id',
            'preco' => 'required|numeric|min:0',
            'unidade_compra' => 'required|string',
            'quantidade_compra' => 'required|numeric|min:0.01',
            'data_cotacao' => 'required|date',
            'referencia' => 'nullable|string|max:100',
            'observacoes' => 'nullable|string',
            'estado' => 'required|in:ativo,historico'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $preco->update($request->all());

        return redirect()->route('admin.precos.index')
            ->with('success', 'Preço atualizado com sucesso!');
    }

    public function destroy(PrecoMaterial $preco)
    {
        $preco->delete();

        return redirect()->route('admin.precos.index')
            ->with('success', 'Preço removido com sucesso!');
    }

    // Função especial: cadastro rápido via AJAX
    public function storeAjax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'material_id' => 'required',
            'fornecedor_id' => 'required',
            'preco' => 'required|numeric',
            'data_cotacao' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Desativar anterior
        PrecoMaterial::where('material_id', $request->material_id)
            ->where('fornecedor_id', $request->fornecedor_id)
            ->update(['estado' => 'historico']);

        // Criar novo
        $preco = PrecoMaterial::create([
            'material_id' => $request->material_id,
            'fornecedor_id' => $request->fornecedor_id,
            'preco' => $request->preco,
            'unidade_compra' => $request->unidade_compra ?? $request->unidade_padrao,
            'quantidade_compra' => $request->quantidade_compra ?? 1,
            'data_cotacao' => $request->data_cotacao,
            'referencia' => $request->referencia,
            'estado' => 'ativo'
        ]);

        return response()->json([
            'success' => true,
            'preco' => $preco->load('fornecedor')
        ]);
    }

    // Dashboard de preços
    public function dashboard()
    {
        $totalPrecos = PrecoMaterial::count();
        $precosAtivos = PrecoMaterial::where('estado', 'ativo')->count();
        
        // Últimos 10 preços cadastrados
        $ultimosPrecos = PrecoMaterial::with(['material', 'fornecedor'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Estatísticas por material
        $materiaisMaisCotados = PrecoMaterial::select('material_id', DB::raw('count(*) as total'))
            ->with('material')
            ->groupBy('material_id')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();
        
        // Variação de preços nos últimos 30 dias
        $dataLimite = now()->subDays(30);
        $variacoes = PrecoMaterial::where('data_cotacao', '>=', $dataLimite)
            ->select('material_id', DB::raw('MIN(preco) as menor, MAX(preco) as maior, AVG(preco) as media'))
            ->with('material')
            ->groupBy('material_id')
            ->having('menor', '<', 'maior')
            ->limit(10)
            ->get();

        return view('admin.precos.dashboard', compact(
            'totalPrecos', 'precosAtivos', 'ultimosPrecos', 
            'materiaisMaisCotados', 'variacoes'
        ));
    }
}