<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicaoItem extends Model
{
    use SoftDeletes;

    protected $table = 'medicao_items';

    protected $fillable = [
        'medicao_id', 'subatividade_id', 
        'comprimento', 'largura', 'altura', 
        'perda_percentual', 'npi',
        'quantidade_calculada', 'quantidade_proposta', 
        'unidade', 'preco_unitario', 'subtotal', 'ordem'
    ];

    protected $casts = [
        'comprimento' => 'decimal:2',
        'largura' => 'decimal:2',
        'altura' => 'decimal:2',
        'perda_percentual' => 'decimal:2',
        'quantidade_calculada' => 'decimal:2',
        'quantidade_proposta' => 'decimal:2',
        'preco_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function medicao()
    {
        return $this->belongsTo(Medicao::class);
    }

    public function subatividade()
    {
        return $this->belongsTo(Subatividade::class);
    }

    public function calcularSubtotal()
    {
        $total = 0;
        foreach ($this->subatividade->composicaoCustos as $composicao) {
            $custo = $composicao->custo_unitario * $composicao->quantidade * $this->quantidade_proposta;
            $total += $custo;
        }
        $this->subtotal = $total;
        $this->preco_unitario = $this->quantidade_proposta > 0 ? $total / $this->quantidade_proposta : 0;
        return $this;
    }
}