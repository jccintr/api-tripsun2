<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index($idServico)

    {
    
      $reviews = Review::where('servico_id',$idServico)->orderBy('data','desc')->get();
      if ($reviews) {
        return response()->json($reviews,200);
      } else {
        return response()->json(['erro'=>'Horarios não encontradas'],404);
      }
    
    }

    public function store(Request $request)
{
  $usuario_id = intval($request->usuario_id);
  $servico_id = intval($request->servico_id);
  $rate = $request->rate;
  $message = $request->message;

  if($servico_id  and $usuario_id and $rate and $message){

    $newReview = new Review();
    $newReview->usuario_id = $usuario_id;
    $newReview->servico_id = $servico_id;
    $newReview->rate = $rate;
    $newReview->message = $message;
    $newReview->data = date('Y-m-d');
    $newReview->save();

    return response()->json($newReview,201);

  } else {

    $array['erro'] = "Valores obrigatórios não informados.";
    return response()->json($array,400);
  
 }


  }

  public function destroy($id){
    $review = Review::find($id);
    if ($review){
      $review->delete();
      $array['sucesso'] = "Review excluído com sucesso.";
      return response()->json($array,200);
    }
  }


}
