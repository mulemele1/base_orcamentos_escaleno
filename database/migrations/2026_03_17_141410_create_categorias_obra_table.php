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
        Schema::create('categorias_obra', function (Blueprint $table) {
            $table->id();
            
            // Nome da categoria (ex: 01 - EDIFICIO PRINCIPAL)
            $table->string('nome');
            
            // Código da categoria (ex: 01, 02, 03)
            $table->string('codigo')->unique();
            
            // Descrição opcional
            $table->text('descricao')->nullable();
            
            // Ordem de exibição
            $table->integer('ordem')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias_obra');
    }
};