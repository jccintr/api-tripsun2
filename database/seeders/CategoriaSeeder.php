<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $idCategoria = DB::table('categorias')->insertGetid([
            'nome' => "Locações",
            'imagem' => "imagens/categorias/locacoes.png",
        ]);
                DB::table('subcategorias')->insert([
                    'nome' => "Pranchas",
                    'imagem' => "imagens/subcategorias/pranchas.png",
                    'marcador' => "imagens/marcadores/prancha.png",
                    'categoria_id' => $idCategoria
                ]);

        $idCategoria = DB::table('categorias')->insertGetid([
            'nome' => "Passeios",
            'imagem' => "imagens/categorias/passeios.png",
        ]);
                DB::table('subcategorias')->insert([
                    'nome' => "Lancha",
                    'imagem' => "imagens/subcategorias/lanchas.png",
                    'marcador' => "imagens/marcadores/lancha.png",
                    'categoria_id' => $idCategoria
                ]);
                DB::table('subcategorias')->insert([
                    'nome' => "Banana Boat",
                    'imagem' => "imagens/subcategorias/banana_boat.png",
                    'marcador' => "imagens/marcadores/banana_boat.png",
                    'categoria_id' => $idCategoria
                ]);

        DB::table('categorias')->insert([
            'nome' => "Culturais",
            'imagem' => "imagens/categorias/cultural.png",
        ]);

        DB::table('categorias')->insert([
            'nome' => "Eventos",
            'imagem' => "imagens/categorias/eventos.png",
        ]);

        $idCategoria = DB::table('categorias')->insertGetid([
            'nome' => "Academias",
            'imagem' => "imagens/categorias/academias.png",
        ]);
                DB::table('subcategorias')->insert([
                    'nome' => "Musculação",
                    'imagem' => "imagens/subcategorias/musculacao.png",
                    'marcador' => "imagens/marcadores/musculacao.png",
                    'categoria_id' => $idCategoria
                ]);


        $idCategoria = DB::table('categorias')->insertGetid([
            'nome' => "Radicais",
            'imagem' => "imagens/categorias/radicais.png",
        ]);
                DB::table('subcategorias')->insert([
                    'nome' => "Rapel",
                    'imagem' => "imagens/subcategorias/rapel.png",
                    'marcador' => "imagens/marcadores/rapel.png",
                    'categoria_id' => $idCategoria
                ]);
                DB::table('subcategorias')->insert([
                    'nome' => "Tirolesa",
                    'imagem' => "imagens/subcategorias/radicais.png",
                    'marcador' => "imagens/marcadores/tirolesa.png",
                    'categoria_id' => $idCategoria
                ]);


        $idCategoria = DB::table('categorias')->insertGetid([
            'nome' => "Voos",
            'imagem' => "imagens/categorias/voos.png",
        ]);
                DB::table('subcategorias')->insert([
                    'nome' => "Paraglider",
                    'imagem' => "imagens/subcategorias/voos.png",
                    'marcador' => "imagens/marcadores/paraglider.png",
                    'categoria_id' => $idCategoria
                ]);

        DB::table('categorias')->insert([
            'nome' => "Esportes",
            'imagem' => "imagens/categorias/futvolei.png",
        ]);
    }
}
