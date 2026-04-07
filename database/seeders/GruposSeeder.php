<?php
// database/seeders/GruposSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Grupo;
use App\Models\Actividade;

class GruposSeeder extends Seeder
{
    public function run()
    {
        // Buscar a actividade de armaduras
        $actividadeAços = Actividade::where('nome', 'Armaduras de Aço CA-50')->first();
        
        if ($actividadeAços) {
            $grupos = [
                [
                    'actividade_id' => $actividadeAços->id,
                    'nome' => 'Aço 6mm',
                    'unidade_padrao' => 'kg',
                    'ordem' => 1
                ],
                [
                    'actividade_id' => $actividadeAços->id,
                    'nome' => 'Aço 8mm',
                    'unidade_padrao' => 'kg',
                    'ordem' => 2
                ],
                [
                    'actividade_id' => $actividadeAços->id,
                    'nome' => 'Aço 10mm',
                    'unidade_padrao' => 'kg',
                    'ordem' => 3
                ],
                [
                    'actividade_id' => $actividadeAços->id,
                    'nome' => 'Aço 12mm',
                    'unidade_padrao' => 'kg',
                    'ordem' => 4
                ],
                [
                    'actividade_id' => $actividadeAços->id,
                    'nome' => 'Aço 16mm',
                    'unidade_padrao' => 'kg',
                    'ordem' => 5
                ],
            ];
            
            foreach ($grupos as $grupo) {
                Grupo::updateOrCreate(
                    ['actividade_id' => $grupo['actividade_id'], 'nome' => $grupo['nome']],
                    ['unidade_padrao' => $grupo['unidade_padrao'], 'ordem' => $grupo['ordem']]
                );
            }
        }
    }
}