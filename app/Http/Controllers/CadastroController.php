<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CadastroController extends Controller
{

public function signUp(Request $request) {


    $name = $request->name;
    $email = filter_var($request->email,FILTER_VALIDATE_EMAIL);
    $password = $request->password;
    $telefone = $request->telefone;


    if($name && $email && $password && $telefone) {
        $user = User::select()->where('email', $email)->first();
        if($user) {
            $array['erro'] = "Email já cadastrado.";
            return response()->json($array,400);
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time().rand(0,9999).time());

        $newUser = new User();
        $newUser->name = $name;
        $newUser->email = $email;
        $newUser->password = $password_hash;
        $newUser->telefone = $telefone;
        $newUser->role =  'cliente';
        $newUser->token = $token;
        $newUser->save();
        if($newUser){
            return response()->json($newUser,201);
        }
     }

}


public function cadastraPrestador(Request $request) {


    $name = $request->name;
    $email = filter_var($request->email,FILTER_VALIDATE_EMAIL);
    $password = $request->password;
    $telefone = $request->telefone;
    $role = 'prestador';



    if($name && $email && $password && $telefone) {
        $user = User::select()->where('email', $email)->first();
        if($user) {
            $array['erro'] = "Email já cadastrado.";
            return response()->json($array,400);
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time().rand(0,9999).time());

        $newUser = new User();
        $newUser->name = $name;
        $newUser->email = $email;
        $newUser->password = $password_hash;
        $newUser->telefone = $telefone;
        $newUser->role =  $role;
        $newUser->token = $token;
        $newUser->save();
        if($newUser){
            return response()->json($newUser,201);
        }
     } else {
         $array['erro'] = $telefone;
        return response()->json($array,404);
     }


}





}
