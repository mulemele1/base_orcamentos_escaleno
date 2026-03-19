<?php

namespace App\Http\Controllers;

use App\Models\Subatividade;
use App\Models\Atividade;
use App\Models\Material;
use Illuminate\Http\Request;

class SubatividadeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lista subatividades por atividade.
     */
    public function index(Request $request)
    {
        $atividadeId = $request->get('atividade_id');
        $atividades = Atividade::with('categoriaObra')->orderBy('categoria_obra_id')->orderBy('codigo')->get();

        $subatividades = Subatividade::with('atividade.categoriaObra')
            ->when($atividadeId, function ($query, $atividadeId) {
                return $query->where('atividade_id', $atividadeId);
            })
            ->orderBy('atividade_id')
            ->orderBy('ordem')
            ->orderBy('codigo')
            ->paginate(20);

        return view('subatividades.index', compact('subatividades', 'atividades', 'atividadeId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $atividades = Atividade::with('categoriaObra')->orderBy('categoria_obra_id')->orderBy('codigo')->get();
        $atividadeId = $request->get('atividade_id');
        return view('subatividades.create', compact('atividades', 'atividadeId'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'quantidade_proposta' => 'nullable|numeric|min:0',
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

        // 🔥 FIX: Definir ordem como 0 se não foi enviado
    $data = $request->all();
    if (!isset($data['ordem']) || $data['ordem'] === null) {
        $data['ordem'] = 0;
    }

        // Criar a subatividade
        $subatividade = new Subatividade();
        $subatividade->fill($request->all());

        // Calcular valores automaticamente
        $subatividade->recalcular();

        $subatividade->save();

        return redirect()->route('subatividades.show', $subatividade->id)
            ->with('success', 'Subatividade criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subatividade $subatividade)
    {
        $subatividade->load('atividade.categoriaObra', 'composicaoCustos.material');
        
        // Recalcular antes de mostrar para garantir dados atualizados
        $subatividade->recalcular();
        
        return view('subatividades.show', compact('subatividade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subatividade $subatividade)
    {
        $atividades = Atividade::with('categoriaObra')->orderBy('categoria_obra_id')->orderBy('codigo')->get();
        return view('subatividades.edit', compact('subatividade', 'atividades'));
    }

    /**
     * Update the specified resource in storage.
     */
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
            'quantidade_proposta' => 'nullable|numeric|min:0',
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
        $subatividade->recalcular(); // Recalcula elementar, parcial e quantidade proposta
        $subatividade->save();

        return redirect()->route('subatividades.show', $subatividade->id)
            ->with('success', 'Subatividade atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subatividade $subatividade)
    {
        $atividadeId = $subatividade->atividade_id;

        // Verificar se existem composições de custo
        if ($subatividade->composicaoCustos()->count() > 0) {
            return redirect()->route('subatividades.index', ['atividade_id' => $atividadeId])
                ->with('error', 'Não é possível excluir esta subatividade pois existem materiais vinculados. Remova-os primeiro.');
        }

        $subatividade->delete();

        return redirect()->route('subatividades.index', ['atividade_id' => $atividadeId])
            ->with('success', 'Subatividade excluída com sucesso!');
    }

    /**
     * API para recalcular via AJAX (opcional, para usar com JavaScript)
     */
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