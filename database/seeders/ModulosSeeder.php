<?php
// database/seeders/ModulosSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modulo;

class ModulosSeeder extends Seeder
{
    public function run()
    {
        $modulos = [
            ['nome' => '1. TRABALHOS PRELIMINARES', 'ordem' => 1],
            ['nome' => '2. DEMOLIÇÕES E REMOÇÕES', 'ordem' => 2],
            ['nome' => '3. MOVIMENTOS DE TERRA', 'ordem' => 3],
            ['nome' => '4. BETÕES, AÇOS E COFRAGEM', 'ordem' => 4],
            ['nome' => '5. ALVENARIAS', 'ordem' => 5],
            ['nome' => '6. COBERTURAS E TECTOS', 'ordem' => 6],
            ['nome' => '7. ACABAMENTOS DE PAVIMENTOS E PAREDES', 'ordem' => 7],
            ['nome' => '8. CAIXILHARIA', 'ordem' => 8],
            ['nome' => '9. EQUIPAMENTOS', 'ordem' => 9],
            ['nome' => '10. PINTURAS', 'ordem' => 10],
            ['nome' => '11. INSTALAÇÕES HIDRÁULICAS', 'ordem' => 11],
            ['nome' => '12. INSTALAÇÕES ELÉCTRICAS', 'ordem' => 12],
            ['nome' => '13. ARRANJOS EXTERIORES', 'ordem' => 13],
        ];
        
        foreach ($modulos as $modulo) {
            Modulo::updateOrCreate(
                ['nome' => $modulo['nome']],
                ['ordem' => $modulo['ordem']]
            );
        }
    }
}