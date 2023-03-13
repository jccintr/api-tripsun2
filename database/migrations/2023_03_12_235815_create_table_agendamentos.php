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
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('servico_id');
            $table->datetime('data_agendamento');
            $table->integer('quantidade')->default(1);
            $table->decimal('total', 5, 2)->default(0);
            $table->decimal('valor_plataforma', 5, 2)->default(0);
            $table->timestamps();
            // cria o relacionamento com a tabela users
            $table->foreign('usuario_id')->references('id')->on('users');
            // cria o relacionamento com a tabela servicos
            $table->foreign('servico_id')->references('id')->on('servicos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendamentos');
    }
};
