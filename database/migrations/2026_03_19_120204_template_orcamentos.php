<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('template_orcamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->string('tipo_projeto'); // residencial, comercial, industrial, etc.
            $table->json('estrutura')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->boolean('publico')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('template_orcamentos');
    }
};