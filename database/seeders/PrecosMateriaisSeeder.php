<?php
// database/seeders/PrecosMateriaisSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PrecoMaterial;
use App\Models\PrecoHistorico;
use App\Models\Capitulo;
use Carbon\Carbon;

class PrecosMateriaisSeeder extends Seeder
{
    public function run()
    {
        $categoriaBetões = Capitulo::where('nome', 'Betões')->first();
        $categoriaAços = Capitulo::where('nome', 'Aços')->first();
        $categoriaAlvenaria = Capitulo::where('nome', 'Alvenaria Elevação')->first();
        
        $materiais = [
            // Betões
            [
                'codigo' => 'CONC-01',
                'nome' => 'Betão C15/20',
                'unidade' => 'm³',
                'categoria_id' => $categoriaBetões?->id,
                'valor_atual' => 6800.00,
            ],
            [
                'codigo' => 'CONC-02',
                'nome' => 'Betão C20/25',
                'unidade' => 'm³',
                'categoria_id' => $categoriaBetões?->id,
                'valor_atual' => 7500.00,
            ],
            [
                'codigo' => 'CONC-03',
                'nome' => 'Betão C25/30',
                'unidade' => 'm³',
                'categoria_id' => $categoriaBetões?->id,
                'valor_atual' => 8200.00,
            ],
            
            // Aços
            [
                'codigo' => 'ACO-01',
                'nome' => 'Aço CA-50 6mm',
                'unidade' => 'kg',
                'categoria_id' => $categoriaAços?->id,
                'valor_atual' => 120.00,
            ],
            [
                'codigo' => 'ACO-02',
                'nome' => 'Aço CA-50 8mm',
                'unidade' => 'kg',
                'categoria_id' => $categoriaAços?->id,
                'valor_atual' => 175.00,
            ],
            [
                'codigo' => 'ACO-03',
                'nome' => 'Aço CA-50 10mm',
                'unidade' => 'kg',
                'categoria_id' => $categoriaAços?->id,
                'valor_atual' => 275.00,
            ],
            [
                'codigo' => 'ACO-04',
                'nome' => 'Aço CA-50 12mm',
                'unidade' => 'kg',
                'categoria_id' => $categoriaAços?->id,
                'valor_atual' => 375.00,
            ],
            [
                'codigo' => 'ACO-05',
                'nome' => 'Aço CA-50 16mm',
                'unidade' => 'kg',
                'categoria_id' => $categoriaAços?->id,
                'valor_atual' => 450.00,
            ],
            
            // Alvenaria
            [
                'codigo' => 'ALV-01',
                'nome' => 'Bloco de concreto 15cm',
                'unidade' => 'un',
                'categoria_id' => $categoriaAlvenaria?->id,
                'valor_atual' => 32.00,
            ],
            [
                'codigo' => 'ALV-02',
                'nome' => 'Argamassa de assentamento 1:5',
                'unidade' => 'm³',
                'categoria_id' => $categoriaAlvenaria?->id,
                'valor_atual' => 3800.00,
            ],
        ];
        
        foreach ($materiais as $material) {
            if ($material['categoria_id']) {
                $preco = PrecoMaterial::updateOrCreate(
                    ['codigo' => $material['codigo']],
                    [
                        'nome' => $material['nome'],
                        'unidade' => $material['unidade'],
                        'categoria_id' => $material['categoria_id'],
                        'valor_atual' => $material['valor_atual'],
                        'ativo' => true
                    ]
                );
                
                // Criar histórico inicial
                PrecoHistorico::updateOrCreate(
                    [
                        'preco_material_id' => $preco->id,
                        'data_inicio' => '2024-01-01'
                    ],
                    [
                        'valor' => $material['valor_atual'],
                        'data_fim' => null
                    ]
                );
            }
        }
    }
}