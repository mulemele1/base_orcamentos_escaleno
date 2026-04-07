<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividade extends Model
{
    use HasFactory;
    
    protected $fillable = ['capitulo_id', 'nome', 'descricao', 'ordem'];
    
    public function capitulo()
    {
        return $this->belongsTo(Capitulo::class);
    }
    
    public function grupos()
    {
        return $this->hasMany(Grupo::class)->orderBy('ordem');
    }
    
    public function componentes()
    {
        return $this->hasMany(Componente::class)->whereNull('grupo_id')->orderBy('ordem');
    }
}
