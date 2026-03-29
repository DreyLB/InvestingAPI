<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->onDelete('cascade');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->decimal('valor', 20, 8);
            $table->date('data_limite')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('wallet_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
