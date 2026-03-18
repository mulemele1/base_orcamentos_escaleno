<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materiais = [
            // INERTES
            [
                'codigo' => '1.1',
                'nome' => 'Cimento portland normal 42.5N',
                'unidade' => 'kg',
                'valor_compra' => 550,
                'rendimento' => 50,
                'categoria' => 'Geral',
                'descricao' => 'Cimento para uso geral em construção',
            ],
            [
                'codigo' => '1.4',
                'nome' => 'Bloco de 15',
                'unidade' => 'Un',
                'valor_compra' => 32,
                'rendimento' => 1,
                'categoria' => 'Geral',
                'descricao' => 'Bloco vazado de cimento e areia 400x200x150mm',
            ],
            [
                'codigo' => '1.7',
                'nome' => 'Areia Grossa',
                'unidade' => 'm³',
                'valor_compra' => 22000,
                'rendimento' => 18,
                'categoria' => 'Geral',
            ],
            [
                'codigo' => '1.9',
                'nome' => 'Brita 3/4',
                'unidade' => 'm³',
                'valor_compra' => 25000,
                'rendimento' => 18,
                'categoria' => 'Geral',
            ],
            
            // BETÕES
            [
                'codigo' => '1.10',
                'nome' => 'Betão C15/20',
                'unidade' => 'm³',
                'valor_compra' => 6800,
                'rendimento' => 1,
                'categoria' => 'Betões',
            ],
            [
                'codigo' => '1.11',
                'nome' => 'Betão C20/25',
                'unidade' => 'm³',
                'valor_compra' => 7500,
                'rendimento' => 1,
                'categoria' => 'Betões',
            ],
            
            // HIDRÁULICA
            [
                'codigo' => '1.23',
                'nome' => 'Tubo PVC 50mm - Marley',
                'unidade' => 'ml',
                'valor_compra' => 1400,
                'rendimento' => 5.8,
                'categoria' => 'Hidráulica',
            ],
            [
                'codigo' => '1.24',
                'nome' => 'Tubo PVC 75mm - Marley',
                'unidade' => 'ml',
                'valor_compra' => 1800,
                'rendimento' => 5.8,
                'categoria' => 'Hidráulica',
            ],
            
            // AÇOS
            [
                'codigo' => '1.42',
                'nome' => 'Aço A400 6mm',
                'unidade' => 'kg',
                'valor_compra' => 120,
                'rendimento' => 1.2876, // 5.8 * 0.222
                'categoria' => 'Aços',
            ],
            
            // TINTAS
            [
                'codigo' => '1.80',
                'nome' => 'Tinta primária PVA (balde 15l)',
                'unidade' => 'm²',
                'valor_compra' => 15000,
                'rendimento' => 90, // 15 * 6
                'categoria' => 'Tintas',
            ],
        ];

        foreach ($materiais as $material) {
            Material::create($material);
        }

        $this->command->info('Materiais criados com sucesso!');
    }
}