<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orcamentos');
    }
};
