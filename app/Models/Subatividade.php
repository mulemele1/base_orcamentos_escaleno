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

    public function atividade()
    {
        return $this->belongsTo(Atividade::class);
    }

    public function composicaoCustos()
    {
        return $this->hasMany(ComposicaoCusto::class);
    }

    /**
     * Calcular elementar (C x L x H)
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
     * Calcular parcial (NPI x Elementar)
     */
    public function calcularParcial()
    {
        return $this->npi * $this->calcularElementar();
    }

    /**
     * Calcular quantidade proposta (Parcial x (1 + Perda/100))
     */
    public function calcularQuantidadeProposta()
    {
        return $this->calcularParcial() * (1 + ($this->perda_percentual / 100));
    }

    /**
     * Recalcular todos os valores
     */
    public function recalcular()
    {
        $this->elementar = $this->calcularElementar();
        $this->parcial = $this->calcularParcial();
        $this->quantidade_proposta = $this->calcularQuantidadeProposta();
        $this->save();
        
        return $this;
    }

    /**
     * Total de materiais
     */
    public function getTotalMateriaisAttribute()
    {
        return $this->composicaoCustos()
            ->where('tipo', 'material')
            ->get()
            ->sum(function($item) {
                return $item->custo_total ?? 0;
            });
    }

    /**
     * Total de mão de obra
     */
    public function getTotalMaoObraAttribute()
    {
        return $this->composicaoCustos()
            ->where('tipo', 'mao_obra')
            ->get()
            ->sum(function($item) {
                return $item->custo_total ?? 0;
            });
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