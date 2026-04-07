<?php
// app/Http/Controllers/ProjetoController.php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\Componente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Lista todos os projetos do usuário
     */
    public function index()
    {
        $projetos = Projeto::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('projetos.index', compact('projetos'));
    }
    
    /**
     * Formulário para criar novo projeto
     */
    public function create()
    {
        return view('projetos.create');
    }
    
    /**
     * Salvar novo projeto
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cliente' => 'nullable|string|max:255',
            'localizacao' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'iva' => 'nullable|numeric|min:0|max:100',
            'contingencia' => 'nullable|numeric|min:0|max:100',
        ]);
        
        $validated['user_id'] = Auth::id();
        $validated['status'] = 'rascunho';
        $validated['iva'] = $validated['iva'] ?? 16;
        $validated['contingencia'] = $validated['contingencia'] ?? 8;
        
        $projeto = Projeto::create($validated);
        
        return redirect()->route('projetos.show', $projeto->id)
            ->with('success', 'Projeto criado com sucesso!');
    }
    
    /**
     * Visualizar detalhes do projeto
     */
    public function show($id)
    {
        $projeto = Projeto::with(['medicoes.componente', 'orcamentos'])->findOrFail($id);
        
        // Verificar autorização
        if ($projeto->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        // Carregar medições do projeto
        $medicoes = $projeto->medicoes()->with('componente')->get();
        
        // Calcular progresso
        $totalComponentes = Componente::count();
        $componentesMedidos = $medicoes->unique('componente_id')->count();
        $progresso = $totalComponentes > 0 ? round(($componentesMedidos / $totalComponentes) * 100) : 0;
        
        return view('projetos.show', compact('projeto', 'medicoes', 'progresso', 'componentesMedidos', 'totalComponentes'));
    }
    
    /**
     * Formulário para editar projeto
     */
    public function edit($id)
    {
        $projeto = Projeto::findOrFail($id);
        
        // Verificar autorização
        if ($projeto->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        return view('projetos.edit', compact('projeto'));
    }
    
    /**
     * Atualizar projeto
     */
    public function update(Request $request, $id)
    {
        $projeto = Projeto::findOrFail($id);
        
        // Verificar autorização
        if ($projeto->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cliente' => 'nullable|string|max:255',
            'localizacao' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
            'data_inicio' => 'nullable|date',
            'data_fim' => 'nullable|date|after_or_equal:data_inicio',
            'status' => 'in:rascunho,medicao,orcamento,concluido',
            'iva' => 'nullable|numeric|min:0|max:100',
            'contingencia' => 'nullable|numeric|min:0|max:100',
        ]);
        
        $projeto->update($validated);
        
        return redirect()->route('projetos.show', $projeto->id)
            ->with('success', 'Projeto atualizado com sucesso!');
    }
    
    /**
     * Excluir projeto
     */
    public function destroy($id)
    {
        $projeto = Projeto::findOrFail($id);
        
        // Verificar autorização
        if ($projeto->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        // Verificar se há orçamentos
        if ($projeto->orcamentos()->count() > 0) {
            return redirect()->route('projetos.index')
                ->with('error', 'Não é possível excluir um projeto que possui orçamentos.');
        }
        
        $projeto->delete();
        
        return redirect()->route('projetos.index')
            ->with('success', 'Projeto removido com sucesso!');
    }
    
    /**
     * Duplicar projeto (criar nova versão)
     */
    public function novaVersao($id)
    {
        $projeto = Projeto::findOrFail($id);
        
        // Verificar autorização
        if ($projeto->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        $novoProjeto = $projeto->replicate();
        $novoProjeto->nome = $projeto->nome . ' (Cópia ' . date('d/m/Y') . ')';
        $novoProjeto->status = 'rascunho';
        $novoProjeto->save();
        
        // Copiar medições
        foreach ($projeto->medicoes as $medicao) {
            $novaMedicao = $medicao->replicate();
            $novaMedicao->projeto_id = $novoProjeto->id;
            $novaMedicao->save();
        }
        
        return redirect()->route('projetos.show', $novoProjeto->id)
            ->with('success', 'Nova versão do projeto criada com sucesso!');
    }
}