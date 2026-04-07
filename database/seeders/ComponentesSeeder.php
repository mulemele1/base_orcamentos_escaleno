<?php
// database/seeders/ComponentesSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Componente;
use App\Models\Actividade;
use App\Models\Grupo;

class ComponentesSeeder extends Seeder
{
    public function run()
    {
        // ==================== BETÃO DE LIMPEZA ====================
        $actividadeBetãoLimpeza = Actividade::where('nome', 'Betão de Limpeza C15/20')->first();
        
        if ($actividadeBetãoLimpeza) {
            $componentes = [
                [
                    'actividade_id' => $actividadeBetãoLimpeza->id,
                    'grupo_id' => null,
                    'nome' => 'Sapata corrida',
                    'unidade' => 'm³',
                    'formula_calculo' => 'volume',
                    'perda_padrao' => 5,
                    'ordem' => 1
                ],
                [
                    'actividade_id' => $actividadeBetãoLimpeza->id,
                    'grupo_id' => null,
                    'nome' => 'Sapata isolada',
                    'unidade' => 'm³',
                    'formula_calculo' => 'volume',
                    'perda_padrao' => 5,
                    'ordem' => 2
                ],
                [
                    'actividade_id' => $actividadeBetãoLimpeza->id,
                    'grupo_id' => null,
                    'nome' => 'Laje de pavimento',
                    'unidade' => 'm³',
                    'formula_calculo' => 'volume',
                    'perda_padrao' => 5,
                    'ordem' => 3
                ],
            ];
            
            foreach ($componentes as $componente) {
                Componente::updateOrCreate(
                    [
                        'actividade_id' => $componente['actividade_id'],
                        'nome' => $componente['nome']
                    ],
                    $componente
                );
            }
        }
        
        // ==================== BETÃO ESTRUTURAL ====================
        $actividadeBetãoEstrutural = Actividade::where('nome', 'Betão Estrutural C20/25')->first();
        
        if ($actividadeBetãoEstrutural) {
            $componentes = [
                [
                    'actividade_id' => $actividadeBetãoEstrutural->id,
                    'grupo_id' => null,
                    'nome' => 'Sapata corrida',
                    'unidade' => 'm³',
                    'formula_calculo' => 'volume',
                    'perda_padrao' => 5,
                    'ordem' => 1
                ],
                [
                    'actividade_id' => $actividadeBetãoEstrutural->id,
                    'grupo_id' => null,
                    'nome' => 'Sapata isolada',
                    'unidade' => 'm³',
                    'formula_calculo' => 'volume',
                    'perda_padrao' => 5,
                    'ordem' => 2
                ],
                [
                    'actividade_id' => $actividadeBetãoEstrutural->id,
                    'grupo_id' => null,
                    'nome' => 'Viga de fundação',
                    'unidade' => 'm³',
                    'formula_calculo' => 'volume',
                    'perda_padrao' => 5,
                    'ordem' => 3
                ],
                [
                    'actividade_id' => $actividadeBetãoEstrutural->id,
                    'grupo_id' => null,
                    'nome' => 'Viga de pavimento',
                    'unidade' => 'm³',
                    'formula_calculo' => 'volume',
                    'perda_padrao' => 5,
                    'ordem' => 4
                ],
                [
                    'actividade_id' => $actividadeBetãoEstrutural->id,
                    'grupo_id' => null,
                    'nome' => 'Pilar',
                    'unidade' => 'm³',
                    'formula_calculo' => 'volume',
                    'perda_padrao' => 5,
                    'ordem' => 5
                ],
                [
                    'actividade_id' => $actividadeBetãoEstrutural->id,
                    'grupo_id' => null,
                    'nome' => 'Laje de pavimento',
                    'unidade' => 'm³',
                    'formula_calculo' => 'volume',
                    'perda_padrao' => 5,
                    'ordem' => 6
                ],
                [
                    'actividade_id' => $actividadeBetãoEstrutural->id,
                    'grupo_id' => null,
                    'nome' => 'Viga de topo de portas e janelas',
                    'unidade' => 'm³',
                    'formula_calculo' => 'volume',
                    'perda_padrao' => 5,
                    'ordem' => 7
                ],
            ];
            
            foreach ($componentes as $componente) {
                Componente::updateOrCreate(
                    [
                        'actividade_id' => $componente['actividade_id'],
                        'nome' => $componente['nome']
                    ],
                    $componente
                );
            }
        }
        
        // ==================== PEDRA MEDIANA ====================
        $actividadePedraMediana = Actividade::where('nome', 'Pedra Mediana (Enrocamento)')->first();
        
        if ($actividadePedraMediana) {
            $componentes = [
                [
                    'actividade_id' => $actividadePedraMediana->id,
                    'grupo_id' => null,
                    'nome' => 'Sapata corrida',
                    'unidade' => 'm³',
                    'formula_calculo' => 'volume',
                    'perda_padrao' => 5,
                    'ordem' => 1
                ],
                [
                    'actividade_id' => $actividadePedraMediana->id,
                    'grupo_id' => null,
                    'nome' => 'Sapata isolada',
                    'unidade' => 'm³',
                    'formula_calculo' => 'volume',
                    'perda_padrao' => 5,
                    'ordem' => 2
                ],
                [
                    'actividade_id' => $actividadePedraMediana->id,
                    'grupo_id' => null,
                    'nome' => 'Laje de pavimento',
                    'unidade' => 'm³',
                    'formula_calculo' => 'volume',
                    'perda_padrao' => 5,
                    'ordem' => 3
                ],
            ];
            
            foreach ($componentes as $componente) {
                Componente::updateOrCreate(
                    [
                        'actividade_id' => $componente['actividade_id'],
                        'nome' => $componente['nome']
                    ],
                    $componente
                );
            }
        }
        
        // ==================== AÇOS (com grupos) ====================
        $actividadeAços = Actividade::where('nome', 'Armaduras de Aço CA-50')->first();
        
        if ($actividadeAços) {
            // Buscar grupos
            $grupo6mm = Grupo::where('nome', 'Aço 6mm')->first();
            $grupo8mm = Grupo::where('nome', 'Aço 8mm')->first();
            $grupo10mm = Grupo::where('nome', 'Aço 10mm')->first();
            $grupo12mm = Grupo::where('nome', 'Aço 12mm')->first();
            $grupo16mm = Grupo::where('nome', 'Aço 16mm')->first();
            
            // Aço 6mm
            if ($grupo6mm) {
                $componentes = [
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo6mm->id,
                        'nome' => 'Viga de travamento de fundação',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 19.00,
                        'perda_padrao' => 0,
                        'ordem' => 1
                    ],
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo6mm->id,
                        'nome' => 'Pilares de arranque',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 15.00,
                        'perda_padrao' => 0,
                        'ordem' => 2
                    ],
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo6mm->id,
                        'nome' => 'Viga de pavimento',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 19.00,
                        'perda_padrao' => 0,
                        'ordem' => 3
                    ],
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo6mm->id,
                        'nome' => 'Pilares acima da cota do pavimento',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 27.00,
                        'perda_padrao' => 0,
                        'ordem' => 4
                    ],
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo6mm->id,
                        'nome' => 'Viga de topo de portas e janelas',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 13.00,
                        'perda_padrao' => 0,
                        'ordem' => 5
                    ],
                ];
                
                foreach ($componentes as $componente) {
                    Componente::updateOrCreate(
                        [
                            'actividade_id' => $componente['actividade_id'],
                            'grupo_id' => $componente['grupo_id'],
                            'nome' => $componente['nome']
                        ],
                        $componente
                    );
                }
            }
            
            // Aço 8mm
            if ($grupo8mm) {
                $componentes = [
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo8mm->id,
                        'nome' => 'Laje de pavimento',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 79.00,
                        'perda_padrao' => 0,
                        'ordem' => 1
                    ],
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo8mm->id,
                        'nome' => 'Degraus da pia baptismal',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 15.00,
                        'perda_padrao' => 0,
                        'ordem' => 2
                    ],
                ];
                
                foreach ($componentes as $componente) {
                    Componente::updateOrCreate(
                        [
                            'actividade_id' => $componente['actividade_id'],
                            'grupo_id' => $componente['grupo_id'],
                            'nome' => $componente['nome']
                        ],
                        $componente
                    );
                }
            }
            
            // Aço 10mm
            if ($grupo10mm) {
                $componentes = [
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo10mm->id,
                        'nome' => 'Sapatas isoladas',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 33.00,
                        'perda_padrao' => 0,
                        'ordem' => 1
                    ],
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo10mm->id,
                        'nome' => 'Viga de travamento de fundação',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 62.00,
                        'perda_padrao' => 0,
                        'ordem' => 2
                    ],
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo10mm->id,
                        'nome' => 'Pilares de arranque',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 67.00,
                        'perda_padrao' => 0,
                        'ordem' => 3
                    ],
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo10mm->id,
                        'nome' => 'Vigas de pavimento',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 62.00,
                        'perda_padrao' => 0,
                        'ordem' => 4
                    ],
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo10mm->id,
                        'nome' => 'Pilares acima da cota do pavimento',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 105.00,
                        'perda_padrao' => 0,
                        'ordem' => 5
                    ],
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo10mm->id,
                        'nome' => 'Vigas de topo de portas e janelas',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 42.00,
                        'perda_padrao' => 0,
                        'ordem' => 6
                    ],
                ];
                
                foreach ($componentes as $componente) {
                    Componente::updateOrCreate(
                        [
                            'actividade_id' => $componente['actividade_id'],
                            'grupo_id' => $componente['grupo_id'],
                            'nome' => $componente['nome']
                        ],
                        $componente
                    );
                }
            }
            
            // Aço 12mm
            if ($grupo12mm) {
                $componentes = [
                    [
                        'actividade_id' => $actividadeAços->id,
                        'grupo_id' => $grupo12mm->id,
                        'nome' => 'Pilares principais',
                        'unidade' => 'kg',
                        'formula_calculo' => 'valor_fixo',
                        'valor_padrao' => 174.00,
                        'perda_padrao' => 0,
                        'ordem' => 1
                    ],
                ];
                
                foreach ($componentes as $componente) {
                    Componente::updateOrCreate(
                        [
                            'actividade_id' => $componente['actividade_id'],
                            'grupo_id' => $componente['grupo_id'],
                            'nome' => $componente['nome']
                        ],
                        $componente
                    );
                }
            }
        }
        
        // ==================== COFRAGEM ====================
        $actividadeCofragem = Actividade::where('nome', 'Cofragem e Descofragem')->first();
        
        if ($actividadeCofragem) {
            $componentes = [
                [
                    'actividade_id' => $actividadeCofragem->id,
                    'grupo_id' => null,
                    'nome' => 'Sapata isolada',
                    'unidade' => 'm²',
                    'formula_calculo' => 'area_lateral',
                    'perda_padrao' => 5,
                    'ordem' => 1
                ],
                [
                    'actividade_id' => $actividadeCofragem->id,
                    'grupo_id' => null,
                    'nome' => 'Pilar',
                    'unidade' => 'm²',
                    'formula_calculo' => 'area_lateral',
                    'perda_padrao' => 5,
                    'ordem' => 2
                ],
                [
                    'actividade_id' => $actividadeCofragem->id,
                    'grupo_id' => null,
                    'nome' => 'Viga',
                    'unidade' => 'm²',
                    'formula_calculo' => 'area_lateral',
                    'perda_padrao' => 5,
                    'ordem' => 3
                ],
                [
                    'actividade_id' => $actividadeCofragem->id,
                    'grupo_id' => null,
                    'nome' => 'Laje',
                    'unidade' => 'm²',
                    'formula_calculo' => 'area',
                    'perda_padrao' => 5,
                    'ordem' => 4
                ],
            ];
            
            foreach ($componentes as $componente) {
                Componente::updateOrCreate(
                    [
                        'actividade_id' => $componente['actividade_id'],
                        'nome' => $componente['nome']
                    ],
                    $componente
                );
            }
        }
        
        // ==================== ALVENARIA DE FUNDAÇÃO ====================
        $actividadeAlvenariaFund = Actividade::where('nome', 'Alvenaria de Fundação')->first();
        
        if ($actividadeAlvenariaFund) {
            $componentes = [
                [
                    'actividade_id' => $actividadeAlvenariaFund->id,
                    'grupo_id' => null,
                    'nome' => 'Parede de fundação',
                    'unidade' => 'm²',
                    'formula_calculo' => 'area_parede',
                    'perda_padrao' => 5,
                    'ordem' => 1
                ],
            ];
            
            foreach ($componentes as $componente) {
                Componente::updateOrCreate(
                    [
                        'actividade_id' => $componente['actividade_id'],
                        'nome' => $componente['nome']
                    ],
                    $componente
                );
            }
        }
        
        // ==================== ALVENARIA DE ELEVAÇÃO ====================
        $actividadeAlvenariaElev = Actividade::where('nome', 'Alvenaria de Elevação')->first();
        
        if ($actividadeAlvenariaElev) {
            $componentes = [
                [
                    'actividade_id' => $actividadeAlvenariaElev->id,
                    'grupo_id' => null,
                    'nome' => 'Parede externa',
                    'unidade' => 'm²',
                    'formula_calculo' => 'area_parede',
                    'perda_padrao' => 5,
                    'ordem' => 1
                ],
                [
                    'actividade_id' => $actividadeAlvenariaElev->id,
                    'grupo_id' => null,
                    'nome' => 'Parede interna',
                    'unidade' => 'm²',
                    'formula_calculo' => 'area_parede',
                    'perda_padrao' => 5,
                    'ordem' => 2
                ],
            ];
            
            foreach ($componentes as $componente) {
                Componente::updateOrCreate(
                    [
                        'actividade_id' => $componente['actividade_id'],
                        'nome' => $componente['nome']
                    ],
                    $componente
                );
            }
        }
    }
}