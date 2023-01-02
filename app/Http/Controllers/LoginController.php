<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function signIn(Request $request){

        $email = filter_var($request->email,FILTER_VALIDATE_EMAIL);
       
        $password = $request->password;
 
 
        if(!$email or !$password) {
            $array['erro'] = "Nome de usuário e ou senha inválidos";
            return response()->json($array,400);
        }
 
        $user = User::select()->where('email', $email)->first();
        if(!$user) {
            $array['erro'] = "Nome de usuário e ou senha inválidos";
            return response()->json($array,400);
        }
        
        if(!password_verify($password, $user->password)) {
            $array['erro'] = "Nome de usuário e ou senha inválidos";
            return response()->json($array,400);
        }
 
        $token =  md5(time().rand(0,9999).time());
        $user->token = $token;
        $user->save();
        
        return response()->json($user,201);
       

    }
}
