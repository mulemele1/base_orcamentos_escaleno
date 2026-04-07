<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetosssTable extends Migration
{
    public function up()
    {
       // Migration para garantir campos adicionais
Schema::table('projetos', function (Blueprint $table) {
    if (!Schema::hasColumn('projetos', 'data_medicao_inicio')) {
        $table->date('data_medicao_inicio')->nullable();
    }
    if (!Schema::hasColumn('projetos', 'data_medicao_fim')) {
        $table->date('data_medicao_fim')->nullable();
    }
    if (!Schema::hasColumn('projetos', 'data_orcamento_inicio')) {
        $table->date('data_orcamento_inicio')->nullable();
    }
    if (!Schema::hasColumn('projetos', 'data_orcamento_fim')) {
        $table->date('data_orcamento_fim')->nullable();
    }
    if (!Schema::hasColumn('projetos', 'status_medicao')) {
        $table->enum('status_medicao', ['nao_iniciada', 'em_andamento', 'concluida'])->default('nao_iniciada');
    }
    if (!Schema::hasColumn('projetos', 'status_orcamento')) {
        $table->enum('status_orcamento', ['nao_iniciado', 'em_andamento', 'concluido'])->default('nao_iniciado');
    }
});
    }

    public function down()
    {
        Schema::dropIfExists('projetos');
    }
}