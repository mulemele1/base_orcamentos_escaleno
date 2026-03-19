<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use App\Models\CategoriaObra;
use Illuminate\Http\Request;

class AtividadeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lista atividades por categoria.
     */
    public function index(Request $request)
{
    $categoriaId = $request->get('categoria_id');
    $categorias = CategoriaObra::orderBy('ordem')->orderBy('codigo')->get();

    $atividades = Atividade::with('categoriaObra')
        ->withCount('subatividades')
        ->when($categoriaId, function ($query, $categoriaId) {
            return $query->where('categoria_obra_id', $categoriaId);
        })
        ->orderBy('categoria_obra_id')
        ->orderBy('ordem')
        ->orderBy('codigo')
        ->paginate(20)
        ->appends($request->query());

    return view('atividades.index', compact('atividades', 'categorias', 'categoriaId'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $categorias = CategoriaObra::orderBy('ordem')->orderBy('codigo')->get();
        $categoriaId = $request->get('categoria_id');
        return view('atividades.create', compact('categorias', 'categoriaId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:20',
            'nome' => 'required|string|max:255',
            'categoria_obra_id' => 'required|exists:categorias_obra,id',
            'unidade' => 'nullable|string|max:10',
            'npi' => 'nullable|integer|min:1',
            'ordem' => 'nullable|integer',
        ]);

        // Verificar se o código já existe na categoria
        $existe = Atividade::where('codigo', $request->codigo)
            ->where('categoria_obra_id', $request->categoria_obra_id)
            ->exists();

        if ($existe) {
            return redirect()->back()->withInput()
                ->with('error', 'Já existe uma atividade com este código nesta categoria.');
        }

        Atividade::create($request->all());

        return redirect()->route('atividades.index', ['categoria_id' => $request->categoria_obra_id])
            ->with('success', 'Atividade criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Atividade $atividade)
    {
        $atividade->load('categoriaObra', 'subatividades');
        return view('atividades.show', compact('atividade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Atividade $atividade)
    {
        $categorias = CategoriaObra::orderBy('ordem')->orderBy('codigo')->get();
        return view('atividades.edit', compact('atividade', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Atividade $atividade)
    {
        $request->validate([
            'codigo' => 'required|string|max:20',
            'nome' => 'required|string|max:255',
            'categoria_obra_id' => 'required|exists:categorias_obra,id',
            'unidade' => 'nullable|string|max:10',
            'npi' => 'nullable|integer|min:1',
            'ordem' => 'nullable|integer',
        ]);

        // Verificar se o código já existe em outra atividade da mesma categoria
        $existe = Atividade::where('codigo', $request->codigo)
            ->where('categoria_obra_id', $request->categoria_obra_id)
            ->where('id', '!=', $atividade->id)
            ->exists();

        if ($existe) {
            return redirect()->back()->withInput()
                ->with('error', 'Já existe uma atividade com este código nesta categoria.');
        }

        $atividade->update($request->all());

        return redirect()->route('atividades.index', ['categoria_id' => $atividade->categoria_obra_id])
            ->with('success', 'Atividade atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Atividade $atividade)
    {
        $categoriaId = $atividade->categoria_obra_id;

        // Verificar se existem subatividades vinculadas
        if ($atividade->subatividades()->count() > 0) {
            return redirect()->route('atividades.index', ['categoria_id' => $categoriaId])
                ->with('error', 'Não é possível excluir esta atividade pois existem subatividades vinculadas.');
        }

        $atividade->delete();

        return redirect()->route('atividades.index', ['categoria_id' => $categoriaId])
            ->with('success', 'Atividade excluída com sucesso!');
    }
}