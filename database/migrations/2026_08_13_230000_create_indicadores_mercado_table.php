<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indicadores_mercado', function (Blueprint $table) {
            $table->id();

            // Identificador estável do indicador (ex: 'ibovespa', 'bitcoin') — não referencia o catálogo
            // de ativos pois índices e moedas não são ativos investíveis da carteira.
            $table->string('chave')->unique();
            $table->string('nome');
            $table->decimal('valor', 20, 8);
            $table->timestamp('atualizado_em');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indicadores_mercado');
    }
};
