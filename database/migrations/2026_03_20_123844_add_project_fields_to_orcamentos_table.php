<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectFieldsToOrcamentosTable extends Migration
{
    public function up()
    {
        Schema::table('orcamentos', function (Blueprint $table) {
            $table->foreignId('projeto_id')->after('id')->nullable()->constrained();
            $table->foreignId('template_id')->after('projeto_id')->nullable()->constrained('template_orcamentos');
            $table->integer('versao')->default(1)->after('codigo');
        });
    }

    public function down()
    {
        Schema::table('orcamentos', function (Blueprint $table) {
            $table->dropForeign(['projeto_id']);
            $table->dropForeign(['template_id']);
            $table->dropColumn(['projeto_id', 'template_id', 'versao']);
        });
    }
}