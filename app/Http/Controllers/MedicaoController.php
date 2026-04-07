<?php
// app/Http/Controllers/MedicaoController.php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\Componente;
use App\Models\Medicao;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MedicaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Dashboard de medição do projeto (árvore hierárquica)
     */
    public function dashboard(Projeto $projeto)
    {
        // Verificar autorização
        if ($projeto->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        // Carregar estrutura completa com módulos, capítulos, actividades, grupos e componentes
        $estrutura = Modulo::with([
            'capitulos.actividades.grupos.componentes',
            'capitulos.actividades.componentes' => function($q) {
                $q->whereNull('grupo_id');
            }
        ])->orderBy('ordem')->get();
        
        // Carregar medições existentes deste projeto
        $medicoes = $projeto->medicoes()->with('componente')->get();
        
        // Agrupar medições por componente_id para fácil consulta
        $medicoesPorComponente = $medicoes->groupBy('componente_id');
        
        // Calcular progresso
        $totalComponentes = Componente::count();
        $componentesMedidos = $medicoes->unique('componente_id')->count();
        $progresso = $totalComponentes > 0 ? round(($componentesMedidos / $totalComponentes) * 100) : 0;
        
        return view('medicoes.dashboard', compact(
            'projeto', 
            'estrutura', 
            'medicoesPorComponente', 
            'progresso', 
            'componentesMedidos', 
            'totalComponentes'
        ));
    }
    
    /**
     * Formulário para adicionar medição
     */
    public function create(Projeto $projeto, Request $request)
    {
        // Verificar autorização
        if ($projeto->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        $componenteId = $request->get('componente_id');
        $componente = null;
        
        if ($componenteId) {
            $componente = Componente::with([
                'grupo.actividade.capitulo.modulo',
                'actividade.capitulo.modulo'
            ])->find($componenteId);
        }
        
        return view('medicoes.create', compact('projeto', 'componente'));
    }
    
    /**
     * Salvar medição (com cálculo automático)
     */
    public function store(Request $request, Projeto $projeto)
    {
        // Verificar autorização
        if ($projeto->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        $validated = $request->validate([
            'componente_id' => 'required|exists:componentes,id',
            'origem' => 'required|in:desenho,campo',
            'prancha' => 'nullable|string|max:100',
            'data_medicao' => 'nullable|date',
            'medido_por' => 'nullable|string|max:100',
            'npi' => 'required|integer|min:1',
            'comprimento' => 'nullable|numeric|min:0',
            'largura' => 'nullable|numeric|min:0',
            'altura' => 'nullable|numeric|min:0',
            'perda' => 'nullable|numeric|min:0|max:100',
            'observacoes' => 'nullable|string',
            'foto' => 'nullable|image|max:5120',
        ]);
        
        $componente = Componente::find($validated['componente_id']);
        
        // Calcular quantidade automaticamente
        $npi = $validated['npi'];
        $comprimento = $validated['comprimento'] ?? 0;
        $largura = $validated['largura'] ?? 0;
        $altura = $validated['altura'] ?? 0;
        $perda = $validated['perda'] ?? $componente->perda_padrao;
        
        $elementar = $this->calcularElementar($componente->formula_calculo, $npi, $comprimento, $largura, $altura);
        $quantidade = round($elementar * (1 + ($perda / 100)), 2);
        
        // Processar foto se enviada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('medicoes', 'public');
        }
        
        $medicao = $projeto->medicoes()->create([
            'componente_id' => $componente->id,
            'origem' => $validated['origem'],
            'prancha' => $validated['prancha'] ?? null,
            'data_medicao' => $validated['data_medicao'] ?? now(),
            'medido_por' => $validated['medido_por'] ?? Auth::user()->name,
            'npi' => $npi,
            'comprimento' => $comprimento ?: null,
            'largura' => $largura ?: null,
            'altura' => $altura ?: null,
            'perda' => $perda,
            'quantidade' => $quantidade,
            'observacoes' => $validated['observacoes'] ?? null,
            'foto_path' => $fotoPath,
        ]);
        
        // Atualizar status do projeto se necessário
        if ($projeto->status === 'rascunho') {
            $projeto->update(['status' => 'medicao']);
        }
        
        return redirect()->route('medicoes.dashboard', $projeto)
            ->with('success', 'Medição adicionada com sucesso!');
    }
    
    /**
     * Formulário para editar medição
     */
    public function edit(Projeto $projeto, Medicao $medicao)
    {
        // Verificar autorização
        if ($projeto->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        $medicao->load('componente');
        
        return view('medicoes.edit', compact('projeto', 'medicao'));
    }
    
    /**
     * Atualizar medição
     */
    public function update(Request $request, Projeto $projeto, Medicao $medicao)
    {
        // Verificar autorização
        if ($projeto->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        $validated = $request->validate([
            'origem' => 'required|in:desenho,campo',
            'prancha' => 'nullable|string|max:100',
            'data_medicao' => 'nullable|date',
            'medido_por' => 'nullable|string|max:100',
            'npi' => 'required|integer|min:1',
            'comprimento' => 'nullable|numeric|min:0',
            'largura' => 'nullable|numeric|min:0',
            'altura' => 'nullable|numeric|min:0',
            'perda' => 'nullable|numeric|min:0|max:100',
            'observacoes' => 'nullable|string',
            'foto' => 'nullable|image|max:5120',
        ]);
        
        $componente = $medicao->componente;
        
        // Recalcular quantidade
        $npi = $validated['npi'];
        $comprimento = $validated['comprimento'] ?? 0;
        $largura = $validated['largura'] ?? 0;
        $altura = $validated['altura'] ?? 0;
        $perda = $validated['perda'] ?? $componente->perda_padrao;
        
        $elementar = $this->calcularElementar($componente->formula_calculo, $npi, $comprimento, $largura, $altura);
        $quantidade = round($elementar * (1 + ($perda / 100)), 2);
        
        // Processar foto se enviada
        if ($request->hasFile('foto')) {
            // Apagar foto antiga se existir
            if ($medicao->foto_path && Storage::disk('public')->exists($medicao->foto_path)) {
                Storage::disk('public')->delete($medicao->foto_path);
            }
            $fotoPath = $request->file('foto')->store('medicoes', 'public');
            $validated['foto_path'] = $fotoPath;
        }
        
        $medicao->update([
            'origem' => $validated['origem'],
            'prancha' => $validated['prancha'] ?? null,
            'data_medicao' => $validated['data_medicao'] ?? now(),
            'medido_por' => $validated['medido_por'] ?? Auth::user()->name,
            'npi' => $npi,
            'comprimento' => $comprimento ?: null,
            'largura' => $largura ?: null,
            'altura' => $altura ?: null,
            'perda' => $perda,
            'quantidade' => $quantidade,
            'observacoes' => $validated['observacoes'] ?? null,
            'foto_path' => $validated['foto_path'] ?? $medicao->foto_path,
        ]);
        
        return redirect()->route('medicoes.dashboard', $projeto)
            ->with('success', 'Medição atualizada com sucesso!');
    }
    
    /**
     * Remover medição
     */
    public function destroy(Projeto $projeto, Medicao $medicao)
    {
        // Verificar autorização
        if ($projeto->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        // Apagar foto se existir
        if ($medicao->foto_path && Storage::disk('public')->exists($medicao->foto_path)) {
            Storage::disk('public')->delete($medicao->foto_path);
        }
        
        $medicao->delete();
        
        return redirect()->route('medicoes.dashboard', $projeto)
            ->with('success', 'Medição removida com sucesso!');
    }
    
    /**
     * Finalizar medição (marcar como completa)
     */
    public function finalizar(Projeto $projeto)
    {
        // Verificar autorização
        if ($projeto->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.');
        }
        
        $projeto->update(['status' => 'orcamento']);
        
        return redirect()->route('projetos.show', $projeto)
            ->with('success', 'Medição finalizada! Agora você pode gerar o orçamento.');
    }
    
    /**
     * Calcular elemento baseado na fórmula
     */
    private function calcularElementar($formula, $npi, $comprimento, $largura, $altura)
    {
        switch($formula) {
            case 'volume':
                return $npi * $comprimento * $largura * $altura;
            case 'area':
                return $npi * $comprimento * $largura;
            case 'area_parede':
                return $npi * $comprimento * $altura;
            case 'area_lateral':
                return $npi * $largura * $altura;
            case 'comprimento':
                return $npi * $comprimento;
            case 'largura':
                return $npi * $largura;
            case 'altura':
                return $npi * $altura;
            case 'valor_fixo':
                return $npi * ($altura > 0 ? $altura : 1);
            default:
                return 0;
        }
    }
}