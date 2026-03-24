<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\TemplateOrcamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjetoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Listar todos os projetos
     */
    public function index(Request $request)
    {
        $query = Projeto::with(['user'])->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('cliente', 'like', "%{$search}%")
                  ->orWhere('localizacao', 'like', "%{$search}%");
            });
        }

        $projetos = $query->paginate(15);
        $statuses = ['planeamento', 'em_andamento', 'concluido', 'suspenso'];

        return view('projetos.index', compact('projetos', 'statuses'));
    }

    /**
     * Formulário para criar novo projeto
     */
    public function create()
    {
        $templates = TemplateOrcamento::where('user_id', auth()->id())
            ->orWhere('publico', true)
            ->orderBy('nome')
            ->get();

        return view('projetos.create', compact('templates'));
    }

    /**
     * Salvar novo projeto
     */
    public function store(Request $request)
    {
        // Validar dados
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cliente' => 'required|string|max:255',
            'localizacao' => 'required|string|max:255',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'template_id' => 'nullable|exists:template_orcamentos,id',
            'iva' => 'nullable|numeric|min:0|max:100',
            'contingencia' => 'nullable|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            // Criar projeto
            $projeto = Projeto::create([
                'nome' => $validated['nome'],
                'cliente' => $validated['cliente'],
                'localizacao' => $validated['localizacao'],
                'data_inicio' => $validated['data_inicio'] ?? null,
                'data_fim' => $validated['data_fim'] ?? null,
                'status' => 'planeamento',
                'template_id' => $validated['template_id'] ?? null,
                'configuracoes' => [
                    'iva' => $validated['iva'] ?? 16,
                    'contingencia' => $validated['contingencia'] ?? 8,
                ],
                'user_id' => auth()->id(),
            ]);

            // Criar primeiro orçamento
            $orcamento = $projeto->criarPrimeiroOrcamento([
                'iva_percentual' => $validated['iva'] ?? 16,
                'contingencia_percentual' => $validated['contingencia'] ?? 8,
            ]);

            // Se tiver template, aplicar a estrutura
            if (!empty($validated['template_id'])) {
                $template = TemplateOrcamento::find($validated['template_id']);
                if ($template && $template->estrutura) {
                    $orcamento = $template->criarOrcamento($projeto, [
                        'iva_percentual' => $validated['iva'] ?? 16,
                        'contingencia_percentual' => $validated['contingencia'] ?? 8,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('projetos.show', $projeto->id)
                ->with('success', 'Projeto criado com sucesso!');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao criar projeto: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao criar projeto: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Visualizar detalhes do projeto
     */
    public function show($id)
    {
        $projeto = Projeto::with(['user', 'orcamentos' => function($q) {
            $q->orderBy('versao', 'desc');
        }])->findOrFail($id);

        $orcamentoAtivo = $projeto->orcamento_ativo;
        
        // Carregar templates disponíveis para aplicar
        $templates = TemplateOrcamento::where(function($q) {
            $q->where('user_id', auth()->id())
              ->orWhere('publico', true);
        })->orderBy('nome')->get();

        return view('projetos.show', compact('projeto', 'orcamentoAtivo', 'templates'));
    }

    /**
     * Formulário para editar projeto
     */
    public function edit($id)
    {
        $projeto = Projeto::findOrFail($id);
        $templates = TemplateOrcamento::where('user_id', auth()->id())
            ->orWhere('publico', true)
            ->orderBy('nome')
            ->get();

        return view('projetos.edit', compact('projeto', 'templates'));
    }

    /**
     * Atualizar projeto
     */
    public function update(Request $request, $id)
    {
        $projeto = Projeto::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cliente' => 'required|string|max:255',
            'localizacao' => 'required|string|max:255',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'status' => 'required|in:planeamento,em_andamento,concluido,suspenso',
        ]);

        try {
            $projeto->update($validated);

            return redirect()->route('projetos.show', $projeto->id)
                ->with('success', 'Projeto atualizado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar projeto: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Deletar projeto
     */
    public function destroy($id)
    {
        $projeto = Projeto::findOrFail($id);

        try {
            $projeto->delete();

            return redirect()->route('projetos.index')
                ->with('success', 'Projeto removido com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao remover projeto: ' . $e->getMessage());
        }
    }

    /**
     * Gerar nova versão do orçamento
     */
    public function novaVersao($id)
    {
        $projeto = Projeto::findOrFail($id);

        try {
            $novoOrcamento = $projeto->novaVersao();

            if (!$novoOrcamento) {
                return redirect()->back()
                    ->with('error', 'Não foi possível criar nova versão. Crie um orçamento primeiro.');
            }

            return redirect()->route('orcamentos.edit', $novoOrcamento->id)
                ->with('success', 'Nova versão do orçamento criada com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao criar nova versão: ' . $e->getMessage());
        }
    }
}