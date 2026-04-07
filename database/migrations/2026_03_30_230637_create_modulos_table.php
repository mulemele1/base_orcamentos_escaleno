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
    // database/migrations/2024_xx_xx_xxxxxx_create_modulos_table.php

public function up()
{
    Schema::create('modulos', function (Blueprint $table) {
        $table->id();
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
        Schema::dropIfExists('modulos');
    }
};
