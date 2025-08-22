<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->onDelete('cascade');

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->onDelete('cascade');

            $table->foreignId('asset_type_id')
                ->constrained('asset_types')
                ->onDelete('cascade');

            $table->string('name');
            $table->decimal('quantity', 20, 8);
            $table->decimal('price', 20, 8);
            $table->decimal('average_price', 20, 8);

            $table->timestamps();
            $table->softDeletes();

            // índices para performance
            $table->index('wallet_id');
            $table->index('category_id');
            $table->index(['wallet_id', 'category_id']);

            // constraint de negócio: não pode repetir nome de ativo na mesma carteira
            $table->unique(['wallet_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
