<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CobrancaController extends Controller
{
    public function store(Request $request)
    {



      $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'access_token' => env("ASAAS_TOKEN")
       ])->get('https://sandbox.asaas.com/api/v3/finance/balance');


      $json_data = $response->json();
       // $array['status'] = "Chegamos até aqui !";
        return response()->json($json_data,$response->status());

    }
}
