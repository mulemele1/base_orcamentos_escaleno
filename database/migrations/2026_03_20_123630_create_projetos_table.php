<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetosTable extends Migration
{
    public function up()
    {
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cliente');
            $table->string('localizacao');
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->enum('status', ['planeamento', 'em_andamento', 'concluido', 'suspenso'])->default('planeamento');
            $table->foreignId('template_id')->nullable()->constrained('template_orcamentos')->onDelete('set null');
            $table->json('configuracoes')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para melhor performance
            $table->index('status');
            $table->index('cliente');
        });
    }

    public function down()
    {
        Schema::dropIfExists('projetos');
    }
}