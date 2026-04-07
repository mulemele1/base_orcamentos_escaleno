<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    
    protected $fillable = ['actividade_id', 'nome', 'unidade_padrao', 'ordem'];
    
    public function actividade()
    {
        return $this->belongsTo(Actividade::class);
    }
    
    public function componentes()
    {
        return $this->hasMany(Componente::class)->orderBy('ordem');
    }
}