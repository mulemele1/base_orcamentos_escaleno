<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subatividades', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('nome');
            $table->string('unidade');
            $table->integer('npi')->default(1);
            $table->decimal('comprimento', 10, 2)->nullable();
            $table->decimal('largura', 10, 2)->nullable();
            $table->decimal('altura', 10, 2)->nullable();
            $table->decimal('elementar', 12, 2)->nullable();
            $table->decimal('parcial', 12, 2)->nullable();
            $table->decimal('perda_percentual', 5, 2)->default(0);
            $table->decimal('quantidade_proposta', 12, 2);
            $table->text('descricao')->nullable();
            $table->foreignId('atividade_id')->constrained();
            $table->integer('ordem')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subatividades');
    }
};