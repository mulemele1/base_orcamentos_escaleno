<?php

namespace App\Http\Controllers;

use App\Models\Configuracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfiguracaoController extends Controller
{
    public function index()
    {
        $configuracoes = Configuracao::orderBy('grupo')->orderBy('nome')->get();
        $grupos = Configuracao::select('grupo')->distinct()->pluck('grupo');
        
        return view('configuracoes.index', compact('configuracoes', 'grupos'));
    }

    public function update(Request $request)
    {
        $dados = $request->except('_token');
        
        foreach ($dados as $chave => $valor) {
            Configuracao::set($chave, $valor);
        }

        return redirect()->back()->with('success', 'Configurações atualizadas com sucesso!');
    }
}