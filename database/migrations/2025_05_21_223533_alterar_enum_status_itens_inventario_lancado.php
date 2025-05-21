<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Remove a constraint existente
        DB::statement("ALTER TABLE itens_inventario DROP CONSTRAINT IF EXISTS itens_inventario_status_check");

        // Cria nova constraint com o valor 'lancado'
        DB::statement("ALTER TABLE itens_inventario ADD CONSTRAINT itens_inventario_status_check CHECK (status IN ('pendente', 'contado', 'lançado'))");
    }

    public function down(): void
    {
        // Reverte a constraint para os valores antigos
        DB::statement("ALTER TABLE itens_inventario DROP CONSTRAINT IF EXISTS itens_inventario_status_check");
        DB::statement("ALTER TABLE itens_inventario ADD CONSTRAINT itens_inventario_status_check CHECK (status IN ('pendente', 'contado'))");
    }
};