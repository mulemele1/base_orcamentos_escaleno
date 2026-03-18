<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('itens_orcamento', function (Blueprint $table) {
            $table->id();
            
            // Relacionamento com categoria
            $table->foreignId('categoria_obra_id')
                  ->constrained('categorias_obra')
                  ->onDelete('cascade');
            
            // Relacionamento com material (opcional, pode ser serviço)
            $table->foreignId('material_id')
                  ->nullable()
                  ->constrained('materiais')
                  ->onDelete('set null');
            
            // Identificação do item
            $table->string('item'); // Ex: 1, 2.1, 3.2.1
            $table->string('descricao');
            $table->string('unidade'); // m², m³, un, ml, Vg
            
            // Quantidades e dimensões (como na planilha)
            $table->integer('npi')->nullable(); // Número de peças iguais
            $table->decimal('comprimento', 10, 2)->nullable();
            $table->decimal('largura', 10, 2)->nullable();
            $table->decimal('altura', 10, 2)->nullable();
            $table->decimal('elementar', 10, 2)->nullable(); // C*L*H
            $table->decimal('parcial', 10, 2)->nullable(); // NPI * Elementar
            $table->decimal('perdas', 5, 2)->default(1); // Fator de perdas
            $table->decimal('quantidade_proposta', 10, 2); // Quantidade final
            
            // Custos
            $table->decimal('custo_fornecimento', 10, 2)->nullable();
            $table->decimal('custo_mao_obra', 10, 2)->nullable();
            $table->decimal('preco_unitario', 10, 2);
            $table->decimal('total', 10, 2);
            
            // Observações
            $table->text('comentarios')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Índices para busca
            $table->index('categoria_obra_id');
            $table->index('item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens_orcamento');
    }
};