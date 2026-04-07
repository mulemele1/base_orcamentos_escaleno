<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('precos_historicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('preco_material_id')
                  ->constrained('precos_materiais') // Especifique o nome correto da tabela
                  ->onDelete('cascade');
            $table->decimal('valor', 12, 2);
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('precos_historicos');
    }
};