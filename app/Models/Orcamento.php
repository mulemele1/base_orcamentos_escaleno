<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orcamento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'projeto_id', 'template_id', 'codigo', 'nome_projeto', 'cliente',
        'localizacao', 'data_emissao', 'data_validade', 'versao', 'status',
        'iva_percentual', 'contingencia_percentual', 'observacoes', 'user_id'
    ];

    protected $casts = [
        'data_emissao' => 'date',
        'data_validade' => 'date',
        'iva_percentual' => 'decimal:2',
        'contingencia_percentual' => 'decimal:2',
    ];

    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    public function template()
    {
        return $this->belongsTo(TemplateOrcamento::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orcamentoAtividades()
    {
        return $this->hasMany(OrcamentoAtividade::class);
    }

    /**
     * Calcular subtotal do orçamento
     */
    public function getSubtotalAttribute()
    {
        return $this->orcamentoAtividades->sum('subtotal');
    }

    /**
     * Calcular valor do IVA
     */
    public function getValorIvaAttribute()
    {
        return $this->subtotal * ($this->iva_percentual / 100);
    }

    /**
     * Calcular valor das contingências
     */
    public function getValorContingenciasAttribute()
    {
        return ($this->subtotal + $this->valor_iva) * ($this->contingencia_percentual / 100);
    }

    /**
     * Calcular GRAND TOTAL
     */
    public function getGrandTotalAttribute()
    {
        return $this->subtotal + $this->valor_iva + $this->valor_contingencias;
    }

    /**
     * Gerar código automático
     */
    public static function gerarCodigo()
    {
        $ano = date('Y');
        $sequencia = self::whereYear('created_at', $ano)->count() + 1;
        return 'ORC-' . $ano . '-' . str_pad($sequencia, 4, '0', STR_PAD_LEFT);
    }
}