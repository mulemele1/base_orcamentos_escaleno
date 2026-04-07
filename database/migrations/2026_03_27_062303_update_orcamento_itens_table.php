<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/2024_xx_xx_xxxxxx_create_orcamento_itens_table.php

public function up()
{
    Schema::create('orcamento_itens', function (Blueprint $table) {
        $table->id();
        $table->foreignId('orcamento_id')->constrained()->onDelete('cascade');
        $table->foreignId('medicao_id')->constrained()->onDelete('cascade');
        $table->foreignId('preco_historico_id')->constrained()->onDelete('cascade');
        $table->decimal('preco_unitario', 12, 2);
        $table->decimal('total', 12, 2);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::table('orcamento_itens', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropForeign(['subatividade_id']);
            $table->dropColumn('subatividade_id');
        });
    }
};