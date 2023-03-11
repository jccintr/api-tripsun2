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


//===============================================================
// Deleta um registro de horario  de um Serviço DELETE
//================================================================
public function destroy($id){
  $horario = Horario::find($id);
  if ($horario){
    $horario->delete();
    $array['sucesso'] = "Horário excluído com sucesso.";
    return response()->json($array,200);
  }
}

public function index2($idServico){

  $retorno = [];

  //  Pegando os horarios brutos
  $avails = Horario::where('servico_id',$idServico)->orderBy('weekday')->get();
  $availWeekdays = [];
  foreach($avails as $item) {
    $availWeekdays[$item['weekday']] = explode(';', $item['horas']);
  }

  // - Gerar disponibilidade real
   for($q=0;$q<20;$q++) {
       $timeItem = strtotime('+'.$q.' days');
       $weekday = date('w', $timeItem);

       if(in_array($weekday, array_keys($availWeekdays))) {
           $hours = [];

           $dayItem = date('Y-m-d', $timeItem);

           foreach($availWeekdays[$weekday] as $hourItem) {
               $dayFormated = $dayItem.' '.$hourItem.':00';
              // if(!in_array($dayFormated, $appointments)) {
                   $hours[] = $hourItem;
              // }
           }

           if(count($hours) > 0) {
               $availability[] = [
                   'date' => $dayItem,
                   'hours' => $hours
               ];
           }

       }
   }

return response()->json($availability,200);

}


}
