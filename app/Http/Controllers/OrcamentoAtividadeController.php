<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use App\Models\Atividade;
use App\Models\CategoriaObra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrcamentoAtividadeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostra a lista de atividades disponíveis e as atividades já adicionadas ao orçamento.
     */
    public function index(Orcamento $orcamento)
    {
        // Carrega as atividades já associadas a este orçamento
        $atividadesNoOrcamento = $orcamento->orcamentoAtividades()
            ->with('atividade.categoriaObra')
            ->get();

        // Carrega todas as atividades disponíveis, agrupadas por categoria
        $categorias = CategoriaObra::with(['atividades' => function ($query) {
            $query->orderBy('ordem')->orderBy('codigo');
        }])->orderBy('ordem')->get();

        return view('orcamentos.atividades', compact('orcamento', 'atividadesNoOrcamento', 'categorias'));
    }

    /**
     * Adiciona uma atividade ao orçamento.
     */
    public function store(Request $request, Orcamento $orcamento)
    {
        $request->validate([
            'atividade_id' => 'required|exists:atividades,id',
        ]);

        $atividade = Atividade::findOrFail($request->atividade_id);

        // Verifica se a atividade já foi adicionada
        $existe = $orcamento->orcamentoAtividades()
            ->where('atividade_id', $atividade->id)
            ->exists();

        if ($existe) {
            return redirect()->back()->with('error', 'Esta atividade já foi adicionada ao orçamento.');
        }

        // Adiciona a atividade ao orçamento
        $orcamento->orcamentoAtividades()->create([
            'atividade_id' => $atividade->id,
            'categoria_obra_id' => $atividade->categoria_obra_id,
            'subtotal' => 0,
        ]);

        return redirect()->route('orcamentos.atividades.index', $orcamento->id)
            ->with('success', 'Atividade adicionada com sucesso!');
    }

    /**
     * Remove uma atividade do orçamento.
     */
    public function destroy(Orcamento $orcamento, $atividadeId)
    {
        $orcamento->orcamentoAtividades()
            ->where('atividade_id', $atividadeId)
            ->delete();

        return redirect()->route('orcamentos.atividades.index', $orcamento->id)
            ->with('success', 'Atividade removida com sucesso!');
    }
}