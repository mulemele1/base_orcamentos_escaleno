<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\SoftDeletes; // REMOVA ESTA LINHA

class Medicao extends Model
{
    use HasFactory;
    
    protected $table = 'medicoes';
    
    protected $fillable = [
        'projeto_id', 
        'componente_id', 
        'origem', 
        'prancha', 
        'data_medicao',
        'medido_por',
        'npi',
        'comprimento',
        'largura',
        'altura',
        'perda',
        'quantidade',
        'observacoes',
        'foto_path'
    ];
    
    protected $casts = [
        'data_medicao' => 'date',
        'npi' => 'integer',
        'comprimento' => 'decimal:2',
        'largura' => 'decimal:2',
        'altura' => 'decimal:2',
        'perda' => 'decimal:2',
        'quantidade' => 'decimal:2'
    ];
    
    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }
    
    public function componente()
    {
        return $this->belongsTo(Componente::class);
    }
    
    public function orcamentoItens()
    {
        return $this->hasMany(OrcamentoItem::class);
    }
}