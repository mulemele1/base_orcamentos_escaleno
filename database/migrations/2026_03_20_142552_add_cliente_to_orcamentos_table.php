<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClienteToOrcamentosTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('orcamentos', 'cliente')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->string('cliente')->nullable()->after('nome_projeto');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('orcamentos', 'cliente')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->dropColumn('cliente');
            });
        }
    }
}