<?php
// database/seeders/CapitulosSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Capitulo;
use App\Models\Modulo;

class CapitulosSeeder extends Seeder
{
    public function run()
    {
        // Buscar o módulo "4. BETÕES, AÇOS E COFRAGEM"
        $moduloBetões = Modulo::where('nome', '4. BETÕES, AÇOS E COFRAGEM')->first();
        
        $capitulos = [
            // Capítulos do Módulo 4
            ['modulo_id' => $moduloBetões->id, 'nome' => 'Betões', 'ordem' => 1],
            ['modulo_id' => $moduloBetões->id, 'nome' => 'Aços', 'ordem' => 2],
            ['modulo_id' => $moduloBetões->id, 'nome' => 'Cofragem', 'ordem' => 3],
            
            // Capítulos do Módulo 5 - ALVENARIAS
            ['modulo_id' => Modulo::where('nome', '5. ALVENARIAS')->first()?->id, 'nome' => 'Alvenaria de Fundação', 'ordem' => 1],
            ['modulo_id' => Modulo::where('nome', '5. ALVENARIAS')->first()?->id, 'nome' => 'Alvenaria Elevação', 'ordem' => 2],
            
            // Capítulos do Módulo 6 - COBERTURAS
            ['modulo_id' => Modulo::where('nome', '6. COBERTURAS E TECTOS')->first()?->id, 'nome' => 'Cobertura', 'ordem' => 1],
            ['modulo_id' => Modulo::where('nome', '6. COBERTURAS E TECTOS')->first()?->id, 'nome' => 'Tectos Falsos', 'ordem' => 2],
            
            // Capítulos do Módulo 7 - ACABAMENTOS
            ['modulo_id' => Modulo::where('nome', '7. ACABAMENTOS DE PAVIMENTOS E PAREDES')->first()?->id, 'nome' => 'Pavimentos', 'ordem' => 1],
            ['modulo_id' => Modulo::where('nome', '7. ACABAMENTOS DE PAVIMENTOS E PAREDES')->first()?->id, 'nome' => 'Paredes', 'ordem' => 2],
            
            // Capítulos do Módulo 8 - CAIXILHARIA
            ['modulo_id' => Modulo::where('nome', '8. CAIXILHARIA')->first()?->id, 'nome' => 'Portas', 'ordem' => 1],
            ['modulo_id' => Modulo::where('nome', '8. CAIXILHARIA')->first()?->id, 'nome' => 'Janelas', 'ordem' => 2],
            
            // Capítulos do Módulo 11 - INSTALAÇÕES HIDRÁULICAS
            ['modulo_id' => Modulo::where('nome', '11. INSTALAÇÕES HIDRÁULICAS')->first()?->id, 'nome' => 'Abastecimento de Água', 'ordem' => 1],
            ['modulo_id' => Modulo::where('nome', '11. INSTALAÇÕES HIDRÁULICAS')->first()?->id, 'nome' => 'Drenagem e Saneamento', 'ordem' => 2],
            
            // Capítulos do Módulo 12 - INSTALAÇÕES ELÉCTRICAS
            ['modulo_id' => Modulo::where('nome', '12. INSTALAÇÕES ELÉCTRICAS')->first()?->id, 'nome' => 'Quadros e Disjuntores', 'ordem' => 1],
            ['modulo_id' => Modulo::where('nome', '12. INSTALAÇÕES ELÉCTRICAS')->first()?->id, 'nome' => 'Fiação e Tubulação', 'ordem' => 2],
            ['modulo_id' => Modulo::where('nome', '12. INSTALAÇÕES ELÉCTRICAS')->first()?->id, 'nome' => 'Iluminação', 'ordem' => 3],
            ['modulo_id' => Modulo::where('nome', '12. INSTALAÇÕES ELÉCTRICAS')->first()?->id, 'nome' => 'Tomadas e Interruptores', 'ordem' => 4],
        ];
        
        foreach ($capitulos as $capitulo) {
            if ($capitulo['modulo_id']) {
                Capitulo::updateOrCreate(
                    ['modulo_id' => $capitulo['modulo_id'], 'nome' => $capitulo['nome']],
                    ['ordem' => $capitulo['ordem']]
                );
            }
        }
    }
}