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
    // database/migrations/2024_xx_xx_xxxxxx_create_orcamentos_table.php

public function up()
{
    Schema::create('orcamentos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('projeto_id')->constrained()->onDelete('cascade');
        $table->string('nome');
        $table->date('data_orcamento');
        $table->decimal('subtotal', 12, 2);
        $table->decimal('iva', 12, 2);
        $table->decimal('contingencias', 12, 2);
        $table->decimal('total_geral', 12, 2);
        $table->enum('status', ['rascunho', 'final', 'aprovado'])->default('rascunho');
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
