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
        Schema::create('materiais', function (Blueprint $table) {
            $table->id();
            
            // Campo para o código do material (ex: 1.1, 1.2, 2.1)
            $table->string('codigo')->unique();
            
            // Nome descritivo do material
            $table->string('nome');
            
            // Unidade de medida (kg, m³, un, ml, m², Vg, etc.)
            $table->string('unidade');
            
            // Valor de compra do material
            $table->decimal('valor_compra', 10, 2);
            
            // Rendimento do material (ex: 50, 5.8, etc.)
            $table->decimal('rendimento', 10, 2);
            
            // Categoria (ex: Geral, Betões, Hidráulica, Aços, Madeiras, etc.)
            $table->string('categoria');
            
            // Descrição adicional (opcional)
            $table->text('descricao')->nullable();
            
            // Campo para observações específicas
            $table->text('observacoes')->nullable();
            
            // Campos de controle
            $table->timestamps(); // created_at e updated_at
            $table->softDeletes(); // Permite "excluir" sem apagar do banco (deleted_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiais');
    }
};