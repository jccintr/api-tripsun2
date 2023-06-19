<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Favorito;
use App\Models\Servico;
use App\Models\Cidade;
use App\Models\Subcategoria;
use App\Models\Imagens;
use App\Models\Prestador;

class LoginController extends Controller
{

//============================================================
// Loga usuario do tipo admin
//============================================================
public function signInAdmin (Request $request) {
    $email = filter_var($request->email,FILTER_VALIDATE_EMAIL);
    $password = $request->password;

    if(!$email or !$password) {
        $array['erro'] = "Nome de usuário e ou senha inválidos";
        return response()->json($array,403);
    }

    $credentials = ['email'=> $email,'password'=>$password];
    if (!Auth::attempt($credentials)) {
        return response()->json(['erro'=>'Email e ou senha inválidos'],401);
    }
    $loggedUser = Auth::User();
 
    if($loggedUser->role!=='admin'){
        $array['erro'] = "Nome de usuário e ou senha inválidos";
        return response()->json($array,403);
    }
    
    $token = Auth::User()->createToken('tripsun');
    $loggedUser['token'] = $token->plainTextToken;

    return response()->json($loggedUser,200);

}

//============================================================
// Loga usuario do tipo cliente
//============================================================
public function signIn(Request $request){

    $email = filter_var($request->email,FILTER_VALIDATE_EMAIL);
    $password = $request->password;

    if(!$email or !$password) {
        $array['erro'] = "Nome de usuário e ou senha inválidos";
        return response()->json($array,400);
    }

    $credentials = ['email'=> $email,'password'=>$password];
    if (!Auth::attempt($credentials)) {
        return response()->json(['erro'=>'Email e ou senha inválidos'],401);
    }

    $loggedUser = Auth::User();
    $token = Auth::User()->createToken('tripsun');
    $loggedUser['token'] = $token->plainTextToken;
    
    $favoritos  = Favorito::where('usuario_id',$loggedUser->id)->get();
    $servicos_favoritos = [];
    foreach($favoritos as $favorito){
        $servico = Servico::find($favorito->servico_id);
        if ($servico){
            $servico['imagens'] = Imagens::where('servico_id',$servico['id'])->get();
            $prestador = Prestador::find($servico->prestador_id);
            $servico['prestador'] = $prestador;
            $cidade = Cidade::find($servico->cidade_id);
            $servico['cidade'] = $cidade->nome;
            $servico['estado'] = $cidade->estado;
            array_push($servicos_favoritos,$servico);
        }
    }
    $loggedUser['favoritos'] = $servicos_favoritos;

    return response()->json($loggedUser,200);
}

}
