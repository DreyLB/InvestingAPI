<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Adiciona wallet_id direto na transação
            $table->foreignId('wallet_id')
                ->after('id')
                ->constrained('wallets')
                ->onDelete('cascade');

            // Renomeia valor para preco_unitario (semântica correta)
            $table->decimal('preco_unitario', 20, 8)->after('quantidade');
            $table->dropColumn('valor');

            $table->index('wallet_id');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['wallet_id']);
            $table->dropColumn(['wallet_id', 'preco_unitario']);
            $table->decimal('valor', 20, 8);
        });
    }
};
