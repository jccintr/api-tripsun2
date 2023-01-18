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
          $table->text('descricao_curta')->nullable();
          $table->text('atrativos')->nullable();
          $table->text('itens_fornecidos')->nullable();
          $table->text('itens_obrigatorios')->nullable();
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
        $table->dropColumn('descricao_curta');
        $table->dropColumn('atrativos');
        $table->dropColumn('itens_fornecidos');
        $table->dropColumn('itens_obrigatorios');
        });
    }
};
