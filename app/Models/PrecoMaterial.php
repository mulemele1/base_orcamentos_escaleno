<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrecoMaterial extends Model
{
    use HasFactory;
    
    protected $fillable = ['codigo', 'nome', 'unidade', 'categoria_id', 'valor_atual', 'ativo'];
    
    protected $casts = [
        'valor_atual' => 'decimal:2',
        'ativo' => 'boolean'
    ];
    
    public function categoria()
    {
        return $this->belongsTo(Capitulo::class, 'categoria_id');
    }
    
    public function historicos()
    {
        return $this->hasMany(PrecoHistorico::class)->orderBy('data_inicio', 'desc');
    }
    
    public function getPrecoVigenteAttribute()
    {
        $historico = $this->historicos()
            ->where('data_inicio', '<=', now())
            ->where(function($q) {
                $q->whereNull('data_fim')->orWhere('data_fim', '>=', now());
            })
            ->first();
            
        return $historico ? $historico->valor : $this->valor_atual;
    }
}