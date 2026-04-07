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
    // database/migrations/2024_xx_xx_xxxxxx_create_capitulos_table.php

public function up()
{
    Schema::create('capitulos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('modulo_id')->constrained()->onDelete('cascade');
        $table->string('nome');
        $table->integer('ordem')->default(0);
        $table->text('descricao')->nullable();
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
        Schema::dropIfExists('capitulos');
    }
};
