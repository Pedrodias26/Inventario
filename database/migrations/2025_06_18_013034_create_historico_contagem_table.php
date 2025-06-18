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
        Schema::create('historico_contagem', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_inventario_id')->constrained('itens_inventario')->onDelete('cascade');
            $table->integer('quantidade_contada');
            $table->integer('quantidade_esperada')->nullable();
            $table->integer('diferenca');
            $table->string('lote')->nullable();
            $table->date('validade')->nullable();
            $table->text('justificativa')->nullable();
            $table->timestamp('registrado_em')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historico_contagem');
    }
};
