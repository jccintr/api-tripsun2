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
        Schema::table('horarios', function (Blueprint $table) {

            $table->dropColumn('data');
            $table->dropColumn('hora');
            $table->dropColumn('duracao');
            $table->dropColumn('quant');
            $table->dropColumn('ativo');

          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('horarios', function (Blueprint $table) {

            $table->date('data');
            $table->time('hora');
            $table->time('duracao');
            $table->integer('quant')->default(0);
            $table->boolean('ativo')->default(true);

        });
    }
};
