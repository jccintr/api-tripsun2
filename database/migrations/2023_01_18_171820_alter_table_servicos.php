<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicos', function (Blueprint $table) {

            $table->dropColumn('descricao_curta');
            $table->dropColumn('atrativos');
            $table->dropColumn('itens_fornecidos');
            $table->dropColumn('itens_obrigatorios');


          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servicos', function (Blueprint $table) {

            $table->string('descricao_curta');
            $table->string('atrativos')->nullable();
            $table->string('itens_fornecidos')->nullable();
            $table->string('itens_obrigatorios')->nullable();
        });
    }
};
