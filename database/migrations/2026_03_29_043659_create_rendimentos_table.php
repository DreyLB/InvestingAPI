<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->onDelete('cascade');
            $table->enum('rendimento', ['mensal', 'trimestral', 'anual']);
            $table->decimal('valor', 20, 8);
            $table->date('periodo_ini');
            $table->date('periodo_fim');
            $table->timestamps();
            $table->softDeletes();

            $table->index('wallet_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
