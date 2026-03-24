<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentosTable extends Migration
{
    public function up()
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            
            // Identificação
            $table->string('codigo')->unique()->comment('Código único do orçamento ex: ORC-2024-0001');
            $table->integer('versao')->default(1)->comment('Versão do orçamento');
            
            // Relacionamentos
            $table->foreignId('projeto_id')->nullable()->constrained('projetos')->onDelete('set null')->comment('Projeto associado');
            $table->foreignId('template_id')->nullable()->constrained('template_orcamentos')->onDelete('set null')->comment('Template usado');
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('set null')->comment('Cliente');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('Usuário criador');
            
            // Informações do projeto
            $table->string('nome_projeto')->comment('Nome do projeto/orçamento');
            $table->string('localizacao')->nullable()->comment('Localização da obra');
            
            // Datas
            $table->date('data_emissao')->comment('Data de emissão');
            $table->date('data_validade')->nullable()->comment('Data de validade');
            
            // Valores e impostos
            $table->decimal('subtotal', 15, 2)->default(0)->comment('Subtotal sem impostos');
            $table->decimal('iva_percentual', 5, 2)->default(16)->comment('Percentual de IVA');
            $table->decimal('valor_iva', 15, 2)->default(0)->comment('Valor do IVA calculado');
            $table->decimal('contingencia_percentual', 5, 2)->default(8)->comment('Percentual de contingência');
            $table->decimal('valor_contingencia', 15, 2)->default(0)->comment('Valor da contingência calculado');
            $table->decimal('grand_total', 15, 2)->default(0)->comment('Valor final (subtotal + IVA + contingência)');
            
            // Status e observações
            $table->enum('status', ['rascunho', 'em_analise', 'aprovado', 'rejeitado'])->default('rascunho')->comment('Status do orçamento');
            $table->text('observacoes')->nullable()->comment('Observações gerais');
            
            // Controle
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para performance
            $table->index('codigo');
            $table->index('status');
            $table->index('data_emissao');
            $table->index('projeto_id');
            $table->index('cliente_id');
            $table->index('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orcamentos');
    }
}