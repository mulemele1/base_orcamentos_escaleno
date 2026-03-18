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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->string('email', 255)->unique()->nullable();
            $table->string('telefone', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('cpf_cnpj', 20)->unique()->nullable();
            $table->enum('tipo_pessoa', ['fisica', 'juridica'])->default('fisica');
            $table->string('rg_ie', 20)->nullable(); // RG para PF, Inscrição Estadual para PJ
            $table->date('data_nascimento')->nullable(); // Para PF
            $table->string('cep', 10)->nullable();
            $table->string('endereco', 255)->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->string('estado', 2)->nullable();
            $table->string('profissao', 100)->nullable();
            $table->string('empresa', 255)->nullable();
            $table->text('observacoes')->nullable();
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->timestamps(); // created_at e updated_at
            $table->softDeletes(); // deleted_at para exclusão lógica
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};