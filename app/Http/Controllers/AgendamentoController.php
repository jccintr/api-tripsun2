<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Agendamento;
use App\Models\Servico;
use App\Models\User;
use App\Models\Prestador;


class AgendamentoController extends Controller
{

  public function index()

  {

    $agendamentos = Agendamento::All();
    if ($agendamentos) {
      foreach ($agendamentos as $agendamento) {
        $user = User::find($agendamento->usuario_id);
        $servico = Servico::find($agendamento->servico_id);
        $agendamento['user'] = $user;
        $agendamento['servico'] = $servico;
      }
      return response()->json($agendamentos,200);
    } else {
      return response()->json(['erro'=>'Agendamentos não encontrados.'],404);
    }

  }

  public function index2($usuario_id){


    $agendamentos = Agendamento::where('usuario_id',$usuario_id)->orderBy('data_agendamento')->get();

    if (count($agendamentos)>0){
        foreach ($agendamentos as $agendamento){
          $user = User::find($agendamento->usuario_id);
          $agendamento['user'] = $user;
          $servico = Servico::find($agendamento->servico_id);
          $agendamento['servico'] = $servico;
          $prestador = Prestador::find($servico->prestador_id);
          $agendamento['prestador'] = $prestador;

        }
        return response()->json($agendamentos,200);
    } else {
      return response()->json(['erro'=>'Agendamentos não encontrados para este usuário.'],404);
    }
  }

    public function  checkAvailiblitity(Request $request){

      $servico_id = intval($request->servico_id);
      $usuario_id = intval($request->usuario_id);
      $quantidade = intval($request->quantidade);
      $data_agendamento = $request->data_agendamento;
      $total = $request->total;

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

       $array['sucesso'] = "Vaga disponível para esta data e horário.";
       return response()->json($array,200);
      }

    }

    public function store(Request $request)
    {

      $servico_id = intval($request->servico_id);
      $usuario_id = intval($request->usuario_id);
      $quantidade = intval($request->quantidade);
      $data_agendamento = $request->data_agendamento;
      $numero_cartao = $request->numero_cartao;
      $validade_cartao = $request->validade_cartao;
      $titular_cartao = $request->titular_cartao;
      $cvv_cartao = $request->cvv_cartao;

      $total = $request->total;

      if($servico_id and $usuario_id and $quantidade and $data_agendamento and $total and $numero_cartao and $validade_cartao and $titular_cartao and $cvv_cartao){

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


       // Se chegou até aqui é pq a Data e horario estão disponiveis para agendamento
       // Então pode gerar a cobrança e enviar ao usuario
       // recuperar os dados do clientes
       $cliente = User::find($usuario_id);


       // se customer_id === null fazer o cadastro do usuario e salvar o customer_id no usuario
       if($cliente->customer_id===null){

            $response = Http::withHeaders([
              'Content-Type' => 'application/json',
              'access_token' => env("ASAAS_TOKEN")
            ])->post('https://sandbox.asaas.com/api/v3/customers',[
              'name' => $cliente->name,
              'email'=> $cliente->email,
              'mobilePhone'=> $cliente->telefone,
              'cpfCnpj'=> $cliente->documento,
              'postalCode'=> $cliente->cep,
              'address'=> $cliente->logradouro,
              'addressNumber'=> $cliente->numero,
              'province'=> $cliente->bairro,
              'externalReference'=> $cliente->id
            ]);

            if ($response->status()!==200){
              $array['erro'] = "Falha ao cadastrar dados do cliente.";
              return response()->json($array,400);
            }
            $newCustomer = $response->json();
            $cliente->customer_id = $newCustomer['id'];
            $cliente->save();
       }


       // adiciona a cobranca tipo UNDEFINED
       /*
       $response = Http::withHeaders([
          'Content-Type' => 'application/json',
          'access_token' => env("ASAAS_TOKEN")
          ])->post('https://sandbox.asaas.com/api/v3/payments',[
                'customer' => $cliente->customer_id,
                'billingType'=> 'UNDEFINED',
                'dueDate'=> substr($data_agendamento,0,10),
                'value'=> $total,
                'description'=> 'Agendamento Tripsun Atividade Id: '.$servico_id
        ]);
      */
      // cobranca tipo PIX
      /*
      $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'access_token' => env("ASAAS_TOKEN")
        ])->post('https://sandbox.asaas.com/api/v3/payments',[
              'customer' => $cliente->customer_id,
              'billingType'=> 'PIX',
              'dueDate'=> substr($data_agendamento,0,10),
              'value'=> $total,
              'description'=> 'Agendamento Tripsun Atividade Id: '.$servico_id
      ]);
      */
      // cobranca tipo cartao de credito
      // dados do cartao
      $arrValidade = explode("/",$validade_cartao);
      $creditCardholderName = $titular_cartao; // $cliente->name;
      $creditCardNumber = $numero_cartao; //'5162 3062 1937 8829';  // para dar erro 5184019740373151
      $creditCardExpiryMonth = $arrValidade[0];// '12';
      $creditCardExpiryYear = $arrValidade[1]; // '2025';
      $creditCardCVV = $cvv_cartao; //'318';
      // dados do titular do cartao
      $creditCardholderName = $titular_cartao;
      $creditCardHolderEmail  = $cliente->email;
      $creditCardHolderDocumento  = $cliente->documento;
      $creditCardHolderCep  = $cliente->cep;
      $creditCardHolderAddressNumber  = $cliente->numero;
      $creditCardHolderPhone  = $cliente->telefone;
      $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'access_token' => env("ASAAS_TOKEN")
        ])->post('https://sandbox.asaas.com/api/v3/payments',[
              'customer' => $cliente->customer_id,
              'billingType'=> 'CREDIT_CARD',
              'dueDate'=> substr($data_agendamento,0,10),
              'value'=> $total,
              'description'=> 'Agendamento Tripsun Atividade Id: '.$servico_id,
              'creditCard' => [
                     'holderName' => $creditCardholderName,
                     'number' => $creditCardNumber,
                     'expiryMonth' => $creditCardExpiryMonth,
                     'expiryYear' => $creditCardExpiryYear,
                     'ccv' => $creditCardCVV
              ],
              'creditCardHolderInfo' => [
                'name' => $creditCardholderName,
                'email' => $creditCardHolderEmail,
                'cpfCnpj' => $creditCardHolderDocumento,
                'postalCode' => $creditCardHolderCep,
                'addressNumber' => $creditCardHolderAddressNumber,
                'phone' => $creditCardHolderPhone,
               ],
      ]);

      if ($response->status()!==200){

         $retornoCobranca = $response->json();
      //  dd($retorno['errors'][0]['description']);
        $array['erro'] = $retornoCobranca['errors'][0]['description'];
        //  return response()->json($response->json(),400);
      return response()->json($array,400);
      }


      $cobranca = $response->json();
      // FINAL ADD COBRANÇA


       //************************ */
        $newAgendamento = new Agendamento();
        $newAgendamento->usuario_id = $usuario_id;
        $newAgendamento->servico_id = $servico_id;
        $newAgendamento->quantidade = $quantidade;
        $newAgendamento->data_agendamento = $data_agendamento;
        $newAgendamento->total = $total;
        $newAgendamento->valor_plataforma = $total * $servico->percentual_plataforma / 100;
        $code = md5(time().$usuario_id.$servico_id.$data_agendamento.rand(0,9999));
        $newAgendamento->codigo = $code;
        $newAgendamento->cobranca_id = $cobranca['id'];
        $newAgendamento->cobranca_status = $cobranca['status'];
        $newAgendamento->cobranca_url = $cobranca['invoiceUrl'];
        $newAgendamento->save();

        return response()->json($newAgendamento,201);

      } else {

        $array['erro'] = "Campos obrigatórios não informados.";
        return response()->json($array,400);

     }
    }
}


/*  retorno resposta cob cartao credito
{
 "object": "payment",
 "id": "pay_3718164637772281",
 "dateCreated": "2023-04-10",
 "customer": "cus_000005225860",
 "paymentLink": null,
 "value": 134,
 "netValue": 130.85,
 "originalValue": null,
 "interestValue": null,
 "description": "Agendamento Tripsun Atividade Id: 18",
 "billingType": "CREDIT_CARD",
 "confirmedDate": "2023-04-10",
 "creditCard": {
  "creditCardNumber": "********",
  "creditCardBrand": "MASTERCARD",
  "creditCardToken": "********"
 },
 "pixTransaction": null,
 "status": "CONFIRMED",
 "dueDate": "2023-04-13",
 "originalDueDate": "2023-04-13",
 "paymentDate": null,
 "clientPaymentDate": "2023-04-10",
 "installmentNumber": null,
 "invoiceUrl": "https://sandbox.asaas.com/i/3718164637772281",
 "invoiceNumber": "02101954",
 "externalReference": null,
 "deleted": false,
 "anticipated": false,
 "anticipable": false,
 "creditDate": "2023-05-12",
 "estimatedCreditDate": "2023-05-12",
 "transactionReceiptUrl": "https://sandbox.asaas.com/comprovantes/8823605264264197",
 "nossoNumero": null,
 "bankSlipUrl": null,
 "lastInvoiceViewedDate": null,
 "lastBankSlipViewedDate": null,
 "postalService": false,
 "refunds": null
}



*/
