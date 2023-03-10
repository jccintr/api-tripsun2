<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\Servico;

class AgendamentoController extends Controller
{

  public function index()

  {
  
    $agendamentos = Agendamento::All();
    if ($agendamentos) {
      return response()->json($agendamentos,200);
    } else {
      return response()->json(['erro'=>'Agendamentos não encontradas'],404);
    }
  
  }



    public function store(Request $request)
    {
    
      $servico_id = intval($request->servico_id);
      $usuario_id = intval($request->usuario_id);
      $quantidade = intval($request->quantidade);
      $data_agendamento = $request->data_agendamento;
      $total = $request->total;
      
      if($servico_id and $usuario_id and $quantidade and $data_agendamento and $total){
      
        // filtra os agendamentos naquela data e horário
        $agendamentos  = Agendamento::where('servico_id',$servico_id)
          ->whereDate('data_agendamento',$data_agendamento)
          ->whereTime('data_agendamento',$data_agendamento)->get();
        // calcular a quantidade de vagas nos agendamentos filtrados
        $vagas = 0;
        foreach($agendamentos as $agendamento){
          $vagas += $agendamento->quantidade;
        }

        $servico = Servico::find($servico_id);

       // se o total de vagas agendadas + vagas novo agendamento > servico->vagas = recusar agendamento
       if(($vagas+$quantidade)>$servico->vagas){
          $array['erro'] = "Vagas insuficientes para esta data e horário.";
          return response()->json($array,400);
       }

        $newAgendamento = new Agendamento();
        $newAgendamento->usuario_id = $usuario_id;
        $newAgendamento->servico_id = $servico_id;
        $newAgendamento->quantidade = $quantidade;
        $newAgendamento->data_agendamento = $data_agendamento;
        $newAgendamento->total = $total;
        $newAgendamento->valor_plataforma = $total * $servico->percentual_plataforma / 100;
        $newAgendamento->save();
    
        return response()->json($newAgendamento,201);
    
      } else {
    
        $array['erro'] = "Valores obrigatórios não informados.";
        return response()->json($array,400);
        
     }
    }
}
