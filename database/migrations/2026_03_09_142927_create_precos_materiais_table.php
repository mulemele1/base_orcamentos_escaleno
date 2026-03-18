<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('precos_materiais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_id')->constrained()->onDelete('cascade');
            $table->foreignId('fornecedor_id')->constrained()->onDelete('cascade');
            $table->decimal('preco', 12, 2);
            $table->string('unidade_compra'); // saco, m³, kg, etc
            $table->decimal('quantidade_compra', 10, 2)->default(1);
            $table->date('data_cotacao');
            $table->string('referencia')->nullable(); // nº factura/proposta
            $table->string('estado')->default('ativo'); // ativo, historico
            $table->text('observacoes')->nullable();
            $table->timestamps();
            
            // Índice para buscas rápidas
            $table->index(['material_id', 'fornecedor_id', 'data_cotacao']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('precos_materiais');
    }
};