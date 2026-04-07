<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capitulo extends Model
{
    use HasFactory;
    
    protected $fillable = ['modulo_id', 'nome', 'ordem', 'descricao'];
    
    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }
    
    public function actividades()
    {
        return $this->hasMany(Actividade::class)->orderBy('ordem');
    }
}
