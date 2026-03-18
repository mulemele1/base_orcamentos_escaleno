<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemOrcamento extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'itens_orcamento'; // <-- ADICIONE ESTA LINHA

    protected $fillable = [
        'categoria_obra_id',
        'material_id',
        'item',
        'descricao',
        'unidade',
        'npi',
        'comprimento',
        'largura',
        'altura',
        'elementar',
        'parcial',
        'perdas',
        'quantidade_proposta',
        'custo_fornecimento',
        'custo_mao_obra',
        'preco_unitario',
        'total',
        'comentarios'
    ];

    protected $casts = [
        'npi' => 'integer',
        'comprimento' => 'decimal:2',
        'largura' => 'decimal:2',
        'altura' => 'decimal:2',
        'elementar' => 'decimal:2',
        'parcial' => 'decimal:2',
        'perdas' => 'decimal:2',
        'quantidade_proposta' => 'decimal:2',
        'custo_fornecimento' => 'decimal:2',
        'custo_mao_obra' => 'decimal:2',
        'preco_unitario' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    /**
     * Relacionamento com categoria
     */
    public function categoria()
    {
        return $this->belongsTo(CategoriaObra::class, 'categoria_obra_id');
    }

    /**
     * Relacionamento com material
     */
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}