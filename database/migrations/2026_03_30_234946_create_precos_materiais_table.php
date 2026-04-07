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
    // database/migrations/2024_xx_xx_xxxxxx_create_precos_materiais_table.php

public function up()
{
    Schema::create('precos_materiais', function (Blueprint $table) {
        $table->id();
        $table->string('codigo')->unique();
        $table->string('nome');
        $table->string('unidade');
        $table->foreignId('categoria_id')->constrained('capitulos');
        $table->decimal('valor_atual', 12, 2);
        $table->boolean('ativo')->default(true);
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
        Schema::dropIfExists('precos_materiais');
    }
};
