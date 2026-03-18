<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'celular',
        'cpf_cnpj',
        'tipo_pessoa',
        'rg_ie',
        'data_nascimento',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'profissao',
        'empresa',
        'observacoes',
        'status'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
    ];
}