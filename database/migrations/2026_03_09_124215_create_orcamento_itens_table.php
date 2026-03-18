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
    Schema::create('orcamento_itens', function (Blueprint $table) {
        $table->id();
        $table->foreignId('orcamento_id')->constrained()->onDelete('cascade');
        $table->string('descricao');
        $table->integer('quantidade');
        $table->decimal('valor_unitario', 10, 2);
        $table->decimal('valor_total', 10, 2);
        $table->string('tipo')->nullable(); // material ou serviço
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
        Schema::dropIfExists('orcamento_itens');
    }
};
