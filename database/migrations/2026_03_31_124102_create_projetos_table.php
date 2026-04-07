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
        Schema::create('projetos', function (Blueprint $table) {
            $table->id();
            
            // Dados básicos do projeto
            $table->string('nome');
            $table->string('cliente')->nullable();
            $table->string('localizacao')->nullable();
            $table->text('descricao')->nullable();
            
            // Datas do projeto
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            
            // Status do projeto (rascunho, medição, orçamento, concluído)
            $table->enum('status', ['rascunho', 'medicao', 'orcamento', 'concluido'])->default('rascunho');
            
            // Percentuais para orçamento
            $table->decimal('iva', 5, 2)->default(16.00);           
            $table->decimal('contingencia', 5, 2)->default(8.00); 
            
            // Relacionamentos
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Soft delete (para não perder dados ao excluir)
            $table->softDeletes();
            
            $table->timestamps();
            
            // Índices para melhor performance
            $table->index('status');
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projetos');
    }
};