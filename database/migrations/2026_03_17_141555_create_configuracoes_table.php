<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('configuracoes', function (Blueprint $table) {
            $table->id();
            
            $table->string('chave')->unique(); // iva, contingencia, sistema_nome, etc.
            $table->string('nome'); // Nome exibido no formulário
            $table->string('grupo')->default('Geral'); // Grupo para agrupamento na interface (NOVO CAMPO)
            $table->string('valor')->nullable(); // Alterado para string para aceitar textos, números, booleanos
            $table->string('tipo')->default('text'); // text, number, textarea, boolean, percentual, valor_fixo
            $table->text('descricao')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracoes');
    }
};