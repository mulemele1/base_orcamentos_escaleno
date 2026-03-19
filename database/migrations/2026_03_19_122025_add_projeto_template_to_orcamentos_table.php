<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orcamentos', function (Blueprint $table) {
            // Verificar se as colunas existem antes de adicionar
            if (!Schema::hasColumn('orcamentos', 'projeto_id')) {
                $table->foreignId('projeto_id')
                    ->after('id')
                    ->nullable()
                    ->constrained('projetos')
                    ->nullOnDelete();
            }
            
            if (!Schema::hasColumn('orcamentos', 'template_id')) {
                $table->foreignId('template_id')
                    ->after('projeto_id')
                    ->nullable()
                    ->constrained('template_orcamentos')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orcamentos', function (Blueprint $table) {
            // Verificar se as colunas existem antes de remover
            if (Schema::hasColumn('orcamentos', 'projeto_id')) {
                $table->dropForeign(['projeto_id']);
                $table->dropColumn('projeto_id');
            }
            
            if (Schema::hasColumn('orcamentos', 'template_id')) {
                $table->dropForeign(['template_id']);
                $table->dropColumn('template_id');
            }
        });
    }
};