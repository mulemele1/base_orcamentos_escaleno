<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicao_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medicao_id')->constrained('medicoes')->onDelete('cascade');
            $table->foreignId('subatividade_id')->constrained('subatividades');
            
            // Dados da medição
            $table->decimal('comprimento', 10, 2)->nullable();
            $table->decimal('largura', 10, 2)->nullable();
            $table->decimal('altura', 10, 2)->nullable();
            $table->decimal('perda_percentual', 5, 2)->default(0);
            $table->integer('npi')->default(1);
            
            // Quantidade calculada
            $table->decimal('quantidade_calculada', 12, 2)->nullable();
            $table->decimal('quantidade_proposta', 12, 2)->default(0);
            
            // Unidade de medida
            $table->string('unidade', 10);
            
            // Preços e totais
            $table->decimal('preco_unitario', 12, 2)->nullable();
            $table->decimal('subtotal', 12, 2)->nullable();
            
            $table->integer('ordem')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['medicao_id', 'subatividade_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicao_items');
    }
};