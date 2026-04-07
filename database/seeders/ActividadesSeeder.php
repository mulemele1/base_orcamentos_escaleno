<?php
// database/seeders/ActividadesSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actividade;
use App\Models\Capitulo;

class ActividadesSeeder extends Seeder
{
    public function run()
    {
        // ==================== BETÕES ====================
        $capituloBetões = Capitulo::where('nome', 'Betões')->first();
        
        if ($capituloBetões) {
            $actividades = [
                [
                    'capitulo_id' => $capituloBetões->id,
                    'nome' => 'Betão de Limpeza C15/20',
                    'descricao' => 'Fornecimento e assentamento de betão de limpeza C15/20 em camada de 0.05m em fundações, incluindo regularização e compactação.',
                    'ordem' => 1
                ],
                [
                    'capitulo_id' => $capituloBetões->id,
                    'nome' => 'Betão Estrutural C20/25',
                    'descricao' => 'Fornecimento e assentamento de betão armado do tipo B, classe C20/25 em sapatas, vigas, pilares e lajes, incluindo trabalhos complementares.',
                    'ordem' => 2
                ],
                [
                    'capitulo_id' => $capituloBetões->id,
                    'nome' => 'Pedra Mediana (Enrocamento)',
                    'descricao' => 'Execução de trabalhos de fornecimento e assentamento de pedra mediana (enrocamento) em escavações, para receber betão de limpeza, incluindo rega e compactação.',
                    'ordem' => 3
                ],
            ];
            
            foreach ($actividades as $actividade) {
                Actividade::updateOrCreate(
                    ['capitulo_id' => $actividade['capitulo_id'], 'nome' => $actividade['nome']],
                    ['descricao' => $actividade['descricao'], 'ordem' => $actividade['ordem']]
                );
            }
        }
        
        // ==================== AÇOS ====================
        $capituloAços = Capitulo::where('nome', 'Aços')->first();
        
        if ($capituloAços) {
            $actividades = [
                [
                    'capitulo_id' => $capituloAços->id,
                    'nome' => 'Armaduras de Aço CA-50',
                    'descricao' => 'Fornecimento e execução de trabalhos de corte, dobragem, assentamento e amarração de armaduras em aço CA-50 sobre diversos elementos construtivos de acordo com o projecto de estruturas.',
                    'ordem' => 1
                ],
            ];
            
            foreach ($actividades as $actividade) {
                Actividade::updateOrCreate(
                    ['capitulo_id' => $actividade['capitulo_id'], 'nome' => $actividade['nome']],
                    ['descricao' => $actividade['descricao'], 'ordem' => $actividade['ordem']]
                );
            }
        }
        
        // ==================== COFRAGEM ====================
        $capituloCofragem = Capitulo::where('nome', 'Cofragem')->first();
        
        if ($capituloCofragem) {
            $actividades = [
                [
                    'capitulo_id' => $capituloCofragem->id,
                    'nome' => 'Cofragem e Descofragem',
                    'descricao' => 'Execução de cofragem e descofragem em madeira ou metálica em diversos elementos construtivos, incluindo nivelamento, escoramentos e travamentos.',
                    'ordem' => 1
                ],
            ];
            
            foreach ($actividades as $actividade) {
                Actividade::updateOrCreate(
                    ['capitulo_id' => $actividade['capitulo_id'], 'nome' => $actividade['nome']],
                    ['descricao' => $actividade['descricao'], 'ordem' => $actividade['ordem']]
                );
            }
        }
        
        // ==================== ALVENARIA ====================
        $capituloAlvenariaFund = Capitulo::where('nome', 'Alvenaria de Fundação')->first();
        
        if ($capituloAlvenariaFund) {
            $actividades = [
                [
                    'capitulo_id' => $capituloAlvenariaFund->id,
                    'nome' => 'Alvenaria de Fundação',
                    'descricao' => 'Fornecimento e assentamento de blocos maciços de fundação, com dimensões de 400mm x 200mm e 150mm de espessura, assentes com argamassa de cimento e areia ao traço 1:5.',
                    'ordem' => 1
                ],
            ];
            
            foreach ($actividades as $actividade) {
                Actividade::updateOrCreate(
                    ['capitulo_id' => $actividade['capitulo_id'], 'nome' => $actividade['nome']],
                    ['descricao' => $actividade['descricao'], 'ordem' => $actividade['ordem']]
                );
            }
        }
        
        $capituloAlvenariaElev = Capitulo::where('nome', 'Alvenaria Elevação')->first();
        
        if ($capituloAlvenariaElev) {
            $actividades = [
                [
                    'capitulo_id' => $capituloAlvenariaElev->id,
                    'nome' => 'Alvenaria de Elevação',
                    'descricao' => 'Fornecimento e assentamento de blocos vazados de cimento e areia, acima da cota de pavimento, com dimensões de 400mm x 200mm e 150mm de espessura, assentes com argamassa de cimento e areia ao traço 1:5.',
                    'ordem' => 1
                ],
            ];
            
            foreach ($actividades as $actividade) {
                Actividade::updateOrCreate(
                    ['capitulo_id' => $actividade['capitulo_id'], 'nome' => $actividade['nome']],
                    ['descricao' => $actividade['descricao'], 'ordem' => $actividade['ordem']]
                );
            }
        }
    }
}