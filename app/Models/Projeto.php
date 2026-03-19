<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projeto extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nome', 'cliente', 'localizacao', 'data_inicio', 'data_fim',
        'status', 'template_id', 'configuracoes', 'user_id'
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_fim' => 'date',
        'configuracoes' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(TemplateOrcamento::class);
    }

    public function orcamentos()
    {
        return $this->hasMany(Orcamento::class);
    }

    public function getOrcamentoAtivoAttribute()
    {
        return $this->orcamentos()->latest('versao')->first();
    }

    public function novaVersao()
    {
        $ultimoOrcamento = $this->orcamento_ativo;
        
        if (!$ultimoOrcamento) return null;

        $novoOrcamento = $ultimoOrcamento->replicate();
        $novoOrcamento->versao = $ultimoOrcamento->versao + 1;
        $novoOrcamento->status = 'rascunho';
        $novoOrcamento->data_emissao = now();
        $novoOrcamento->save();

        foreach ($ultimoOrcamento->orcamentoAtividades as $oa) {
            $novaOA = $oa->replicate();
            $novaOA->orcamento_id = $novoOrcamento->id;
            $novaOA->save();
        }

        return $novoOrcamento;
    }
}