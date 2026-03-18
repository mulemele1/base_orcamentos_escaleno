<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrecoMaterial extends Model
{
    protected $table = 'precos_materiais';
    
    protected $fillable = [
        'material_id', 'fornecedor_id', 'preco', 
        'unidade_compra', 'quantidade_compra', 
        'data_cotacao', 'referencia', 'estado', 'observacoes'
    ];
    
    protected $casts = [
        'data_cotacao' => 'date',
        'preco' => 'decimal:2'
    ];
    
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    
    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }
    
    // Preço normalizado para unidade padrão
    public function getPrecoUnitarioAttribute()
    {
        return $this->preco / $this->quantidade_compra;
    }
}