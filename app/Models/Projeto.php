<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Projeto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome', 'cliente', 'localizacao', 'data_inicio', 'data_fim',
        'status', 'template_id', 'configuracoes', 'user_id'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'configuracoes' => 'array',
    ];

    // ========== RELACIONAMENTOS ==========
    
    /**
     * Usuário responsável pelo projeto
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Template usado como base
     */
    public function template()
    {
        return $this->belongsTo(TemplateOrcamento::class);
    }

    /**
     * Orçamentos do projeto
     */
    public function orcamentos()
    {
        return $this->hasMany(Orcamento::class);
    }

    /**
     * Obter todas as categorias do projeto via orçamento
     */
    public function categorias()
    {
        return $this->hasManyThrough(
            CategoriaObra::class,
            Orcamento::class,
            'projeto_id',           // Foreign key on orcamentos table
            'id',                    // Local key on categorias_obra table
            'id',                    // Local key on projetos table
            'categoria_obra_id'      // Foreign key on orcamento_atividades
        )->distinct();
    }

    /**
     * Obter todas as atividades do projeto
     */
    public function atividades()
    {
        return $this->hasManyThrough(
            Atividade::class,
            OrcamentoAtividade::class,
            'orcamento_id',          // Foreign key on orcamento_atividades
            'id',                    // Local key on atividades table
            'id',                    // Local key on projetos table
            'atividade_id'           // Foreign key on orcamento_atividades
        )->distinct();
    }

    // ========== ACESSORES ==========
    
    /**
     * Obter o orçamento ativo (última versão)
     */
    public function getOrcamentoAtivoAttribute()
    {
        return $this->orcamentos()->orderBy('versao', 'desc')->first();
    }

    /**
     * Obter o valor total do projeto (último orçamento)
     */
    public function getValorTotalAttribute()
    {
        $orcamento = $this->orcamento_ativo;
        return $orcamento ? $orcamento->grand_total : 0;
    }

    /**
     * Obter o status do projeto formatado
     */
    public function getStatusFormatadoAttribute()
    {
        $statuses = [
            'planeamento' => 'Em Planeamento',
            'em_andamento' => 'Em Andamento',
            'concluido' => 'Concluído',
            'suspenso' => 'Suspenso',
        ];
        return $statuses[$this->status] ?? $this->status;
    }

    // ========== MÉTODOS DE CRIAÇÃO ==========
    
    /**
     * Criar um novo orçamento para o projeto (primeira versão)
     */
    public function criarPrimeiroOrcamento($dados = [])
    {
        DB::beginTransaction();
        try {
            $orcamento = new Orcamento();
            $orcamento->projeto_id = $this->id;
            $orcamento->codigo = $this->gerarCodigoOrcamento();
            $orcamento->versao = 1;
            $orcamento->nome_projeto = $this->nome;
            $orcamento->cliente = $this->cliente;
            $orcamento->localizacao = $this->localizacao;
            $orcamento->data_emissao = now();
            $orcamento->status = 'rascunho';
            $orcamento->iva_percentual = $this->configuracoes['iva'] ?? $dados['iva_percentual'] ?? 16;
            $orcamento->contingencia_percentual = $this->configuracoes['contingencia'] ?? $dados['contingencia_percentual'] ?? 8;
            $orcamento->user_id = auth()->id();
            $orcamento->subtotal = 0;
            $orcamento->valor_iva = 0;
            $orcamento->valor_contingencia = 0;
            $orcamento->grand_total = 0;
            $orcamento->save();

            DB::commit();
            return $orcamento;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Criar uma nova versão do orçamento
     */
    public function novaVersao()
    {
        $ultimoOrcamento = $this->orcamento_ativo;
        
        if (!$ultimoOrcamento) return null;

        DB::beginTransaction();
        try {
            $novoOrcamento = $ultimoOrcamento->replicate();
            $novoOrcamento->versao = $ultimoOrcamento->versao + 1;
            $novoOrcamento->status = 'rascunho';
            $novoOrcamento->data_emissao = now();
            $novoOrcamento->save();

            // Copiar atividades do orçamento anterior
            foreach ($ultimoOrcamento->orcamentoAtividades as $oa) {
                $novaOA = $oa->replicate();
                $novaOA->orcamento_id = $novoOrcamento->id;
                $novaOA->save();
            }

            DB::commit();
            return $novoOrcamento;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    // ========== MÉTODOS PRIVADOS ==========
    
    /**
     * Gerar código único para o orçamento
     */
    private function gerarCodigoOrcamento()
    {
        $ano = date('Y');
        $sequencia = Orcamento::whereYear('created_at', $ano)->count() + 1;
        return 'ORC-' . $ano . '-' . str_pad($sequencia, 4, '0', STR_PAD_LEFT);
    }

    // ========== ESCOPOS ==========
    
    /**
     * Escopo para filtrar projetos ativos
     */
    public function scopeAtivos($query)
    {
        return $query->whereIn('status', ['planeamento', 'em_andamento']);
    }
}