<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Fornecedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FornecedorController extends Controller
{
    /**
     * Display a listing of the resource (LIST em vez de index)
     */
    public function list(Request $request)
    {
        $query = Fornecedor::query();

        // Busca por nome ou localização
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('localizacao', 'like', "%{$search}%")
                  ->orWhere('tipo', 'like', "%{$search}%");
            });
        }

        // Filtro por tipo
        if ($request->has('tipo') && $request->tipo != '') {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por status (se houver campo status)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $fornecedores = $query->orderBy('nome')->paginate(15);
        
        // Estatísticas
        $totalFornecedores = Fornecedor::count();
        $tipos = Fornecedor::select('tipo', \DB::raw('count(*) as total'))
            ->groupBy('tipo')
            ->get();

        return view('fornecedores.list', compact('fornecedores', 'totalFornecedores', 'tipos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipos = [
            'ferragem' => 'Ferragem',
            'betoneira' => 'Betoneira',
            'construcao' => 'Construção',
            'madeira' => 'Madeira',
            'agregados' => 'Agregados',
            'eletrico' => 'Elétrico',
            'hidraulico' => 'Hidráulico',
            'diversos' => 'Diversos'
        ];
        
        return view('fornecedores.create', compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255|unique:fornecedores,nome',
            'localizacao' => 'nullable|string|max:255',
            'contacto' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'tipo' => 'nullable|string|max:50',
            'nuit' => 'nullable|string|max:20',
            'status' => 'nullable|in:ativo,inativo'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Fornecedor::create([
            'nome' => $request->nome,
            'localizacao' => $request->localizacao,
            'contacto' => $request->contacto,
            'email' => $request->email,
            'website' => $request->website,
            'tipo' => $request->tipo ?? 'diversos',
            'nuit' => $request->nuit,
            'status' => $request->status ?? 'ativo'
        ]);

        return redirect()->route('fornecedores.list')
            ->with('success', 'Fornecedor cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $fornecedor = Fornecedor::with('precos.material')->findOrFail($id);
        
        // Estatísticas do fornecedor
        $totalPrecos = $fornecedor->precos()->count();
        $precosAtivos = $fornecedor->precos()->where('estado', 'ativo')->count();
        $ultimosPrecos = $fornecedor->precos()->with('material')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('fornecedores.show', compact('fornecedor', 'totalPrecos', 'precosAtivos', 'ultimosPrecos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        
        $tipos = [
            'ferragem' => 'Ferragem',
            'betoneira' => 'Betoneira',
            'construcao' => 'Construção',
            'madeira' => 'Madeira',
            'agregados' => 'Agregados',
            'eletrico' => 'Elétrico',
            'hidraulico' => 'Hidráulico',
            'diversos' => 'Diversos'
        ];
        
        return view('fornecedores.edit', compact('fornecedor', 'tipos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $fornecedor = Fornecedor::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255|unique:fornecedores,nome,' . $id,
            'localizacao' => 'nullable|string|max:255',
            'contacto' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'tipo' => 'nullable|string|max:50',
            'nuit' => 'nullable|string|max:20',
            'status' => 'nullable|in:ativo,inativo'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $fornecedor->update($request->all());

        return redirect()->route('fornecedores.list')
            ->with('success', 'Fornecedor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        
        // Verificar se tem preços associados
        if ($fornecedor->precos()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Não é possível excluir: fornecedor possui preços cadastrados. Desative-o em vez de excluir.');
        }

        $fornecedor->delete();

        return redirect()->route('fornecedores.list')
            ->with('success', 'Fornecedor removido com sucesso!');
    }

    /**
     * Toggle status (ativar/desativar)
     */
    public function toggleStatus($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        $fornecedor->status = $fornecedor->status == 'ativo' ? 'inativo' : 'ativo';
        $fornecedor->save();

        return redirect()->back()
            ->with('success', 'Status do fornecedor alterado com sucesso!');
    }
}