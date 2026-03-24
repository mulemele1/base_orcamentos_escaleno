<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subatividade extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'codigo', 'nome', 'unidade', 'npi', 'comprimento', 'largura', 'altura',
        'elementar', 'parcial', 'perda_percentual', 'quantidade_proposta',
        'descricao', 'atividade_id', 'ordem'
    ];

    protected $casts = [
        'comprimento' => 'decimal:2',
        'largura' => 'decimal:2',
        'altura' => 'decimal:2',
        'elementar' => 'decimal:2',
        'parcial' => 'decimal:2',
        'perda_percentual' => 'decimal:2',
        'quantidade_proposta' => 'decimal:2',
    ];

    // ========== RELACIONAMENTOS ==========
    
    /**
     * Atividade pai
     */
    public function atividade()
    {
        return $this->belongsTo(Atividade::class);
    }

    /**
     * Composição de custos (materiais)
     */
    public function composicaoCustos()
    {
        return $this->hasMany(ComposicaoCusto::class);
    }

    // ========== MÉTODOS DE CÁLCULO ==========
    
    /**
     * Calcular elementar (C × L × H)
     */
    public function calcularElementar()
    {
        if ($this->comprimento && $this->largura && $this->altura) {
            return $this->comprimento * $this->largura * $this->altura;
        } elseif ($this->comprimento && $this->largura) {
            return $this->comprimento * $this->largura;
        } elseif ($this->comprimento) {
            return $this->comprimento;
        }
        return 1;
    }

    /**
     * Calcular parcial (NPI × Elementar)
     */
    public function calcularParcial()
    {
        return ($this->npi ?? 1) * $this->calcularElementar();
    }

    /**
     * Calcular quantidade proposta (Parcial × (1 + Perda/100))
     */
    public function calcularQuantidadeProposta()
    {
        return $this->calcularParcial() * (1 + (($this->perda_percentual ?? 0) / 100));
    }

    /**
     * Recalcular todos os valores e salvar
     */
    public function recalcular()
    {
        $this->elementar = $this->calcularElementar();
        $this->parcial = $this->calcularParcial();
        $this->quantidade_proposta = $this->calcularQuantidadeProposta();
        $this->save();
        
        return $this;
    }

    // ========== ACESSORES ==========
    
    /**
     * Total de materiais
     */
    public function getTotalMateriaisAttribute()
    {
        return $this->composicaoCustos()
            ->where('tipo', 'material')
            ->sum('custo_total');
    }

    /**
     * Total de mão de obra
     */
    public function getTotalMaoObraAttribute()
    {
        return $this->composicaoCustos()
            ->where('tipo', 'mao_obra')
            ->sum('custo_total');
    }

    /**
     * Preço unitário
     */
    public function getPrecoUnitarioAttribute()
    {
        $total = $this->total_materiais + $this->total_mao_obra;
        return $this->quantidade_proposta > 0 ? $total / $this->quantidade_proposta : 0;
    }

    /**
     * Total da subatividade
     */
    public function getTotalAttribute()
    {
        return $this->quantidade_proposta * $this->preco_unitario;
    }
}