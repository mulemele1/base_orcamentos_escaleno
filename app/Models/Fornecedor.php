<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    // FORÇAR o nome correto da tabela
    protected $table = 'fornecedores';  // <--- ADICIONE ESTA LINHA
    
    protected $fillable = [
        'nome', 'localizacao', 'contacto', 'tipo', 
        'email', 'website', 'nuit', 'status'
    ];
    
    public function precos()
    {
        return $this->hasMany(PrecoMaterial::class);
    }
    
    public function materiais()
    {
        return $this->belongsToMany(Material::class, 'precos_materiais')
                    ->withPivot('preco', 'data_cotacao')
                    ->withTimestamps();
    }
}