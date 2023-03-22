<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorito;
use App\Models\Servico;
use App\Models\Cidade;
use App\Models\Subcategoria;

class FavoritoController extends Controller
{
    public function index($usuario_id){


        $favoritos = Favorito::where('usuario_id',$usuario_id)->get();
    
        if (count($favoritos)>0){
            $servicos_favoritos = [];
            foreach($favoritos as $favorito){
               $servico = Servico::find($favorito->servico_id);
               if ($servico){
                   $cidade = Cidade::find($servico->cidade_id);
                   $servico['cidade'] = $cidade->nome;
                   $servico['estado'] = $cidade->estado;
                    $subcategoria = Subcategoria::find($servico->subcategoria_id);
                   $servico['imagem'] = $subcategoria->imagem;
                   array_push($servicos_favoritos,$servico);
                }
            }
            return response()->json($servicos_favoritos,200);
        } else {
          return response()->json(['erro'=>'Favoritos não encontrados para este usuário.'],404);
        }
      }

    

    public function store(Request $request){

        $usuario_id = $request->usuario_id;
        $servico_id = $request->servico_id;
      
        if ($usuario_id and $servico_id) {
            $favorito  = Favorito::where('servico_id',$servico_id)->where('usuario_id',$usuario_id)->first();
            if ($favorito){
                $favorito->delete();
                return response()->json(['msg'=>'Favorito removido com sucesso.'],200);
            } else {
                $novoFavorito = new Favorito();
                $novoFavorito->usuario_id = $usuario_id;
                $novoFavorito->servico_id = $servico_id;
                $novoFavorito->save();
                return response()->json(['msg'=>'Favorito incluido com sucesso.'],200);
            }
           
        } else {
        return response()->json(['erro'=>'Campos não obrigatórios não informados.'],400);
        }
    }
}

