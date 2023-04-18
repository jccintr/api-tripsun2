<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrestadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prestadores')->insert([
            'nome' => "Service Provider 1",
            'cidade_id' => 1,
          //  'usuario_id' => 2,
            'logotipo' =>"imagens/prestadores/prestador1.png",
            'endereco' => "Rua x, 50",
            'bairro' => "Centro",
            'cep' => "37530000",
            'contato' => "João",
            'telefone' => "35-3641-1100",
            'email' => "joao@gmail.com",
            'cnpj' => "11.491.322/0001-22",
            'ie' => "123.456.789",
            'password' => password_hash('123', PASSWORD_DEFAULT)
        ]);
        DB::table('prestadores')->insert([
            'nome' => "Service Provider 2",
            'cidade_id' => 1,
          //  'usuario_id' => 2,
            'logotipo' =>"imagens/prestadores/prestador2.png",
            'endereco' => "Rua y, 100",
            'bairro' => "Centro",
            'cep' => "37530000",
            'contato' => "Paulo",
            'telefone' => "35-3641-1200",
            'email' => "paulo@gmail.com",
            'cnpj' => "11.326.322/0001-22",
            'ie' => "123.545.789",
            'password' => password_hash('123', PASSWORD_DEFAULT)
        ]);
        DB::table('prestadores')->insert([
            'nome' => "Service Provider 3",
            'cidade_id' => 2,
            //'usuario_id' => 2,
            'logotipo' =>"imagens/prestadores/prestador3.png",
            'endereco' => "Rua da Praia, 50",
            'bairro' => "Centro",
            'cep' => "12410000",
            'contato' => "carlos",
            'telefone' => "13-3641-1200",
            'email' => "carlos@gmail.com",
            'cnpj' => "11.000.322/0001-22",
            'ie' => "222.545.789",
            'password' => password_hash('123', PASSWORD_DEFAULT)
        ]);
        DB::table('prestadores')->insert([
            'nome' => "Service Provider 4",
            'cidade_id' => 2,
          //  'usuario_id' => 2,
            'logotipo' =>"imagens/prestadores/prestador4.png",
            'endereco' => "Rua da Praia, 85",
            'bairro' => "Centro",
            'cep' => "12410326",
            'contato' => "marco",
            'telefone' => "13-45236-1200",
            'email' => "marco@gmail.com",
            'cnpj' => "11.9865.651/0001-22",
            'ie' => "222.545.321",
            'password' => password_hash('123', PASSWORD_DEFAULT)
        ]);
    }
}
