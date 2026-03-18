<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'materiais'; // <-- ADICIONE ESTA LINHA

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'nome',
        'unidade',
        'valor_compra',
        'rendimento',
        'categoria',
        'descricao',
        'observacoes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'valor_compra' => 'decimal:2',
        'rendimento' => 'decimal:2',
    ];

    /**
     * Escopo para buscar por categoria
     */
    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /**
     * Calcula o preço por unidade considerando o rendimento
     * Ex: Se 1 kg custa 550 e rende 50 m², o custo por m² é 550/50 = 11
     */
    public function getPrecoPorUnidadeRendimentoAttribute()
    {
        if ($this->rendimento > 0) {
            return $this->valor_compra / $this->rendimento;
        }
        return $this->valor_compra;
    }

    /**
     * Formata o valor para exibição
     */
    public function getValorCompraFormatadoAttribute()
    {
        return 'MT ' . number_format($this->valor_compra, 2, ',', '.');
    }

    /**
     * Formata o rendimento para exibição
     */
    public function getRendimentoFormatadoAttribute()
    {
        return number_format($this->rendimento, 2, ',', '.') . ' ' . $this->unidade;
    }
}