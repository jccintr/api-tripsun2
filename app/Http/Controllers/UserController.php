<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favorito;
use App\Models\Servico;
use App\Models\Cidade;
use App\Models\Subcategoria;
use App\Models\Imagens;
use App\Models\Prestador;

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
          $servicos_favoritos = [];
          foreach($favoritos as $favorito){
             $servico = Servico::find($favorito->servico_id);
             if ($servico){
                 $cidade = Cidade::find($servico->cidade_id);
                 $servico['imagens'] = Imagens::where('servico_id',$servico['id'])->get();
                 $prestador = Prestador::find($servico->prestador_id);
            $servico['prestador'] = $prestador;
                   $servico['cidade'] = $cidade->nome;
                   $servico['estado'] = $cidade->estado;
                  //$subcategoria = Subcategoria::find($servico->subcategoria_id);
                 // $servico['imagem'] = $subcategoria->imagem;
                array_push($servicos_favoritos,$servico);
              }
          }
         $user['favoritos'] = $servicos_favoritos;

          return response()->json($user,200);
      } else {
        return response()->json(['erro'=>'Usuário não encontrado'],404);
      }

  }
//===========================================================
// Recupera um Usuario pelo Id GET
//===========================================================
public function getById($id){

  $user = User::find($id);

 if ($user === null){
  
    return response()->json(['erro'=>'Usuario não encontrado'],404);
 } else {
   

    $favoritos  = Favorito::where('usuario_id',$user->id)->get();
    $servicos_favoritos = [];
    foreach($favoritos as $favorito){
       $servico = Servico::find($favorito->servico_id);
       if ($servico){
          array_push($servicos_favoritos,$servico);
        }
    }
   $user['favoritos'] = $servicos_favoritos;


    return response()->json($user,200);
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

    public function savePushtoken($id, Request $request) {

      $user = User::find($id);
      $token = $request->push_token;
      if ($user and $token) {
         $user->push_token = $token;
         $user->save();
         $array['sucesso'] = "Push Token salvo com sucesso.";
         return response()->json($array,200);
      } else {
        $array['erro'] = "Campos obrigatórios não informados.";
        return response()->json($array,400);
      }
    }

    //===========================================================
// Atualiza os dados para cobrança do  Usuario POST
//===========================================================
  public function cadastro($id,Request $request){

    $nome = $request->nome;
    $telefone = $request->telefone;
    $documento = $request->documento;
    $logradouro = $request->logradouro;
    $numero = $request->numero;
    $bairro = $request->bairro;
    $cep = $request->cep;
    $cidade = $request->cidade;
    $estado = $request->estado;
    

    if($nome and $telefone and $documento and $logradouro and $numero and $bairro and $cep and $cidade and $estado) {
        $usuario = User::find($id);
        $usuario->name = $nome;
        $usuario->telefone = $telefone;
        $usuario->documento = $documento;
        $usuario->logradouro = $logradouro;
        $usuario->numero = $numero;
        $usuario->bairro = $bairro;
        $usuario->cep = $cep;
        $usuario->cidade = $cidade;
        $usuario->estado = $estado;
        $usuario->save();
        return response()->json($usuario,200);
    } else {
      $array['erro'] = "Campos obrigatórios não informados.";
      return response()->json($array,400);
    }


  }


}
