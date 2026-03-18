<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'configuracoes'; // <-- ADICIONE ESTA LINHA

    protected $fillable = [
        'chave',
        'nome',
        'valor',
        'tipo',
        'descricao'
    ];

    protected $casts = [
        'valor' => 'decimal:2'
    ];

    /**
     * Buscar configuração por chave
     */
    public static function getValor($chave, $default = 0)
    {
        $config = self::where('chave', $chave)->first();
        return $config ? $config->valor : $default;
    }
}