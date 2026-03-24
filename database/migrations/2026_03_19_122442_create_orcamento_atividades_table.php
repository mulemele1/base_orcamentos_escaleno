<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentoAtividadesTable extends Migration
{
    public function up()
    {
        // Verificar se as tabelas existem antes de criar
        if (!Schema::hasTable('orcamentos')) {
            throw new \Exception('Tabela orcamentos não existe');
        }
        
        if (!Schema::hasTable('atividades')) {
            throw new \Exception('Tabela atividades não existe');
        }
        
        if (!Schema::hasTable('categorias_obra')) {
            throw new \Exception('Tabela categorias_obra não existe');
        }

        Schema::create('orcamento_atividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orcamento_id')->constrained('orcamentos')->onDelete('cascade');
            $table->foreignId('atividade_id')->constrained('atividades')->onDelete('cascade');
            $table->foreignId('categoria_obra_id')->constrained('categorias_obra')->onDelete('cascade');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->integer('ordem')->default(0);
            $table->timestamps();
            
            $table->unique(['orcamento_id', 'atividade_id'], 'unique_orcamento_atividade');
            $table->index('orcamento_id');
            $table->index('atividade_id');
            $table->index('categoria_obra_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orcamento_atividades');
    }
}