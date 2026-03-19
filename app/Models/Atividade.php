<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atividade extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'codigo', 'nome', 'unidade', 'npi', 'categoria_obra_id', 'ordem'
    ];

    public function categoriaObra()
    {
        return $this->belongsTo(CategoriaObra::class);
    }

    public function subatividades()
    {
        return $this->hasMany(Subatividade::class)->orderBy('codigo');
    }

    public function orcamentoAtividades()
    {
        return $this->hasMany(OrcamentoAtividade::class);
    }
}