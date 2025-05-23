<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('itens_inventario', function (Blueprint $table) {
            $table->decimal('valor_unitario', 10, 2)->nullable()->after('quantidade_contada');
        });
    }

    public function down(): void
    {
        Schema::table('itens_inventario', function (Blueprint $table) {
            $table->dropColumn('valor_unitario');
        });
    }
};
