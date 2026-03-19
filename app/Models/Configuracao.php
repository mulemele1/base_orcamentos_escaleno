<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    use HasFactory;

    protected $table = 'configuracoes';
    
    protected $fillable = [
        'chave',
        'nome',
        'grupo',
        'valor',
        'tipo',
        'descricao'
    ];

    // Remova o casting ou ajuste conforme necessário
    protected $casts = [
        // Não faça casting para decimal se o campo pode ter texto
        // 'valor' => 'decimal:2', // REMOVA ISSO SE EXISTIR
    ];

    public static function get($chave, $default = null)
    {
        $config = self::where('chave', $chave)->first();
        return $config ? $config->valor : $default;
    }

    public static function set($chave, $valor)
    {
        $config = self::where('chave', $chave)->first();
        if ($config) {
            $config->valor = $valor;
            $config->save();
        }
        return $config;
    }
}