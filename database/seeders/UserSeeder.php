<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Julio Cesar",
            'email' => "jccintr@gmail.com",
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'token' => md5(time().rand(0,9999).time()),
            'telefone' => "35-99912-2008",
            'role' => 'admin'
        ]);  // id 1

        DB::table('users')->insert([
            'name' => "Tripsun",
            'email' => "tripsunoficial@gmail.com",
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'token' => md5(time().rand(0,9999).time()),
            'telefone' => "13-96563-1313",
            'role' => 'admin'
        ]);  // id 2
       
        DB::table('users')->insert([
            'name' => "Joaquim Teixeira",
            'email' => "joaquim@gmail.com",
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'token' => md5(time().rand(0,9999).time()),
            'telefone' => "12-99912-2008",
            'role' => 'cliente',
            'documento' => '02761110609',
            'cep' => '12010040',
            'logradouro' => 'Praça Campos Sales',
            'numero' => '120',
            'bairro' => 'Centro',
            'cidade' => 'Taubaté',
            'estado' => 'SP',
            'customer_id' => 'cus_000005225860'
        ]); // id 3

        DB::table('users')->insert([
            'name' => "Elisa Santos",
            'email' => "elisa@gmail.com",
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'token' => md5(time().rand(0,9999).time()),
            'telefone' => "35-99912-2008",
            'role' => 'cliente',
            'documento' => '02761110609',
            'cep' => '37530000',
            'logradouro' => 'Rua 24 de Maio',
            'numero' => '46',
            'bairro' => 'Tijuco Preto',
            'cidade' => 'Brazópolis',
            'estado' => 'MG',
            'customer_id' => 'cus_000005223920'
        ]);  // id 4

         // usuarios prestadores
       
        DB::table('users')->insert([
            'name' => "Service Provider 1",
            'email' => "sp1@gmail.com",
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'token' => md5(time().rand(0,9999).time()),
            'telefone' => "11-98765-4321",
            'role' => 'prestador'
        ]);  // id 5

        DB::table('users')->insert([
            'name' => "Service Provider 2",
            'email' => "sp2@gmail.com",
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'token' => md5(time().rand(0,9999).time()),
            'telefone' => "11-98765-4321",
            'role' => 'prestador'
        ]);  // id 6

        DB::table('users')->insert([
            'name' => "Service Provider 3",
            'email' => "sp3@gmail.com",
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'token' => md5(time().rand(0,9999).time()),
            'telefone' => "11-98765-4321",
            'role' => 'prestador'
        ]);  // id 7

        DB::table('users')->insert([
            'name' => "Service Provider 4",
            'email' => "sp4@gmail.com",
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'token' => md5(time().rand(0,9999).time()),
            'telefone' => "11-98765-4321",
            'role' => 'prestador'
        ]);  // id 8

    }
}
