<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorito;

class FavoritoController extends Controller
{
    public function index($usuario_id){


        $favoritos = Favorito::where('usuario_id',$usuario_id)->get();
    
        if (count($favoritos)>0){
            return response()->json($favoritos,200);
        } else {
          return response()->json(['erro'=>'Favoritos não encontrados para este usuário.'],404);
        }
      }

    public function store(Request $request){

     $usuario_id = $request->usuario_id;
     $servico_id = $request->servico_id;
     
     if ($usuario_id and $servico_id) {
        $novoFavorito = new Favorito();
        $novoFavorito->usuario_id = $usuario_id;
        $novoFavorito->servico_id = $servico_id;
        $novoFavorito->save();
        return response()->json($novoFavorito,201);
     } else {
        return response()->json(['erro'=>'Campos não obrigatórios não informados.'],400);
     }
    

    }

}
/*
public function toggleFavorite(Request $request) {
    $array = ['error'=>''];

    $id_barber = $request->input('barber');

    $barber = Barber::find($id_barber);

    if($barber) {
        $fav = UserFavorite::select()
            ->where('id_user', $this->loggedUser->id)
            ->where('id_barber', $id_barber)
        ->first();

        if($fav) {
            // remover
            $fav->delete();
            $array['have'] = false;
        } else {
            // adicionar
            $newFav = new UserFavorite();
            $newFav->id_user = $this->loggedUser->id;
            $newFav->id_barber = $id_barber;
            $newFav->save();
            $array['have'] = true;
        }
    } else {
        $array['error'] = 'Barbeiro inexistente';
    }

    return $array;
}
*/