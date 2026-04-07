<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orcamento_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orcamento_id')
                  ->constrained('orcamentos')
                  ->onDelete('cascade');
            $table->foreignId('medicao_id')
                  ->constrained('medicoes')  // Especifique o nome correto da tabela
                  ->onDelete('cascade');
            $table->foreignId('preco_historico_id')
                  ->constrained('precos_historicos')
                  ->onDelete('cascade');
            $table->decimal('preco_unitario', 12, 2);
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orcamento_itens');
    }
};