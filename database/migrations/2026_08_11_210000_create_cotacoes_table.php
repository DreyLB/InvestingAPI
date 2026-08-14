<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotacoes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('asset_id')
                ->constrained('assets')
                ->onDelete('cascade');

            $table->decimal('valor', 20, 8);
            $table->timestamp('atualizado_em');

            $table->timestamps();
            $table->softDeletes();

            // Cada ativo possui uma única cotação vigente (evita duplicidade em atualizações periódicas)
            $table->unique('asset_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotacoes');
    }
};
