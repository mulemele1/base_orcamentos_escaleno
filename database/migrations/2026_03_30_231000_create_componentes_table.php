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
    // database/migrations/2024_xx_xx_xxxxxx_create_componentes_table.php

public function up()
{
    Schema::create('componentes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('grupo_id')->nullable()->constrained()->onDelete('cascade');
        $table->foreignId('actividade_id')->constrained()->onDelete('cascade');
        $table->string('nome');
        $table->string('unidade');
        $table->string('formula_calculo'); // volume, area, area_parede, comprimento, valor_fixo
        $table->decimal('valor_padrao', 12, 2)->nullable(); // para valor_fixo
        $table->decimal('perda_padrao', 5, 2)->default(0);
        $table->integer('ordem')->default(0);
        $table->timestamps();
        
        // Índices
        $table->index(['grupo_id', 'actividade_id']);
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('componentes');
    }
};
