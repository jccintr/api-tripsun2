<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;

class AgendamentoController extends Controller
{
    public function store(Request $request)
    {
    
      $servico_id = intval($request->servico_id);
      $usuario_id = intval($request->usuario_id);
      $quantidade = intval($request->quantidade);
      $data_agendamento = $request->data_agendamento;
      $total = 0;
      $valor_plataforma = 0;
    
      if($servico_id  and $usuario_id and $quantidade){
    
        $newAgendamento = new Agendamento();
        $newAgendamento->usuario_id = $usuario_id;
        $newAgendamento->servico_id = $servico_id;
        $newAgendamento->quantidade = $quantidade;
        $newAgendamento->data_agendamento = $data_agendamento;
        $newAgendamento->total = $total;
        $newAgendamento->valor_plataforma = $valor_plataforma;
        // total calcular
        // valor plataforma calcular
        $newAgendamento->consumido = false;
        // secutiry code calcular
        $newAgendamento->save();
    
        return response()->json($newAgendamento,201);
    
      } else {
    
        $array['erro'] = "Valores obrigatórios não informados.";
        return response()->json($array,400);
        
     }
    }
}
