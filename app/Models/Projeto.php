<?php
// app/Models/Projeto.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;  // Adicionar

class Projeto extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nome', 
        'cliente', 
        'localizacao',
        'descricao', 
        'data_inicio', 
        'data_fim', 
        'status', 
        'user_id',
        'iva',
        'contingencia'
    ];

    
    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'iva' => 'decimal:2',
        'contingencia' => 'decimal:2',
    ];
    
    // Status formatado para exibição
    public function getStatusFormatadoAttribute()
    {
        $statuses = [
            'rascunho' => 'Rascunho',
            'medicao' => 'Em Medição',
            'orcamento' => 'Orçamento',
            'concluido' => 'Concluído',
        ];
        
        return $statuses[$this->status] ?? ucfirst($this->status);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function medicoes()
    {
        return $this->hasMany(Medicao::class);
    }
    
    public function orcamentos()
    {
        return $this->hasMany(Orcamento::class);
    }
    
    public function getProgressoMedicaoAttribute()
    {
        $totalComponentes = Componente::count();
        if ($totalComponentes == 0) return 0;
        
        $medidos = $this->medicoes()->distinct('componente_id')->count('componente_id');
        return round(($medidos / $totalComponentes) * 100);
    }
    
    public function getQuantidadeTotalAttribute()
    {
        return $this->medicoes()->sum('quantidade');
    }
    
    // Valor total do projeto (soma de todos os orçamentos)
    public function getValorTotalAttribute()
    {
        return $this->orcamentos()->latest()->first()->total_geral ?? 0;
    }
}