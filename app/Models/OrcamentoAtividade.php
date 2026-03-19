<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrcamentoAtividade extends Model
{
    protected $fillable = [
        'orcamento_id', 'atividade_id', 'categoria_obra_id', 'subtotal'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
    ];

    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class);
    }

    public function atividade()
    {
        return $this->belongsTo(Atividade::class);
    }

    public function categoriaObra()
    {
        return $this->belongsTo(CategoriaObra::class);
    }
}