<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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



}
