<?php
// app/Http/Controllers/Admin/EstruturaController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Modulo;
use App\Models\Capitulo;
use App\Models\Actividade;
use App\Models\Grupo;
use App\Models\Componente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstruturaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:is_admin');
    }
    
    /**
     * Dashboard da estrutura hierárquica
     */
    public function index()
    {
        $modulos = Modulo::with(['capitulos.actividades.grupos.componentes', 
                                  'capitulos.actividades.componentes' => function($q) {
                                      $q->whereNull('grupo_id');
                                  }])
                          ->orderBy('ordem')
                          ->get();
        
        return view('admin.estrutura.index', compact('modulos'));
    }
    
    // ==================== MÓDULOS ====================
    
    public function modulos()
    {
        $modulos = Modulo::orderBy('ordem')->get();
        return view('admin.estrutura.modulos', compact('modulos'));
    }
    
    public function moduloCreate()
    {
        return view('admin.estrutura.modulo-form');
    }
    
    public function moduloStore(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'ordem' => 'required|integer|min:1',
            'descricao' => 'nullable|string',
        ]);
        
        Modulo::create($validated);
        
        return redirect()->route('admin.estrutura.modulos')
            ->with('success', 'Módulo criado com sucesso!');
    }
    
    public function moduloEdit($id)
    {
        $modulo = Modulo::findOrFail($id);
        return view('admin.estrutura.modulo-form', compact('modulo'));
    }
    
    public function moduloUpdate(Request $request, $id)
    {
        $modulo = Modulo::findOrFail($id);
        
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'ordem' => 'required|integer|min:1',
            'descricao' => 'nullable|string',
        ]);
        
        $modulo->update($validated);
        
        return redirect()->route('admin.estrutura.modulos')
            ->with('success', 'Módulo atualizado com sucesso!');
    }
    
    public function moduloDestroy($id)
    {
        $modulo = Modulo::findOrFail($id);
        
        if ($modulo->capitulos()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Não é possível excluir um módulo que possui capítulos.');
        }
        
        $modulo->delete();
        
        return redirect()->route('admin.estrutura.modulos')
            ->with('success', 'Módulo removido com sucesso!');
    }
    
    // ==================== CAPÍTULOS ====================
    
    public function capitulos($modulo_id = null)
    {
        if ($modulo_id) {
            $capitulos = Capitulo::where('modulo_id', $modulo_id)
                ->with('modulo')
                ->orderBy('ordem')
                ->get();
            $modulo = Modulo::find($modulo_id);
        } else {
            $capitulos = Capitulo::with('modulo')->orderBy('ordem')->get();
            $modulo = null;
        }
        
        $modulos = Modulo::orderBy('ordem')->get();
        
        return view('admin.estrutura.capitulos', compact('capitulos', 'modulos', 'modulo'));
    }
    
    public function capituloCreate($modulo_id = null)
    {
        $modulos = Modulo::orderBy('ordem')->get();
        $moduloSelecionado = $modulo_id ? Modulo::find($modulo_id) : null;
        
        return view('admin.estrutura.capitulo-form', compact('modulos', 'moduloSelecionado'));
    }
    
    public function capituloStore(Request $request)
    {
        $validated = $request->validate([
            'modulo_id' => 'required|exists:modulos,id',
            'nome' => 'required|string|max:255',
            'ordem' => 'required|integer|min:1',
            'descricao' => 'nullable|string',
        ]);
        
        Capitulo::create($validated);
        
        return redirect()->route('admin.estrutura.capitulos', $validated['modulo_id'])
            ->with('success', 'Capítulo criado com sucesso!');
    }
    
    public function capituloEdit($id)
    {
        $capitulo = Capitulo::findOrFail($id);
        $modulos = Modulo::orderBy('ordem')->get();
        
        return view('admin.estrutura.capitulo-form', compact('capitulo', 'modulos'));
    }
    
    public function capituloUpdate(Request $request, $id)
    {
        $capitulo = Capitulo::findOrFail($id);
        
        $validated = $request->validate([
            'modulo_id' => 'required|exists:modulos,id',
            'nome' => 'required|string|max:255',
            'ordem' => 'required|integer|min:1',
            'descricao' => 'nullable|string',
        ]);
        
        $capitulo->update($validated);
        
        return redirect()->route('admin.estrutura.capitulos', $capitulo->modulo_id)
            ->with('success', 'Capítulo atualizado com sucesso!');
    }
    
    public function capituloDestroy($id)
    {
        $capitulo = Capitulo::findOrFail($id);
        $modulo_id = $capitulo->modulo_id;
        
        if ($capitulo->actividades()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Não é possível excluir um capítulo que possui actividades.');
        }
        
        $capitulo->delete();
        
        return redirect()->route('admin.estrutura.capitulos', $modulo_id)
            ->with('success', 'Capítulo removido com sucesso!');
    }
    
    // ==================== ACTIVIDADES ====================
    
    public function actividades($capitulo_id = null)
    {
        if ($capitulo_id) {
            $actividades = Actividade::where('capitulo_id', $capitulo_id)
                ->with('capitulo.modulo')
                ->orderBy('ordem')
                ->get();
            $capitulo = Capitulo::find($capitulo_id);
        } else {
            $actividades = Actividade::with('capitulo.modulo')->orderBy('ordem')->get();
            $capitulo = null;
        }
        
        $capitulos = Capitulo::with('modulo')->orderBy('ordem')->get();
        
        return view('admin.estrutura.actividades', compact('actividades', 'capitulos', 'capitulo'));
    }
    
    public function actividadeCreate($capitulo_id = null)
    {
        $capitulos = Capitulo::with('modulo')->orderBy('ordem')->get();
        $capituloSelecionado = $capitulo_id ? Capitulo::find($capitulo_id) : null;
        
        return view('admin.estrutura.actividade-form', compact('capitulos', 'capituloSelecionado'));
    }
    
    public function actividadeStore(Request $request)
    {
        $validated = $request->validate([
            'capitulo_id' => 'required|exists:capitulos,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'ordem' => 'required|integer|min:1',
        ]);
        
        Actividade::create($validated);
        
        return redirect()->route('admin.estrutura.actividades', $validated['capitulo_id'])
            ->with('success', 'Actividade criada com sucesso!');
    }
    
    public function actividadeEdit($id)
    {
        $actividade = Actividade::findOrFail($id);
        $capitulos = Capitulo::with('modulo')->orderBy('ordem')->get();
        
        return view('admin.estrutura.actividade-form', compact('actividade', 'capitulos'));
    }
    
    public function actividadeUpdate(Request $request, $id)
    {
        $actividade = Actividade::findOrFail($id);
        
        $validated = $request->validate([
            'capitulo_id' => 'required|exists:capitulos,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'required|string',
            'ordem' => 'required|integer|min:1',
        ]);
        
        $actividade->update($validated);
        
        return redirect()->route('admin.estrutura.actividades', $actividade->capitulo_id)
            ->with('success', 'Actividade atualizada com sucesso!');
    }
    
    public function actividadeDestroy($id)
    {
        $actividade = Actividade::findOrFail($id);
        $capitulo_id = $actividade->capitulo_id;
        
        if ($actividade->grupos()->count() > 0 || $actividade->componentes()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Não é possível excluir uma actividade que possui grupos ou componentes.');
        }
        
        $actividade->delete();
        
        return redirect()->route('admin.estrutura.actividades', $capitulo_id)
            ->with('success', 'Actividade removida com sucesso!');
    }
    
    // ==================== GRUPOS ====================
    
    public function grupos($actividade_id = null)
    {
        if ($actividade_id) {
            $grupos = Grupo::where('actividade_id', $actividade_id)
                ->with('actividade.capitulo.modulo')
                ->orderBy('ordem')
                ->get();
            $actividade = Actividade::find($actividade_id);
        } else {
            $grupos = Grupo::with('actividade.capitulo.modulo')->orderBy('ordem')->get();
            $actividade = null;
        }
        
        $actividades = Actividade::with('capitulo.modulo')->orderBy('ordem')->get();
        
        return view('admin.estrutura.grupos', compact('grupos', 'actividades', 'actividade'));
    }
    
    public function grupoCreate($actividade_id = null)
    {
        $actividades = Actividade::with('capitulo.modulo')->orderBy('ordem')->get();
        $actividadeSelecionada = $actividade_id ? Actividade::find($actividade_id) : null;
        
        return view('admin.estrutura.grupo-form', compact('actividades', 'actividadeSelecionada'));
    }
    
    public function grupoStore(Request $request)
    {
        $validated = $request->validate([
            'actividade_id' => 'required|exists:actividades,id',
            'nome' => 'required|string|max:255',
            'unidade_padrao' => 'required|string|max:10',
            'ordem' => 'required|integer|min:1',
        ]);
        
        Grupo::create($validated);
        
        return redirect()->route('admin.estrutura.grupos', $validated['actividade_id'])
            ->with('success', 'Grupo criado com sucesso!');
    }
    
    public function grupoEdit($id)
    {
        $grupo = Grupo::findOrFail($id);
        $actividades = Actividade::with('capitulo.modulo')->orderBy('ordem')->get();
        
        return view('admin.estrutura.grupo-form', compact('grupo', 'actividades'));
    }
    
    public function grupoUpdate(Request $request, $id)
    {
        $grupo = Grupo::findOrFail($id);
        
        $validated = $request->validate([
            'actividade_id' => 'required|exists:actividades,id',
            'nome' => 'required|string|max:255',
            'unidade_padrao' => 'required|string|max:10',
            'ordem' => 'required|integer|min:1',
        ]);
        
        $grupo->update($validated);
        
        return redirect()->route('admin.estrutura.grupos', $grupo->actividade_id)
            ->with('success', 'Grupo atualizado com sucesso!');
    }
    
    public function grupoDestroy($id)
    {
        $grupo = Grupo::findOrFail($id);
        $actividade_id = $grupo->actividade_id;
        
        if ($grupo->componentes()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Não é possível excluir um grupo que possui componentes.');
        }
        
        $grupo->delete();
        
        return redirect()->route('admin.estrutura.grupos', $actividade_id)
            ->with('success', 'Grupo removido com sucesso!');
    }
    
    // ==================== COMPONENTES ====================
    
    /**
     * Componentes por grupo
     */
    public function componentesPorGrupo($grupo_id)
    {
        $componentes = Componente::where('grupo_id', $grupo_id)
            ->with('grupo.actividade.capitulo.modulo')
            ->orderBy('ordem')
            ->get();
        
        $grupo = Grupo::find($grupo_id);
        $actividade = null;
        
        $grupos = Grupo::with('actividade.capitulo.modulo')->orderBy('ordem')->get();
        $actividades = Actividade::with('capitulo.modulo')->orderBy('ordem')->get();
        
        return view('admin.estrutura.componentes', compact('componentes', 'grupos', 'actividades', 'grupo', 'actividade'));
    }
    
    /**
     * Componentes por actividade
     */
    public function componentesPorActividade($actividade_id)
    {
        $componentes = Componente::where('actividade_id', $actividade_id)
            ->whereNull('grupo_id')
            ->with('actividade.capitulo.modulo')
            ->orderBy('ordem')
            ->get();
        
        $actividade = Actividade::find($actividade_id);
        $grupo = null;
        
        $grupos = Grupo::with('actividade.capitulo.modulo')->orderBy('ordem')->get();
        $actividades = Actividade::with('capitulo.modulo')->orderBy('ordem')->get();
        
        return view('admin.estrutura.componentes', compact('componentes', 'grupos', 'actividades', 'grupo', 'actividade'));
    }
    
    /**
     * Todos os componentes
     */
    public function componentesTodos()
    {
        $componentes = Componente::with(['grupo.actividade.capitulo.modulo', 'actividade.capitulo.modulo'])
            ->orderBy('ordem')
            ->get();
        
        $grupo = null;
        $actividade = null;
        
        $grupos = Grupo::with('actividade.capitulo.modulo')->orderBy('ordem')->get();
        $actividades = Actividade::with('capitulo.modulo')->orderBy('ordem')->get();
        
        return view('admin.estrutura.componentes', compact('componentes', 'grupos', 'actividades', 'grupo', 'actividade'));
    }
    
    /**
     * Show the form for creating a new component.
     */
    public function componenteCreate($grupo_id = null, $actividade_id = null)
    {
        $grupos = Grupo::with('actividade.capitulo.modulo')->orderBy('ordem')->get();
        $actividades = Actividade::with('capitulo.modulo')->orderBy('ordem')->get();
        
        $formulas = [
            'volume' => 'Volume (C × L × H)',
            'area' => 'Área (C × L)',
            'area_parede' => 'Área de Parede (C × H)',
            'area_lateral' => 'Área Lateral (L × H)',
            'comprimento' => 'Comprimento Linear (C)',
            'largura' => 'Largura (L)',
            'altura' => 'Altura (H)',
            'valor_fixo' => 'Valor Fixo (NPI × H)',
        ];
        
        $grupoSelecionado = $grupo_id ? Grupo::find($grupo_id) : null;
        $actividadeSelecionada = $actividade_id ? Actividade::find($actividade_id) : null;
        
        return view('admin.estrutura.componente-form', compact('grupos', 'actividades', 'formulas', 'grupoSelecionado', 'actividadeSelecionada'));
    }
    
    /**
     * Store a newly created component in storage.
     */
    public function componenteStore(Request $request)
    {
        $validated = $request->validate([
            'grupo_id' => 'nullable|exists:grupos,id',
            'actividade_id' => 'required|exists:actividades,id',
            'nome' => 'required|string|max:255',
            'unidade' => 'required|string|max:10',
            'formula_calculo' => 'required|in:volume,area,area_parede,area_lateral,comprimento,largura,altura,valor_fixo',
            'valor_padrao' => 'nullable|numeric|min:0',
            'perda_padrao' => 'nullable|numeric|min:0|max:100',
            'ordem' => 'required|integer|min:1',
        ]);
        
        $validated['perda_padrao'] = $validated['perda_padrao'] ?? 0;
        
        $componente = Componente::create($validated);
        
        // CORREÇÃO: Redirecionar para a rota correta
        if ($validated['grupo_id']) {
            return redirect()->route('admin.estrutura.componentes.por-grupo', $validated['grupo_id'])
                ->with('success', 'Componente criado com sucesso!');
        } else {
            return redirect()->route('admin.estrutura.componentes.por-actividade', $validated['actividade_id'])
                ->with('success', 'Componente criado com sucesso!');
        }
    }
    
    /**
     * Show the form for editing the specified component.
     */
    public function componenteEdit($id)
    {
        $componente = Componente::findOrFail($id);
        $grupos = Grupo::with('actividade.capitulo.modulo')->orderBy('ordem')->get();
        $actividades = Actividade::with('capitulo.modulo')->orderBy('ordem')->get();
        
        $formulas = [
            'volume' => 'Volume (C × L × H)',
            'area' => 'Área (C × L)',
            'area_parede' => 'Área de Parede (C × H)',
            'area_lateral' => 'Área Lateral (L × H)',
            'comprimento' => 'Comprimento Linear (C)',
            'largura' => 'Largura (L)',
            'altura' => 'Altura (H)',
            'valor_fixo' => 'Valor Fixo (NPI × H)',
        ];
        
        return view('admin.estrutura.componente-form', compact('componente', 'grupos', 'actividades', 'formulas'));
    }
    
    /**
     * Update the specified component in storage.
     */
    public function componenteUpdate(Request $request, $id)
    {
        $componente = Componente::findOrFail($id);
        
        $validated = $request->validate([
            'grupo_id' => 'nullable|exists:grupos,id',
            'actividade_id' => 'required|exists:actividades,id',
            'nome' => 'required|string|max:255',
            'unidade' => 'required|string|max:10',
            'formula_calculo' => 'required|in:volume,area,area_parede,area_lateral,comprimento,largura,altura,valor_fixo',
            'valor_padrao' => 'nullable|numeric|min:0',
            'perda_padrao' => 'nullable|numeric|min:0|max:100',
            'ordem' => 'required|integer|min:1',
        ]);
        
        $validated['perda_padrao'] = $validated['perda_padrao'] ?? 0;
        
        $componente->update($validated);
        
        // CORREÇÃO: Redirecionar para a rota correta
        if ($componente->grupo_id) {
            return redirect()->route('admin.estrutura.componentes.por-grupo', $componente->grupo_id)
                ->with('success', 'Componente atualizado com sucesso!');
        } else {
            return redirect()->route('admin.estrutura.componentes.por-actividade', $componente->actividade_id)
                ->with('success', 'Componente atualizado com sucesso!');
        }
    }
    
    /**
     * Remove the specified component from storage.
     */
    public function componenteDestroy($id)
    {
        $componente = Componente::findOrFail($id);
        
        // Verificar se tem medições
        if ($componente->medicoes()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Não é possível excluir um componente que possui medições.');
        }
        
        $grupo_id = $componente->grupo_id;
        $actividade_id = $componente->actividade_id;
        
        $componente->delete();
        
        // CORREÇÃO: Redirecionar para a rota correta
        if ($grupo_id) {
            return redirect()->route('admin.estrutura.componentes.por-grupo', $grupo_id)
                ->with('success', 'Componente removido com sucesso!');
        } else {
            return redirect()->route('admin.estrutura.componentes.por-actividade', $actividade_id)
                ->with('success', 'Componente removido com sucesso!');
        }
    }
}