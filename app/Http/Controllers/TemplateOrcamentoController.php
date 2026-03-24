<?php

namespace App\Http\Controllers;

use App\Models\TemplateOrcamento;
use App\Models\Orcamento;
use App\Models\Projeto;
use Illuminate\Http\Request;

class TemplateOrcamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Listar templates
     */
    public function index(Request $request)
    {
        $query = TemplateOrcamento::with('user')
            ->where(function($q) {
                $q->where('user_id', auth()->id())
                  ->orWhere('publico', true);
            });
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%");
            });
        }
        
        $templates = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Carregar projetos para o modal de aplicar template
        $projetos = Projeto::where('user_id', auth()->id())
            ->orderBy('nome')
            ->get();
        
        return view('templates.index', compact('templates', 'projetos'));
    }

    /**
     * Formulário para criar template
     */
    public function create()
    {
        $orcamentos = Orcamento::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('templates.create', compact('orcamentos'));
    }

    /**
     * Salvar template a partir de um orçamento existente
     */
    public function store(Request $request)
    {
        $request->validate([
            'orcamento_id' => 'required|exists:orcamentos,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'publico' => 'boolean',
            'tipo_projeto' => 'nullable|string|max:100',
        ]);
        
        $orcamento = Orcamento::findOrFail($request->orcamento_id);
        
        $template = TemplateOrcamento::salvarDoOrcamento(
            $orcamento,
            $request->nome,
            $request->descricao,
            $request->publico ?? false,
            $request->tipo_projeto
        );
        
        return redirect()->route('templates.index')
            ->with('success', 'Template criado com sucesso!');
    }

    /**
     * Visualizar template
     */
    public function show($id)
    {
        $template = TemplateOrcamento::findOrFail($id);
        
        return view('templates.show', compact('template'));
    }

    /**
     * Editar template
     */
    public function edit($id)
    {
        $template = TemplateOrcamento::findOrFail($id);
        
        // Verificar permissão
        if ($template->user_id != auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }
        
        return view('templates.edit', compact('template'));
    }

    /**
     * Atualizar template
     */
    public function update(Request $request, $id)
    {
        $template = TemplateOrcamento::findOrFail($id);
        
        // Verificar permissão
        if ($template->user_id != auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }
        
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'publico' => 'boolean',
            'tipo_projeto' => 'nullable|string|max:100',
        ]);
        
        $template->update([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'publico' => $request->publico ?? false,
            'tipo_projeto' => $request->tipo_projeto,
        ]);
        
        return redirect()->route('templates.show', $template->id)
            ->with('success', 'Template atualizado com sucesso!');
    }

    /**
     * Deletar template
     */
    public function destroy($id)
    {
        $template = TemplateOrcamento::findOrFail($id);
        
        // Verificar permissão
        if ($template->user_id != auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }
        
        $template->delete();
        
        return redirect()->route('templates.index')
            ->with('success', 'Template removido com sucesso!');
    }

    /**
     * Aplicar template a um projeto
     */
    public function aplicar(Request $request, $id)
    {
        $request->validate([
            'projeto_id' => 'required|exists:projetos,id',
        ]);
        
        $template = TemplateOrcamento::findOrFail($id);
        $projeto = Projeto::findOrFail($request->projeto_id);
        
        try {
            $orcamento = $template->criarOrcamento($projeto);
            
            return redirect()->route('orcamentos.show', $orcamento->id)
                ->with('success', 'Template aplicado com sucesso!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao aplicar template: ' . $e->getMessage());
        }
    }
}