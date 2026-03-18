<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list(Request $request)
    {
        $query = Cliente::query();

        // Busca por nome ou email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('cpf_cnpj', 'like', "%{$search}%");
        }

        // Filtro por status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $clientes = $query->orderBy('nome')->paginate(10);
        
        return view('clientes.list', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clientes,email',
            'telefone' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'cpf_cnpj' => 'nullable|unique:clientes,cpf_cnpj',
            'tipo_pessoa' => 'required|in:fisica,juridica',
            'rg_ie' => 'nullable|string|max:20',
            'data_nascimento' => 'nullable|date',
            'cep' => 'nullable|string|max:10',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'profissao' => 'nullable|string|max:100',
            'empresa' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'status' => 'required|in:ativo,inativo'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Criar cliente
        Cliente::create($request->all());

        return redirect()->route('clientes.list')
            ->with('success', 'Cliente criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clientes,email,' . $cliente->id,
            'telefone' => 'nullable|string|max:20',
            'celular' => 'nullable|string|max:20',
            'cpf_cnpj' => 'nullable|unique:clientes,cpf_cnpj,' . $cliente->id,
            'tipo_pessoa' => 'required|in:fisica,juridica',
            'rg_ie' => 'nullable|string|max:20',
            'data_nascimento' => 'nullable|date',
            'cep' => 'nullable|string|max:10',
            'endereco' => 'nullable|string|max:255',
            'numero' => 'nullable|string|max:20',
            'complemento' => 'nullable|string|max:100',
            'bairro' => 'nullable|string|max:100',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'profissao' => 'nullable|string|max:100',
            'empresa' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'status' => 'required|in:ativo,inativo'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Atualizar cliente
        $cliente->update($request->all());

        return redirect()->route('clientes.list')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('clientes.list')
            ->with('success', 'Cliente removido com sucesso!');
    }

    // <-- AQUI FOI REMOVIDA A FUNÇÃO DUPLICADA -->
}