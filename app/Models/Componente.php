<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Componente extends Model
{
    use HasFactory;
    
    protected $table = 'componentes';  // ← ADICIONE
    
    protected $fillable = [
        'grupo_id', 'actividade_id', 'nome', 'unidade', 
        'formula_calculo', 'valor_padrao', 'perda_padrao', 'ordem'
    ];
    
    protected $casts = [
        'valor_padrao' => 'decimal:2',
        'perda_padrao' => 'decimal:2'
    ];
    
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }
    
    public function actividade()
    {
        return $this->belongsTo(Actividade::class);
    }
    
    public function medicoes()
    {
        return $this->hasMany(Medicao::class);
    }
    
    // Método para calcular a quantidade
    public function calcularQuantidade($npi, $comprimento, $largura, $altura, $perda = null)
    {
        $perda = $perda ?? $this->perda_padrao;
        $elementar = $this->calcularElementar($npi, $comprimento, $largura, $altura);
        return round($elementar * (1 + ($perda / 100)), 2);
    }
    
    public function calcularElementar($npi, $comprimento, $largura, $altura)
    {
        switch($this->formula_calculo) {
            case 'volume':
                return $npi * $comprimento * $largura * $altura;
            case 'area':
                return $npi * $comprimento * $largura;
            case 'area_parede':
                return $npi * $comprimento * $altura;
            case 'area_lateral':
                return $npi * $largura * $altura;
            case 'comprimento':
                return $npi * $comprimento;
            case 'largura':
                return $npi * $largura;
            case 'altura':
                return $npi * $altura;
            case 'valor_fixo':
                return $npi * ($altura > 0 ? $altura : $this->valor_padrao ?? 1);
            default:
                return 0;
        }
    }
}