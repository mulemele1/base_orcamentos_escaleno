<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;
    
    protected $fillable = ['nome', 'ordem', 'descricao'];
    
    public function capitulos()
    {
        return $this->hasMany(Capitulo::class)->orderBy('ordem');
    }
}
