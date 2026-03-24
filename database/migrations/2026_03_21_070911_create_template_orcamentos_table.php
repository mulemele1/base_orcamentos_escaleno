<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_template_orcamentos_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateOrcamentosTable extends Migration
{
    public function up()
    {
        Schema::create('template_orcamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->comment('Nome do template');
            $table->string('tipo_projeto')->nullable()->comment('Tipo de projeto: residencial, comercial, industrial, etc');
            $table->text('descricao')->nullable();
            $table->json('configuracoes')->nullable()->comment('Configurações padrão: IVA, contingência, etc');
            $table->json('estrutura')->nullable()->comment('Estrutura do orçamento: categorias e atividades');
            $table->boolean('publico')->default(false)->comment('Template público ou privado');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('template_orcamentos');
    }
}