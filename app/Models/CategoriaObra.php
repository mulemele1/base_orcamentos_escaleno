<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaObra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categorias_obra';

    protected $fillable = [
        'nome', 'codigo', 'descricao', 'ordem'
    ];

    // RELACIONAMENTO COM ATIVIDADES (CORRETO)
    public function atividades()
    {
        return $this->hasMany(Atividade::class)->orderBy('ordem')->orderBy('codigo');
    }

    // Relacionamento com itens do orçamento (mantido para compatibilidade)
    public function itens()
    {
        return $this->hasMany(ItemOrcamento::class, 'categoria_obra_id');
    }

    // Calcula o subtotal da categoria (baseado em itens - sistema antigo)
    public function getSubtotalAttribute()
    {
        return $this->itens()->sum('total');
    }
    
    // Calcula o total da categoria baseado nas atividades (sistema novo)
    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->atividades as $atividade) {
            foreach ($atividade->subatividades as $sub) {
                $total += $sub->total;
            }
        }
        return $total;
    }

    // Calcula o total da categoria baseado no orçamento específico
    public function getTotalPorOrcamento($orcamentoId)
    {
        $total = 0;
        foreach ($this->atividades as $atividade) {
            // Verificar se a atividade está no orçamento
            $orcamentoAtividade = OrcamentoAtividade::where('orcamento_id', $orcamentoId)
                ->where('atividade_id', $atividade->id)
                ->first();
            
            if ($orcamentoAtividade) {
                foreach ($atividade->subatividades as $sub) {
                    $total += $sub->total;
                }
            }
        }
        return $total;
    }

    // Conta o número total de subatividades da categoria
    public function getTotalSubatividadesAttribute()
    {
        $total = 0;
        foreach ($this->atividades as $atividade) {
            $total += $atividade->subatividades->count();
        }
        return $total;
    }
}