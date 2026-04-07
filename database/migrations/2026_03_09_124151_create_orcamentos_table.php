<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained();
            $table->string('numero_orcamento')->unique();
            $table->date('data_emissao');
            $table->date('data_validade');
            $table->decimal('valor_total', 10, 2);
            $table->enum('status', ['rascunho', 'enviado', 'aprovado', 'recusado'])->default('rascunho');
            $table->text('observacoes')->nullable();
            // REMOVA A LINHA ABAIXO SE EXISTIR
            // $table->foreignId('projeto_id')->nullable()->constrained('projetos');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};