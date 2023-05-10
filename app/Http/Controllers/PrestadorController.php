<?php

namespace App\Http\Controllers;

use App\Models\Prestador;
use App\Models\Cidade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestadorController extends Controller
{

    public function __construct(Prestador $prestadores){
        $this->prestadores = $prestadores;
      }

//===========================================================
// Lista todas os Prestadores GET
//===========================================================
  public function list()
  {
    //  $prestadores = $this->prestadores->get();
      $prestadores = Prestador::orderBy('nome')->get();
        foreach ($prestadores as $prestador) {
          $cidade = Cidade::find($prestador['cidade_id']);
          $prestador['nome_cidade'] = $cidade['nome'];
        }

      return response()->json($prestadores->values()->all(),200);
  }
//============================================================
// Adiciona uma Prestador POST
//============================================================
  public function add(Request $request)
  {
     $nome = $request->nome;
     $endereco = $request->endereco;
     $bairro = $request->bairro;
     $cep = $request->cep;
     $contato = $request->contato;
     $telefone = $request->telefone;
     $email = $request->email;
     $cnpj = $request->cnpj;
     $ie = $request->ie;
     $imagem = $request->file('logotipo');

     $password = $request->password;

     if(!$imagem or !$nome or !$email or !$password){
        $array['erro'] = "Campos obrigatórios não informados.";
        return response()->json($array,400);
     }
     if (!$password){
        $array['erro'] = "Senha de acesso não informada.";
        return response()->json($array,400);
     }

     $password_hash = password_hash($password, PASSWORD_DEFAULT);

     // 1 - Cadastrar o usuario e pegar o id
     $user = User::select()->where('email', $email)->first();
     if($user) {
         $array['erro'] = "Email já cadastrado. Escolha outro por favor.";
         return response()->json($array,400);
     }
     $newUser = new User();
     $newUser->name = $nome;
     $newUser->email = $email;
     $newUser->password = $password_hash;
     $newUser->telefone = $telefone;
     $newUser->role =  'prestador';
     $token = md5(time().rand(0,9999).time());
     $newUser->token = $token;
     $newUser->save();

     // 2 - cadastrar o prestador

 
    $imagem_url = $imagem->store('imagens/prestadores','public');
   // $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $prestador = $this->prestadores->create([
      'nome' => $nome,
      'usuario_id' => $newUser->id,
      'cidade_id' => $request->cidade_id,
      'logotipo' => $imagem_url,
      'endereco' => $endereco,
      'bairro' => $bairro,
      'cep' => $cep,
      'contato' => $contato,
      'telefone' => $telefone,
      //'email' => $email,
      'cnpj' => $cnpj,
      'ie' => $ie
      //'password' => $password_hash
    ]);
    return response()->json($prestador,201);
    
  }
//================================================================
// Recupera um Prestador por Id GET
//================================================================
  public function getById($id)
  {
    $prestador = Prestador::find($id);

   if ($prestador === null){

      return response()->json(['erro'=>'Prestador não encontrado'],404);
   } else {
      $user = User::find($prestador->usuario_id);
      $prestador['email'] = $user->email;
      return response()->json($prestador,200);
   }
  }
//================================================================
// Atualiza um Prestador POST
//================================================================
  public function update($id,Request $request){

    $imagem = $request->file('imagem');
    $nome = $request->nome;
    if($nome) {
        $prestador = Prestador::find($id);
        $prestador->nome = $nome;
        $prestador->cidade_id = $request->cidade_id;
      //  $prestador->usuario_id = $request->usuario_id;
        $prestador->endereco = $request->endereco;
        $prestador->bairro = $request->bairro;
        $prestador->cep = $request->cep;
        $prestador->contato = $request->contato;
        //$prestador->email = $request->email;
        $prestador->telefone = $request->telefone;
        $prestador->cnpj = $request->cnpj;
        $prestador->ie = $request->ie;

        if($imagem){
          Storage::disk('public')->delete($prestador->imagem);
          $imagem_url = $imagem->store('imagens/prestadores','public');
          $prestador->logotipo = $imagem_url;
        }
        $prestador->save();
        return response()->json($prestador,200);
    } else {
      $array['erro'] = "Campos obrigatórios não informados.";
      return response()->json($array,400);
    }

  }





}
