<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cidades')->insert([
            'nome' => "Brasópolis",
            'estado' => "MG",
            'imagem' => "imagens/cidades/brasopolis.jpeg",
        ]);
        DB::table('cidades')->insert([
            'nome' => "Guarujá",
            'estado' => "SP",
            'imagem' => "imagens/cidades/guaruja.jpg",
        ]);
    }
}
