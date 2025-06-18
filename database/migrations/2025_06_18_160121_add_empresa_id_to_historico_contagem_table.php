<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmpresaIdToHistoricoContagemTable extends Migration
{
    public function up()
    {
        Schema::table('historico_contagem', function (Blueprint $table) {
            $table->unsignedBigInteger('empresa_id')->nullable()->after('justificativa');
        });
    }

    public function down()
    {
        Schema::table('historico_contagem', function (Blueprint $table) {
            $table->dropColumn('empresa_id');
        });
    }
}
