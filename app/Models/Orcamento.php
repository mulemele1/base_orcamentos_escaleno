<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Orcamento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'projeto_id', 'template_id', 'user_id', 'codigo', 'versao',
        'nome_projeto', 'cliente', 'localizacao', 'data_emissao', 'data_validade',
        'subtotal', 'iva_percentual', 'valor_iva', 'contingencia_percentual',
        'valor_contingencia', 'grand_total', 'status', 'observacoes'
    ];

    protected $casts = [
        'data_emissao' => 'date',
        'data_validade' => 'date',
        'subtotal' => 'decimal:2',
        'iva_percentual' => 'decimal:2',
        'valor_iva' => 'decimal:2',
        'contingencia_percentual' => 'decimal:2',
        'valor_contingencia' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    // ========== RELACIONAMENTOS ==========
    
    /**
     * Projeto associado ao orçamento
     */
    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    /**
     * Template usado para criar este orçamento
     */
    public function template()
    {
        return $this->belongsTo(TemplateOrcamento::class);
    }

    /**
     * Usuário que criou o orçamento
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Atividades do orçamento (via tabela pivô)
     */
    public function orcamentoAtividades()
    {
        return $this->hasMany(OrcamentoAtividade::class);
    }

    /**
     * Categorias do orçamento (via orcamento_atividades)
     */
    public function categorias()
    {
        return $this->hasManyThrough(
            CategoriaObra::class,
            OrcamentoAtividade::class,
            'orcamento_id',           // Foreign key on orcamento_atividades table
            'id',                      // Local key on categorias_obra table
            'id',                      // Local key on orcamentos table
            'categoria_obra_id'        // Foreign key on orcamento_atividades table
        )->distinct();
    }

    // ========== MÉTODOS DE CÁLCULO ==========
    
    /**
     * Calcular subtotal (soma de todas as atividades)
     */
    public function calcularSubtotal()
    {
        $this->subtotal = $this->orcamentoAtividades()->sum('subtotal');
        return $this;
    }

    /**
     * Calcular IVA
     */
    public function calcularIva()
    {
        $this->valor_iva = $this->subtotal * ($this->iva_percentual / 100);
        return $this;
    }

    /**
     * Calcular contingência
     */
    public function calcularContingencia()
    {
        $this->valor_contingencia = ($this->subtotal + $this->valor_iva) * ($this->contingencia_percentual / 100);
        return $this;
    }

    /**
     * Calcular total geral
     */
    public function calcularGrandTotal()
    {
        $this->grand_total = $this->subtotal + $this->valor_iva + $this->valor_contingencia;
        return $this;
    }

    /**
     * Recalcular todos os valores
     */
    public function recalcularTodos()
    {
        $this->calcularSubtotal();
        $this->calcularIva();
        $this->calcularContingencia();
        $this->calcularGrandTotal();
        $this->save();
        
        return $this;
    }

    // ========== ACESSORES ==========
    
    /**
     * Obter subtotal (se não calculado)
     */
    public function getSubtotalAttribute($value)
    {
        if ($value === null || $value == 0) {
            return $this->orcamentoAtividades()->sum('subtotal');
        }
        return $value;
    }

    /**
     * Obter valor do IVA
     */
    public function getValorIvaAttribute($value)
    {
        if ($value === null || $value == 0) {
            return $this->subtotal * ($this->iva_percentual / 100);
        }
        return $value;
    }

    /**
     * Obter valor da contingência
     */
    public function getValorContingenciaAttribute($value)
    {
        if ($value === null || $value == 0) {
            return ($this->subtotal + $this->valor_iva) * ($this->contingencia_percentual / 100);
        }
        return $value;
    }

    /**
     * Obter total geral
     */
    public function getGrandTotalAttribute($value)
    {
        if ($value === null || $value == 0) {
            return $this->subtotal + $this->valor_iva + $this->valor_contingencia;
        }
        return $value;
    }

    // ========== MÉTODOS ESTÁTICOS ==========
    
    /**
     * Gerar código único para o orçamento
     */
    public static function gerarCodigo()
    {
        $ano = date('Y');
        $sequencia = self::whereYear('created_at', $ano)->count() + 1;
        return 'ORC-' . $ano . '-' . str_pad($sequencia, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Escopos de busca
     */
    public function scopeRascunho($query)
    {
        return $query->where('status', 'rascunho');
    }

    public function scopeAprovado($query)
    {
        return $query->where('status', 'aprovado');
    }

    public function scopeEmAnalise($query)
    {
        return $query->where('status', 'em_analise');
    }

    // app/Models/Orcamento.php

public function aprovar()
{
    $this->status = 'aprovado';
    $this->data_aprovacao = now();
    $this->aprovado_por = auth()->id();
    $this->save();
}

public function rejeitar($motivo)
{
    $this->status = 'rejeitado';
    $this->motivo_rejeicao = $motivo;
    $this->save();
}

}