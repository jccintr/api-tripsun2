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
        Schema::create('prestadores', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->unsignedBigInteger('cidade_id');
          //  $table->unsignedBigInteger('usuario_id');
            $table->string('logotipo');
            $table->string('endereco')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cep')->nullable();
            $table->string('contato')->nullable();
            $table->string('telefone')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('ie')->nullable();
            $table->timestamps();
            // cria o relacionamento com a tabela cidades
            $table->foreign('cidade_id')->references('id')->on('cidades');
            // cria o relacionamento com a tabela usuarios
          //  $table->foreign('usuario_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prestadores');
    }
};
