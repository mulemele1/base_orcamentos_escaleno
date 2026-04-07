<?php
// app/Models/Orcamento.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orcamento extends Model
{
    use HasFactory;
    
    protected $table = 'orcamentos';  // ← ADICIONE
    
    protected $fillable = [
        'projeto_id', 'nome', 'data_orcamento', 
        'subtotal', 'iva', 'contingencias', 'total_geral', 'status'
    ];
    
    protected $casts = [
        'data_orcamento' => 'date',
        'subtotal' => 'decimal:2',
        'iva' => 'decimal:2',
        'contingencias' => 'decimal:2',
        'total_geral' => 'decimal:2'
    ];
    
    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
    
    public function itens()
    {
        return $this->hasMany(OrcamentoItem::class);
    }
}