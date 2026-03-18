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
            
            $table->string('chave')->unique(); // iva, contingencia
            $table->string('nome');
            $table->decimal('valor', 5, 2); // 16.00, 8.00
            $table->string('tipo'); // percentual, valor_fixo
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