<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaObra extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categorias_obra';

    protected $fillable = [
        'nome',
        'codigo',
        'descricao',
        'ordem'
    ];

    /**
     * Relacionamento com itens do orçamento
     */
    public function itens()
    {
        return $this->hasMany(ItemOrcamento::class, 'categoria_obra_id'); // CORRETO
    }

    /**
     * Calcula o subtotal da categoria
     */
    public function getSubtotalAttribute()
    {
        return $this->itens()->sum('total');
    }
}