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
    // database/migrations/2024_xx_xx_xxxxxx_create_medicoes_table.php

public function up()
{
    Schema::create('medicoes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('projeto_id')->constrained()->onDelete('cascade');
        $table->foreignId('componente_id')->constrained()->onDelete('cascade');
        $table->enum('origem', ['desenho', 'campo'])->default('desenho');
        $table->string('prancha')->nullable();
        $table->date('data_medicao')->nullable();
        $table->string('medido_por')->nullable();
        $table->integer('npi')->default(1);
        $table->decimal('comprimento', 10, 2)->nullable();
        $table->decimal('largura', 10, 2)->nullable();
        $table->decimal('altura', 10, 2)->nullable();
        $table->decimal('perda', 5, 2)->default(0);
        $table->decimal('quantidade', 12, 2);
        $table->text('observacoes')->nullable();
        $table->string('foto_path')->nullable();
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
        Schema::dropIfExists('medicoes');
    }
};
