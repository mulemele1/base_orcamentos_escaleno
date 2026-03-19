<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('atividades', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('nome');
            $table->string('unidade')->default('Vg');
            $table->integer('npi')->default(1);
            $table->foreignId('categoria_obra_id')->constrained('categorias_obra');
            $table->integer('ordem')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['codigo', 'categoria_obra_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('atividades');
    }
};