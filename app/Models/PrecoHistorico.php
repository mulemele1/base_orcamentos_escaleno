<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecoHistorico extends Model
{
    use HasFactory;
    
    protected $fillable = ['preco_material_id', 'valor', 'data_inicio', 'data_fim'];
    
    protected $casts = [
        'valor' => 'decimal:2',
        'data_inicio' => 'date',
        'data_fim' => 'date'
    ];
    
    public function precoMaterial()
    {
        return $this->belongsTo(PrecoMaterial::class);
    }
}