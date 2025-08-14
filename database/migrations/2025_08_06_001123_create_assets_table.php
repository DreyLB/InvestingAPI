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
        Schema::create('assets', function (Blueprint $table) {
            $table->id(); // id PK autoincrement

            // FK para wallets
            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->onDelete('cascade');

            // FK para categories (opcional, pode deixar null)
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->onDelete('set null');

            $table->string('nome'); // Nome do ativo (ex.: PETR4, IVVB11)
            $table->string('tipo')->nullable(); // Tipo (caso não use category_id)
            $table->integer('quantidade'); // Quantidade de ativos
            $table->decimal('preco', 15, 2); // Último preço
            $table->decimal('preco_medio', 15, 2); // Preço médio
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
