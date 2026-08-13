<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('indicadores_mercado', function (Blueprint $table) {
            $table->decimal('variacao_percentual', 10, 4)->nullable()->after('valor');
        });
    }

    public function down(): void
    {
        Schema::table('indicadores_mercado', function (Blueprint $table) {
            $table->dropColumn('variacao_percentual');
        });
    }
};
