<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dividends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')
                ->constrained('assets')
                ->onDelete('cascade');
            $table->decimal('valor', 20, 8);
            $table->date('data');
            $table->timestamps();
            $table->softDeletes();

            $table->index('asset_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dividends');
    }
};
