<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingFieldsToOrcamentosTable extends Migration
{
    public function up()
    {
        // Verificar e adicionar coluna projeto_id
        if (!Schema::hasColumn('orcamentos', 'projeto_id')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->foreignId('projeto_id')->nullable()->after('id')->constrained()->onDelete('set null');
            });
        }

        // Verificar e adicionar coluna versao
        if (!Schema::hasColumn('orcamentos', 'versao')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->integer('versao')->default(1)->after('numero_orcamento');
            });
        }

        // Verificar e adicionar coluna nome_projeto
        if (!Schema::hasColumn('orcamentos', 'nome_projeto')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->string('nome_projeto')->nullable()->after('cliente_id');
            });
        }

        // Verificar e adicionar coluna localizacao
        if (!Schema::hasColumn('orcamentos', 'localizacao')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->string('localizacao')->nullable()->after('nome_projeto');
            });
        }

        // Verificar e adicionar coluna iva_percentual
        if (!Schema::hasColumn('orcamentos', 'iva_percentual')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->decimal('iva_percentual', 5, 2)->default(16)->after('valor_total');
            });
        }

        // Verificar e adicionar coluna contingencia_percentual
        if (!Schema::hasColumn('orcamentos', 'contingencia_percentual')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->decimal('contingencia_percentual', 5, 2)->default(8)->after('iva_percentual');
            });
        }

        // Verificar e adicionar coluna user_id
        if (!Schema::hasColumn('orcamentos', 'user_id')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('template_id')->constrained();
            });
        }

        // Copiar dados existentes para nome_projeto se necessário
        if (Schema::hasColumn('orcamentos', 'cliente_id') && !Schema::hasColumn('orcamentos', 'nome_projeto')) {
            DB::statement('UPDATE orcamentos SET nome_projeto = (SELECT nome FROM clientes WHERE clientes.id = orcamentos.cliente_id)');
        }
    }

    public function down()
    {
        if (Schema::hasColumn('orcamentos', 'projeto_id')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->dropForeign(['projeto_id']);
                $table->dropColumn('projeto_id');
            });
        }

        if (Schema::hasColumn('orcamentos', 'versao')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->dropColumn('versao');
            });
        }

        if (Schema::hasColumn('orcamentos', 'nome_projeto')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->dropColumn('nome_projeto');
            });
        }

        if (Schema::hasColumn('orcamentos', 'localizacao')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->dropColumn('localizacao');
            });
        }

        if (Schema::hasColumn('orcamentos', 'iva_percentual')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->dropColumn('iva_percentual');
            });
        }

        if (Schema::hasColumn('orcamentos', 'contingencia_percentual')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->dropColumn('contingencia_percentual');
            });
        }

        if (Schema::hasColumn('orcamentos', 'user_id')) {
            Schema::table('orcamentos', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }
    }
}