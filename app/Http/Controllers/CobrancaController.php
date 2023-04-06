<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Agendamento;

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

    public function status(Request $request){

      $status = $request->event;
      $cobranca_id = $request->payment['id'];
     
      $agendamento = Agendamento::where('cobranca_id',$cobranca_id)->first();
      $agendamento->cobranca_status = $status;
      $agendamento->save();
      return response()->json($agendamento,200);
      
      //return response()->json($cobranca_id,200);
    }

}
