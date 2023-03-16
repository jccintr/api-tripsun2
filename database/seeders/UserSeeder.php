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
        ]);

        DB::table('users')->insert([
            'name' => "Prestador genérico",
            'email' => "prestador@gmail.com",
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'token' => md5(time().rand(0,9999).time()),
            'telefone' => "35-99912-2008",
            'role' => 'prestador'
        ]);

        DB::table('users')->insert([
            'name' => "Joaquim Teixeira",
            'email' => "joaquim@gmail.com",
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'token' => md5(time().rand(0,9999).time()),
            'telefone' => "35-99912-2008",
            'role' => 'cliente'
        ]);

        DB::table('users')->insert([
            'name' => "Elisa Maria Lobo dos Santos",
            'email' => "elisa@gmail.com",
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'token' => md5(time().rand(0,9999).time()),
            'telefone' => "35-99912-2008",
            'role' => 'cliente'
        ]);

        DB::table('users')->insert([
            'name' => "admin",
            'email' => "tripsunoficial@gmail.com",
            'password' => password_hash('123', PASSWORD_DEFAULT),
            'token' => md5(time().rand(0,9999).time()),
            'telefone' => "35-99912-2008",
            'role' => 'admin'
        ]);
    }
}
