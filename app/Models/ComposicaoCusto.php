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
        'quantidade' => 'decimal:3',
        'custo_unitario' => 'decimal:2',
        'custo_total' => 'decimal:2',
        'mao_obra_percentual' => 'decimal:2',
    ];

    // ========== RELACIONAMENTOS ==========
    
    /**
     * Subatividade associada
     */
    public function subatividade()
    {
        return $this->belongsTo(Subatividade::class);
    }

    /**
     * Material utilizado
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    // ========== MÉTODOS DE CÁLCULO ==========
    
    /**
     * Calcular o custo total
     */
    public function calcularTotal()
    {
        $this->custo_total = $this->quantidade * $this->custo_unitario;
        return $this;
    }

    // ========== EVENTOS ==========
    
    protected static function booted()
    {
        // Antes de salvar, calcular o custo total
        static::saving(function ($composicao) {
            // Se não tem custo unitário, buscar do material
            if ($composicao->material && !$composicao->custo_unitario) {
                $composicao->custo_unitario = $composicao->material->valor_compra;
            }
            
            // Calcular custo total
            if ($composicao->quantidade && $composicao->custo_unitario) {
                $composicao->custo_total = $composicao->quantidade * $composicao->custo_unitario;
            }
        });

        // Após salvar, recalcular a subatividade
        static::saved(function ($composicao) {
            if ($composicao->subatividade) {
                $composicao->subatividade->recalcular();
            }
        });

        // Após deletar, recalcular a subatividade
        static::deleted(function ($composicao) {
            if ($composicao->subatividade) {
                $composicao->subatividade->recalcular();
            }
        });
    }
}