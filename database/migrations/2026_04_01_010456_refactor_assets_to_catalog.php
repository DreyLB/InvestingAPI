<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // Remove colunas de posição do usuário
            $table->dropForeign(['wallet_id']);
            $table->dropIndex(['wallet_id']);
            $table->dropIndex(['wallet_id', 'category_id']);
            $table->dropUnique(['wallet_id', 'name']);
            $table->dropColumn(['wallet_id', 'quantity', 'price', 'average_price']);

            // Adiciona ticker como identificador único global
            $table->string('ticker', 20)->unique()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropUnique(['ticker']);
            $table->dropColumn('ticker');

            $table->foreignId('wallet_id')->constrained('wallets')->onDelete('cascade');
            $table->decimal('quantity', 20, 8)->default(0);
            $table->decimal('price', 20, 8)->default(0);
            $table->decimal('average_price', 20, 8)->default(0);
        });
    }
};
