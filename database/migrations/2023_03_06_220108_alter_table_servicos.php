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

            $table->dropColumn('valor');
            $table->decimal('preco', 5, 2)->default(0);
            $table->integer('vagas')->default(1);
            $table->string('imagem')->nullable(true);
            
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

            $table->dropColumn('preco');
            $table->dropColumn('vagas');
            $table->dropColumn('imagem');
          });
    }
};
