<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('orcamentos', 'medicao_id')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->foreignId('medicao_id')->nullable()->after('projeto_id')->constrained()->onDelete('set null');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('orcamentos', 'medicao_id')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->dropForeign(['medicao_id']);
                $table->dropColumn('medicao_id');
            });
        }
    }
};