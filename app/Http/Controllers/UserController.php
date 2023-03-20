<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favorito;

class UserController extends Controller
{

  //===========================================================
  // Lista todos os Usuarios Prestadores GET
  //===========================================================
  public function ListPrestadores(){

    $users = User::where('role','prestador')->get();
    return response()->json($users,200);

  }
//===========================================================
  // Lista todos os Usuarios Clientes GET
  //===========================================================
  public function ListClientes() {

    $users = User::where('role','cliente')->get();
    return response()->json($users,200);

  }
//===========================================================
// Recupera um Usuario pelo Token GET
//===========================================================
  public function getUser($token) {

      $user = User::where('token',$token)->first();

      if($user){
          $favoritos  = Favorito::where('usuario_id',$user->id)->get();
          $user['favoritos'] = $favoritos;
          return response()->json($user,200);
      } else {
        return response()->json(['erro'=>'Usuário não encontrado'],404);
      }

  }
//===========================================================
// Recupera um Usuario pelo Id GET
//===========================================================
public function getById($id){

  $usuario = User::find($id);

 if ($usuario === null){
  
    return response()->json(['erro'=>'Usuario não encontrado'],404);
 } else {
    $favoritos  = Favorito::where('usuario_id',$usuario->id)->get();
    $usuario['favoritos'] = $favoritos;
    return response()->json($usuario,200);
 }

}
//===========================================================
// Atualiza um Usuario POST
//===========================================================
  public function updateUsuario($id,Request $request){


    $nome = $request->nome;
    $telefone = $request->telefone;

    if($nome  && $telefone) {
        $usuario = User::find($id);
        $usuario->name = $nome;
        $usuario->telefone = $telefone;
        $usuario->save();
        return response()->json($usuario,200);
    } else {
      $array['erro'] = "Campos obrigatórios não informados.";
      return response()->json($array,400);
    }


  }
  //===========================================================
  // Atualiza Senha um Usuario POST
  //===========================================================
    public function trocaSenhaUsuario($id,Request $request){


      $senha = $request->senha;
      $telefone = $request->telefone;

      if($senha) {
          $usuario = User::find($id);
          $password_hash = password_hash($senha, PASSWORD_DEFAULT);
          $usuario->password = $password_hash;
          $usuario->save();
          $array['sucesso'] = "Senha alterado com sucesso.";
          return response()->json($array,200);
      } else {
        $array['erro'] = "Campos obrigatórios não informados.";
        return response()->json($array,400);
      }


    }


}
