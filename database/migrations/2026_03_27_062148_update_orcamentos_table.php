<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orcamentos', function (Blueprint $table) {
            // Adicionar campos se não existirem
            if (!Schema::hasColumn('orcamentos', 'projeto_id')) {
                $table->foreignId('projeto_id')->nullable()->after('id')->constrained('projetos');
            }
            if (!Schema::hasColumn('orcamentos', 'medicao_id')) {
                $table->foreignId('medicao_id')->nullable()->after('projeto_id')->constrained('medicoes');
            }
            if (!Schema::hasColumn('orcamentos', 'template_id')) {
                $table->foreignId('template_id')->nullable()->after('medicao_id')->constrained('template_orcamentos');
            }
            if (!Schema::hasColumn('orcamentos', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('template_id')->constrained('users');
            }
            if (!Schema::hasColumn('orcamentos', 'codigo')) {
                $table->string('codigo')->nullable()->after('id');
            }
            if (!Schema::hasColumn('orcamentos', 'versao')) {
                $table->integer('versao')->default(1)->after('codigo');
            }
            if (!Schema::hasColumn('orcamentos', 'nome_projeto')) {
                $table->string('nome_projeto')->nullable()->after('versao');
            }
            if (!Schema::hasColumn('orcamentos', 'subtotal')) {
                $table->decimal('subtotal', 15, 2)->default(0)->after('valor_total');
            }
            if (!Schema::hasColumn('orcamentos', 'iva_percentual')) {
                $table->decimal('iva_percentual', 5, 2)->default(16)->after('subtotal');
            }
            if (!Schema::hasColumn('orcamentos', 'valor_iva')) {
                $table->decimal('valor_iva', 15, 2)->default(0)->after('iva_percentual');
            }
            if (!Schema::hasColumn('orcamentos', 'contingencia_percentual')) {
                $table->decimal('contingencia_percentual', 5, 2)->default(8)->after('valor_iva');
            }
            if (!Schema::hasColumn('orcamentos', 'valor_contingencia')) {
                $table->decimal('valor_contingencia', 15, 2)->default(0)->after('contingencia_percentual');
            }
            if (!Schema::hasColumn('orcamentos', 'grand_total')) {
                $table->decimal('grand_total', 15, 2)->default(0)->after('valor_contingencia');
            }
            if (!Schema::hasColumn('orcamentos', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orcamentos', function (Blueprint $table) {
            $table->dropForeign(['projeto_id']);
            $table->dropForeign(['medicao_id']);
            $table->dropForeign(['template_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'projeto_id', 'medicao_id', 'template_id', 'user_id',
                'codigo', 'versao', 'nome_projeto', 'subtotal',
                'iva_percentual', 'valor_iva', 'contingencia_percentual',
                'valor_contingencia', 'grand_total', 'deleted_at'
            ]);
        });
    }
};