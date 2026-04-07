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
        'npi' => 'integer',
    ];

    // ========== RELACIONAMENTOS ==========
    
    public function atividade()
    {
        return $this->belongsTo(Atividade::class);
    }

    public function composicaoCustos()
    {
        return $this->hasMany(ComposicaoCusto::class);
    }

    public function medicaoItens()
    {
        return $this->hasMany(MedicaoItem::class);
    }

    public function orcamentoItens()
    {
        return $this->hasMany(OrcamentoItem::class);
    }

    // ========== CÁLCULO DO ELEMENTAR (TODAS COMBINAÇÕES) ==========
    
    public function calcularElementar()
    {
        $c = $this->comprimento;
        $l = $this->largura;
        $h = $this->altura;
        
        $temC = !is_null($c) && $c > 0;
        $temL = !is_null($l) && $l > 0;
        $temH = !is_null($h) && $h > 0;
        
        if ($temC && $temL && $temH) {
            return $c * $l * $h;
        } elseif ($temC && $temL) {
            return $c * $l;
        } elseif ($temC && $temH) {
            return $c * $h;
        } elseif ($temL && $temH) {
            return $l * $h;
        } elseif ($temC) {
            return $c;
        } elseif ($temL) {
            return $l;
        } elseif ($temH) {
            return $h;
        }
        return 1;
    }

    public function calcularParcial()
    {
        return ($this->npi ?? 1) * $this->calcularElementar();
    }

    public function calcularQuantidadeProposta()
    {
        return $this->calcularParcial() * (1 + (($this->perda_percentual ?? 0) / 100));
    }

    public function recalcular()
    {
        $this->elementar = $this->calcularElementar();
        $this->parcial = $this->calcularParcial();
        $this->quantidade_proposta = $this->calcularQuantidadeProposta();
        $this->save();
        
        return $this;
    }

    // ========== EVENTOS AUTOMÁTICOS ==========
    
    protected static function booted()
    {
        static::saving(function ($subatividade) {
            $subatividade->elementar = $subatividade->calcularElementar();
            $subatividade->parcial = $subatividade->calcularParcial();
            $subatividade->quantidade_proposta = $subatividade->calcularQuantidadeProposta();
        });
    }

    // ========== ACESSORES ==========
    
    public function getTotalMateriaisAttribute()
    {
        return $this->composicaoCustos()
            ->where('tipo', 'material')
            ->sum('custo_total');
    }

    public function getTotalMaoObraAttribute()
    {
        return $this->composicaoCustos()
            ->where('tipo', 'mao_obra')
            ->sum('custo_total');
    }

    public function getPrecoUnitarioAttribute()
    {
        $total = $this->total_materiais + $this->total_mao_obra;
        return $this->quantidade_proposta > 0 ? $total / $this->quantidade_proposta : 0;
    }

    public function getTotalAttribute()
    {
        return $this->quantidade_proposta * $this->preco_unitario;
    }

    public function getFormulaDisplayAttribute()
    {
        $c = $this->comprimento;
        $l = $this->largura;
        $h = $this->altura;
        
        $temC = !is_null($c) && $c > 0;
        $temL = !is_null($l) && $l > 0;
        $temH = !is_null($h) && $h > 0;
        
        $partes = [];
        if ($temC) $partes[] = number_format($c, 2);
        if ($temL) $partes[] = number_format($l, 2);
        if ($temH) $partes[] = number_format($h, 2);
        
        if (count($partes) >= 2) {
            return implode(' × ', $partes);
        } elseif (count($partes) == 1) {
            return $partes[0];
        }
        return '1';
    }
}