<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Configuracao;

class ConfiguracoesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $configuracoes = [
            [
                'chave' => 'iva',
                'nome' => 'IVA (Imposto sobre Valor Acrescentado)',
                'valor' => 16.00,
                'tipo' => 'percentual',
                'descricao' => 'IVA padrão para orçamentos de construção civil'
            ],
            [
                'chave' => 'contingencia',
                'nome' => 'Contingências',
                'valor' => 8.00,
                'tipo' => 'percentual',
                'descricao' => 'Percentual de contingência para imprevistos'
            ]
        ];

        foreach ($configuracoes as $config) {
            Configuracao::create($config);
        }

        $this->command->info('Configurações criadas com sucesso!');
    }
}