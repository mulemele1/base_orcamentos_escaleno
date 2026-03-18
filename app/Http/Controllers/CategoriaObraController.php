<?php

namespace App\Http\Controllers;

use App\Models\CategoriaObra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriaObraController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function list(Request $request)
    {
        $query = CategoriaObra::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('codigo', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%");
            });
        }

        $categorias = $query->orderBy('ordem')->orderBy('codigo')->paginate(15);

        return view('categorias-obra.list', compact('categorias'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('categorias-obra.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'codigo' => 'required|string|unique:categorias_obra,codigo|max:50', // CORRIGIDO
        'nome' => 'required|string|max:255',
        'ordem' => 'required|integer|min:0',
        'descricao' => 'nullable|string'
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        CategoriaObra::create([
            'codigo' => $request->codigo,
            'nome' => $request->nome,
            'ordem' => $request->ordem,
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('categorias-obra.list')
            ->with('success', 'Categoria criada com sucesso!');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Erro ao criar categoria: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Display the specified category.
     */
    public function show($id)
    {
        $categoria = CategoriaObra::with('itens')->findOrFail($id);
        return view('categorias-obra.show', compact('categoria'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit($id)
    {
        $categoria = CategoriaObra::findOrFail($id);
        return view('categorias-obra.edit', compact('categoria'));
    }

    /**
     * Update the specified category in storage.
     */
   public function update(Request $request, $id)
{
    $categoria = CategoriaObra::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'codigo' => 'required|string|unique:categorias_obra,codigo,' . $id . '|max:50', // CORRIGIDO
        'nome' => 'required|string|max:255',
        'ordem' => 'required|integer|min:0',
        'descricao' => 'nullable|string'
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    try {
        $categoria->update([
            'codigo' => $request->codigo,
            'nome' => $request->nome,
            'ordem' => $request->ordem,
            'descricao' => $request->descricao,
        ]);

        return redirect()->route('categorias-obra.list')
            ->with('success', 'Categoria atualizada com sucesso!');

    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Erro ao atualizar categoria: ' . $e->getMessage())
            ->withInput();
    }
}

    /**
     * Remove the specified category from storage.
     */
    public function destroy($id)
    {
        try {
            $categoria = CategoriaObra::findOrFail($id);
            
            if ($categoria->itens()->count() > 0) {
                return redirect()->route('categorias-obra.list')
                    ->with('error', 'Não é possível excluir: existem itens vinculados a esta categoria.');
            }
            
            $categoria->delete();

            return redirect()->route('categorias-obra.list')
                ->with('success', 'Categoria removida com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao remover categoria: ' . $e->getMessage());
        }
    }
}