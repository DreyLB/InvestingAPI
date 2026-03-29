<?php
// database/migrations/xxxx_create_transactions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')
                ->constrained('assets')
                ->onDelete('cascade');
            $table->enum('tipo', ['compra', 'venda']);
            $table->decimal('quantidade', 20, 8);
            $table->decimal('valor', 20, 8);
            $table->date('data');
            $table->timestamps();
            $table->softDeletes();

            $table->index('asset_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
