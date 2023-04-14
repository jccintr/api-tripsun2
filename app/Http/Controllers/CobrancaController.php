<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Agendamento;
use App\Models\User;

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
      if ($agendamento){
        $agendamento->cobranca_status = $status;
        $agendamento->save();

        if($status=='RECEIVED' or $status == 'CONFIRMED' or $status='PAYMENT_CONFIRMED') {

          $user = User::find($agendamento->usuario_id);
          $response = Http::withHeaders([
             'Content-Type' => 'application/json'
             ])->post('https://exp.host/--/api/v2/push/send',[
                   'to' => $user->push_token,
                   'sound'=> 'default',
                   'title'=> 'TripSun',
                   'body'=> 'Recebemos o seu pagamento ! Obrigado.'
             ]);
       }

        return response()->json($agendamento,200);
      } else {
        $array['status'] = "Agendamento não encontrado.";
        return response()->json($agendamento,200);
      }


    }

}
