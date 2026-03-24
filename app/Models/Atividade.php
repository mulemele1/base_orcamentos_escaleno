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

    protected $casts = [
        'npi' => 'integer',
    ];

    public function categoriaObra()
    {
        return $this->belongsTo(CategoriaObra::class);
    }

    public function subatividades()
    {
        return $this->hasMany(Subatividade::class)->orderBy('ordem')->orderBy('codigo');
    }

    public function orcamentoAtividades()
    {
        return $this->hasMany(OrcamentoAtividade::class);
    }

    /**
     * Total da atividade (soma de todas as subatividades)
     */
    public function getTotalAttribute()
    {
        return $this->subatividades->sum('total');
    }
}