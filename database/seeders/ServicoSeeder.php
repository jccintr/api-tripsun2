<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      $cidades = [
                     [
                     'id' => 1,
                     'baseLatitude' => "-22.4",
                     'baseLongitude' => "-45.6"
                     ],

                     [
                     'id' => 2,
                     'baseLatitude' => "-23.9",
                     'baseLongitude' => "-46.2"
                     ]
                 ];

       foreach($cidades as $cidade){
      
         // $cidadeId = 1; // Brasópolis
        //  $baseLatitude = '-22.4'; //brasa
        //  $baseLongitude = '-45.6'; //brasa
          $nomeServico = "Aventura ";
          $aventuras = ['Legal','Muito Legal','Imperdível','Emocionante'];
          $descricao_curta = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
          $atrativos =  'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.';
          $itens_fornecidos = "item 1, item 2, item 3...";
          $itens_obrigatorios = "item obrigatório 1, item obrigatório 2";
          $endereco = "Rua x, 345 - Vila Maria";
          $ponto_encontro = "Avenida Y, 321 - Centro";

     for($i=0;$i<15;$i++) {
        $subcategoria=  DB::table('subcategorias')->find(rand(1,7));  
        $categoria =  DB::table('categorias')->find($subcategoria->categoria_id);
        $idServico = DB::table('servicos')->insertGetid([
            'nome' => $nomeServico.$aventuras[rand(0,3)],
            'prestador_id' => rand(1,2),
            'subcategoria_id' => $subcategoria->id,
            'categoria_id' => $categoria->id,
            'cidade_id' => $cidade['id'], //$cidadeId,
            'destaque' => rand(1,4) === 4 ? true : false,
            'endereco' => $endereco,
            'ponto_encontro'=> $ponto_encontro,
            'latitude' => $cidade['baseLatitude'].rand(0,9).'30907', // $baseLatitude.rand(0,9).'30907',
            'longitude' => $cidade['baseLongitude'].rand(0,9).'82795', //$baseLongitude.rand(0,9).'82795',
            'descricao_curta' => $descricao_curta,
            'itens_fornecidos' => $itens_fornecidos,
            'itens_obrigatorios' => $itens_obrigatorios,
            'atrativos' => $atrativos,
            'horario' => rand(9,16).'h',
            'duracao' => rand(1,5).'h',
            'percentual_plataforma' => 2,
            'preco' => rand(20,150).'.00',
            'vagas' => rand(1,10),
            'stars' => rand(3, 4).'.'.rand(0, 9)
        ]);
        // horarios desta atividade
        DB::table('horarios')->insert([
           'servico_id' => $idServico,
           'weekday' => 1,
           'horas' => "09:00;10:00;14:00"
        ]);
        DB::table('horarios')->insert([
            'servico_id' => $idServico,
            'weekday' => 2,
            'horas' => "13:00;14:00;16:00"
         ]);
         DB::table('horarios')->insert([
            'servico_id' => $idServico,
            'weekday' => 3,
            'horas' => "11:00;15:00;18:00"
         ]);
         DB::table('horarios')->insert([
            'servico_id' => $idServico,
            'weekday' => 4,
            'horas' => "07:00;09:00;13:00;14:00"
         ]);
         // imagens desta atividade
         DB::table('imagens')->insert([
            'servico_id' => $idServico,
            'imagem' => "imagens/servicos/mergulho1.jpeg"
         ]);
         DB::table('imagens')->insert([
            'servico_id' => $idServico,
            'imagem' => "imagens/servicos/mergulho2.jpeg"
         ]);
         DB::table('imagens')->insert([
            'servico_id' => $idServico,
            'imagem' => "imagens/servicos/mergulho3.jpeg"
         ]);
      }
/*
      $cidadeId = 2; // Guarujá   -23.98506436031373, -46.25449799601881
      $baseLatitude = '-23.9'; //brasa
      $baseLongitude = '-46.2'; //brasa*/
    }
   }
}
