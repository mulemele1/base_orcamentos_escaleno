<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Adicionar campos à tabela materiais (se não existirem)
        Schema::table('materiais', function (Blueprint $table) {
            if (!Schema::hasColumn('materiais', 'codigo')) {
                $table->string('codigo')->unique()->after('id');
            }
            if (!Schema::hasColumn('materiais', 'categoria')) {
                $table->string('categoria')->after('nome');
            }
            if (!Schema::hasColumn('materiais', 'subcategoria')) {
                $table->string('subcategoria')->nullable()->after('categoria');
            }
            if (!Schema::hasColumn('materiais', 'unidade')) {
                $table->string('unidade')->after('subcategoria');
            }
            if (!Schema::hasColumn('materiais', 'especificacao')) {
                $table->text('especificacao')->nullable()->after('unidade');
            }
        });

        // Adicionar campos à tabela fornecedores (se não existirem)
        Schema::table('fornecedores', function (Blueprint $table) {
            if (!Schema::hasColumn('fornecedores', 'localizacao')) {
                $table->string('localizacao')->nullable()->after('nome');
            }
            if (!Schema::hasColumn('fornecedores', 'contacto')) {
                $table->string('contacto')->nullable()->after('localizacao');
            }
            if (!Schema::hasColumn('fornecedores', 'tipo')) {
                $table->string('tipo')->default('geral')->after('contacto');
            }
            if (!Schema::hasColumn('fornecedores', 'email')) {
                $table->string('email')->nullable()->after('tipo');
            }
            if (!Schema::hasColumn('fornecedores', 'website')) {
                $table->string('website')->nullable()->after('email');
            }
        });

        // Adicionar campos à tabela precos_materiais (se não existirem)
        Schema::table('precos_materiais', function (Blueprint $table) {
            if (!Schema::hasColumn('precos_materiais', 'unidade_compra')) {
                $table->string('unidade_compra')->after('preco');
            }
            if (!Schema::hasColumn('precos_materiais', 'quantidade_compra')) {
                $table->decimal('quantidade_compra', 10, 2)->default(1)->after('unidade_compra');
            }
            if (!Schema::hasColumn('precos_materiais', 'referencia')) {
                $table->string('referencia')->nullable()->after('data_cotacao');
            }
            if (!Schema::hasColumn('precos_materiais', 'estado')) {
                $table->string('estado')->default('ativo')->after('referencia');
            }
            if (!Schema::hasColumn('precos_materiais', 'observacoes')) {
                $table->text('observacoes')->nullable()->after('estado');
            }
        });
    }

    public function down()
    {
        // Reverter as alterações (opcional)
        Schema::table('materiais', function (Blueprint $table) {
            $table->dropColumn(['codigo', 'categoria', 'subcategoria', 'unidade', 'especificacao']);
        });

        Schema::table('fornecedores', function (Blueprint $table) {
            $table->dropColumn(['localizacao', 'contacto', 'tipo', 'email', 'website']);
        });

        Schema::table('precos_materiais', function (Blueprint $table) {
            $table->dropColumn(['unidade_compra', 'quantidade_compra', 'referencia', 'estado', 'observacoes']);
        });
    }
};