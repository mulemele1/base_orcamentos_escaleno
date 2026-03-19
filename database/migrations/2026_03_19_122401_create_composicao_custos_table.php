<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('composicao_custos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subatividade_id')->constrained('subatividades');
            $table->foreignId('material_id')->constrained('materiais');
            $table->decimal('quantidade', 12, 2);
            $table->string('unidade');
            $table->decimal('custo_unitario', 12, 2)->nullable();
            $table->decimal('custo_total', 12, 2)->nullable();
            $table->decimal('mao_obra_percentual', 5, 2)->default(50);
            // 🔥 CORRIGIDO: 'material' em vez de 'materiais'
            $table->enum('tipo', ['material', 'mao_obra', 'equipamento'])->default('material');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('composicao_custos');
    }
};