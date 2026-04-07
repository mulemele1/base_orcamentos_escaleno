<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medicoes', function (Blueprint $table) {
            if (!Schema::hasColumn('medicoes', 'total_medicao')) {
                $table->decimal('total_medicao', 15, 2)->default(0)->after('status');
            }
            if (!Schema::hasColumn('medicoes', 'observacoes')) {
                $table->text('observacoes')->nullable()->after('total_medicao');
            }
        });
    }

    public function down(): void
    {
        Schema::table('medicoes', function (Blueprint $table) {
            $table->dropColumn(['total_medicao', 'observacoes']);
        });
    }
};