<?php
// app/Models/OrcamentoItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrcamentoItem extends Model
{
    use HasFactory;
    
    protected $table = 'orcamento_itens';  // ← ADICIONE
    
    protected $fillable = [
        'orcamento_id', 'medicao_id', 'preco_material_id',
        'preco_unitario', 'quantidade', 'total'
    ];
    
    protected $casts = [
        'preco_unitario' => 'decimal:2',
        'quantidade' => 'decimal:2',
        'total' => 'decimal:2'
    ];
    
    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class);
    }
    
    public function medicao()
    {
        return $this->belongsTo(Medicao::class);
    }
    
    public function precoMaterial()
    {
        return $this->belongsTo(PrecoMaterial::class);
    }
}