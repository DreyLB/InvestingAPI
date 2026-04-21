<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->onDelete('cascade');

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->onDelete('cascade');

            $table->decimal('quantidade', 20, 8)->default(0);
            $table->decimal('preco_medio', 20, 8)->default(0);
            $table->decimal('valor_total', 20, 8)->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Um ativo aparece uma vez por carteira
            $table->unique(['wallet_id', 'asset_id']);
            $table->index(['wallet_id']);
            $table->index(['asset_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
