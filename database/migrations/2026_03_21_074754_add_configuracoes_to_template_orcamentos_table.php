<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_configuracoes_to_template_orcamentos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfiguracoesToTemplateOrcamentosTable extends Migration
{
    public function up()
    {
        Schema::table('template_orcamentos', function (Blueprint $table) {
            if (!Schema::hasColumn('template_orcamentos', 'configuracoes')) {
                $table->json('configuracoes')->nullable()->after('descricao');
            }
            if (!Schema::hasColumn('template_orcamentos', 'estrutura')) {
                $table->json('estrutura')->nullable()->after('configuracoes');
            }
        });
    }

    public function down()
    {
        Schema::table('template_orcamentos', function (Blueprint $table) {
            $table->dropColumn(['configuracoes', 'estrutura']);
        });
    }
}