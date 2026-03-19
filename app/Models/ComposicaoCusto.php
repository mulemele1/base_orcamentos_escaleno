<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComposicaoCusto extends Model
{
    protected $table = 'composicao_custos';

    protected $fillable = [
        'subatividade_id', 'material_id', 'quantidade', 'unidade',
        'custo_unitario', 'custo_total', 'mao_obra_percentual', 'tipo'
    ];

    protected $casts = [
        'quantidade' => 'decimal:2',
        'custo_unitario' => 'decimal:2',
        'custo_total' => 'decimal:2',
        'mao_obra_percentual' => 'decimal:2',
    ];

    public function subatividade()
    {
        return $this->belongsTo(Subatividade::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    protected static function booted()
    {
        static::saving(function ($composicao) {
            if ($composicao->material && !$composicao->custo_unitario) {
                $composicao->custo_unitario = $composicao->material->valor_compra;
            }
            if ($composicao->quantidade && $composicao->custo_unitario) {
                $composicao->custo_total = $composicao->quantidade * $composicao->custo_unitario;
            }
        });
    }
}