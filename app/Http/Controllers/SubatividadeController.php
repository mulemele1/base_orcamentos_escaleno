<?php

namespace App\Http\Controllers;

use App\Models\Subatividade;
use App\Models\Atividade;
use Illuminate\Http\Request;

class SubatividadeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $atividadeId = $request->get('atividade_id');
        $atividades = Atividade::with('categoriaObra')->orderBy('categoria_obra_id')->orderBy('codigo')->get();

        $subatividades = Subatividade::with(['atividade.categoriaObra', 'composicaoCustos'])
            ->when($atividadeId, function ($query, $atividadeId) {
                return $query->where('atividade_id', $atividadeId);
            })
            ->orderBy('atividade_id')
            ->orderBy('ordem')
            ->orderBy('codigo')
            ->paginate(20);

        return view('subatividades.index', compact('subatividades', 'atividades', 'atividadeId'));
    }

    public function create(Request $request)
    {
        $atividades = Atividade::with('categoriaObra')->orderBy('categoria_obra_id')->orderBy('codigo')->get();
        $atividadeId = $request->get('atividade_id');
        return view('subatividades.create', compact('atividades', 'atividadeId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:20',
            'nome' => 'required|string|max:255',
            'unidade' => 'required|string|max:10',
            'atividade_id' => 'required|exists:atividades,id',
            'npi' => 'nullable|integer|min:1',
            'comprimento' => 'nullable|numeric|min:0',
            'largura' => 'nullable|numeric|min:0',
            'altura' => 'nullable|numeric|min:0',
            'perda_percentual' => 'nullable|numeric|min:0|max:100',
            'descricao' => 'nullable|string',
            'ordem' => 'nullable|integer',
        ]);

        // Verificar código único na atividade
        $existe = Subatividade::where('codigo', $request->codigo)
            ->where('atividade_id', $request->atividade_id)
            ->exists();

        if ($existe) {
            return redirect()->back()->withInput()
                ->with('error', 'Já existe uma subatividade com este código nesta atividade.');
        }

        $subatividade = new Subatividade();
        $subatividade->fill($request->all());
        
        // 🔥 USAR O MÉTODO recalcular() DO MODEL
        $subatividade->recalcular();
        
        // 🔥 NÃO PRECISA MAIS SALVAR SEPARADAMENTE, O recalcular() JÁ SALVA

        return redirect()->route('subatividades.show', $subatividade->id)
            ->with('success', 'Subatividade criada com sucesso!');
    }

    public function show(Subatividade $subatividade)
    {
        // 🔥 O MODEL JÁ CARREGA OS RELACIONAMENTOS AUTOMATICAMENTE
        $subatividade->load(['atividade.categoriaObra', 'composicaoCustos.material']);
        
        // 🔥 O método recalcular() atualiza os valores automaticamente
        $subatividade->recalcular();
        
        return view('subatividades.show', compact('subatividade'));
    }

    public function edit(Subatividade $subatividade)
    {
        $atividades = Atividade::with('categoriaObra')->orderBy('categoria_obra_id')->orderBy('codigo')->get();
        return view('subatividades.edit', compact('subatividade', 'atividades'));
    }

    public function update(Request $request, Subatividade $subatividade)
    {
        $request->validate([
            'codigo' => 'required|string|max:20',
            'nome' => 'required|string|max:255',
            'unidade' => 'required|string|max:10',
            'atividade_id' => 'required|exists:atividades,id',
            'npi' => 'nullable|integer|min:1',
            'comprimento' => 'nullable|numeric|min:0',
            'largura' => 'nullable|numeric|min:0',
            'altura' => 'nullable|numeric|min:0',
            'perda_percentual' => 'nullable|numeric|min:0|max:100',
            'descricao' => 'nullable|string',
            'ordem' => 'nullable|integer',
        ]);

        // Verificar código único
        $existe = Subatividade::where('codigo', $request->codigo)
            ->where('atividade_id', $request->atividade_id)
            ->where('id', '!=', $subatividade->id)
            ->exists();

        if ($existe) {
            return redirect()->back()->withInput()
                ->with('error', 'Já existe uma subatividade com este código nesta atividade.');
        }

        $subatividade->fill($request->all());
        
        // 🔥 USAR O MÉTODO recalcular() DO MODEL
        $subatividade->recalcular();

        return redirect()->route('subatividades.show', $subatividade->id)
            ->with('success', 'Subatividade atualizada com sucesso!');
    }

    public function destroy(Subatividade $subatividade)
    {
        $atividadeId = $subatividade->atividade_id;

        // Verificar se existem composições de custo
        if ($subatividade->composicaoCustos()->count() > 0) {
            return redirect()->route('subatividades.index', ['atividade_id' => $atividadeId])
                ->with('error', 'Não é possível excluir esta subatividade pois existem materiais vinculados.');
        }

        $subatividade->delete();

        return redirect()->route('subatividades.index', ['atividade_id' => $atividadeId])
            ->with('success', 'Subatividade excluída com sucesso!');
    }

    public function calcular(Request $request)
    {
        $request->validate([
            'npi' => 'nullable|integer|min:1',
            'comprimento' => 'nullable|numeric|min:0',
            'largura' => 'nullable|numeric|min:0',
            'altura' => 'nullable|numeric|min:0',
            'perda_percentual' => 'nullable|numeric|min:0|max:100',
        ]);

        $npi = $request->npi ?? 1;
        $comprimento = $request->comprimento;
        $largura = $request->largura;
        $altura = $request->altura;
        $perda = $request->perda_percentual ?? 0;

        // Calcular elementar
        $elementar = 1;
        if ($comprimento && $largura && $altura) {
            $elementar = $comprimento * $largura * $altura;
        } elseif ($comprimento && $largura) {
            $elementar = $comprimento * $largura;
        } elseif ($comprimento) {
            $elementar = $comprimento;
        }

        $parcial = $npi * $elementar;
        $quantidade = $parcial * (1 + ($perda / 100));

        return response()->json([
            'elementar' => number_format($elementar, 2, ',', '.'),
            'parcial' => number_format($parcial, 2, ',', '.'),
            'quantidade_proposta' => number_format($quantidade, 2, ',', '.'),
        ]);
    }
}