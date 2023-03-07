<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;

class HorariosController extends Controller
{

//================================================================
// Adiciona um Horario POST
//================================================================

public function add(Request $request)
{

  $servico_id = intval($request->servico_id);
  $weekDay = intval($request->weekDay);
  $horas = $request->horas;

  if($servico_id  and $horas ){

    $novoHorario = new Horario();
    $novoHorario->servico_id = $servico_id;
    $novoHorario->weekday = $weekDay;
    $novoHorario->horas = $horas;
    $novoHorario->save();

    return response()->json($novoHorario,201);

  } else {

    $array['erro'] = "Valores obrigatórios não informados.";
    return response()->json($array,400);
  $array['erro'] = "Valores obrigatórios não informados.";
 }


  }

//===============================================================
// Recupera os horarios de um Serviço GET
//================================================================

public function index($idServico)

{

  $horarios = Horario::where('servico_id',$idServico)->orderBy('weekday')->get();
  if ($horarios) {
    return response()->json($horarios,200);
  } else {
    return response()->json(['erro'=>'Horarios não encontradas'],404);
  }

}

public function destroy($id){
  $horario = Horario::find($id);
  if ($horario){
    $horario->delete();
    $array['sucesso'] = "Horário excluído com sucesso.";
    return response()->json($array,200);
  }
}


}
