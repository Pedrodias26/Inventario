<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AlterarEnumStatusItensInventario extends Migration
{
    /**
     * Adiciona o valor 'lancado' ao ENUM da coluna status.
     */
    public function up()
    {
        DB::statement("ALTER TABLE itens_inventario MODIFY status ENUM('pendente', 'contado', 'lancado') NOT NULL DEFAULT 'pendente'");
    }

    /**
     * Reverte para os valores anteriores do ENUM.
     */
    public function down()
    {
        DB::statement("ALTER TABLE itens_inventario MODIFY status ENUM('pendente', 'contado') NOT NULL DEFAULT 'pendente'");
    }
}