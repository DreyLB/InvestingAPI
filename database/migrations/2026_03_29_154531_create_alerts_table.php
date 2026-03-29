<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->onDelete('cascade');
            $table->enum('tipo', ['preco', 'meta', 'risco', 'dividendo']);
            $table->text('mensagem');
            $table->date('data');
            $table->boolean('lido')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('wallet_id');
            $table->index('lido');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
