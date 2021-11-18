<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use phpseclib\Crypt\RSA;
use Session;
use Carbon\Carbon;

class PaymentController extends Controller
{
	public $id;

	/*
    |--------------------------------------------------------------------------
    | CheckoutForm Function
    |--------------------------------------------------------------------------
    */
    public function  CheckoutForm (Request $request)
    {
		//tariff data
        $incoming = $request->all();
        //dd($incoming);
        return view('layouts.pages.payment', compact('incoming'));
    } 

	
	/*
    |--------------------------------------------------------------------------
    | CreatePayment Function
    |--------------------------------------------------------------------------
    */
	public function CreatePayment(Request $request) {

		$incoming = $request->all();
		//dd($incoming);

		$publicKey = <<<EOT
        -----BEGIN PUBLIC KEY-----
        MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwxrT23HlSVH0e6rcRc0r
        r/ENULUHnQVYREkjvvqEp3M+av9MAjgtUio0yO4voZXNzLUIJR9ONcdBXS3JJI/R
        ODvCkW17Py24RTHPeqXy9oCyLDMMemK6sTFOfPFSRWvro0rXkMv8apxGFqEU13VC
        qjhUmJWnRKtQgKlvhoAR5pR7W+OGuVIoQpJW75ccF7eNLvxYL/GDON7WeELwK1XE
        55S9BQFPDpIAD0tzH4Od971Uz0WYkIjinKZU8G6SmW+ptZtdU8DoS1BvbWRclMUY
        Wm6BS2W0dpsNMQfO/HE5OAqCtZK9NLQJnXeG2U31giezdauNBP48QAKpjT9HRhih
        8wIDAQAB
        -----END PUBLIC KEY-----
        EOT;

		$key = new RSA();
        $key->loadKey($publicKey);

		list($month, $year) = explode('/', $incoming['expiration']);

		$payload = array(
   		 'Card' => $incoming['creditcard'],
                 'InfoS' => $incoming['cvcode'],
			      'InfoV' => $year . $month,
                 'Amount' => str_pad( str_replace('.', '', $incoming['amount']), 12, '0', STR_PAD_LEFT)
        );

		$encrypted = $key->encrypt(json_encode($payload));
		$encrypted = base64_encode($encrypted);

      /*$response_agricola = Http::withOptions([
            //'debug' => true,
            'verify' => false
        ])->post('https://www.serfinsacheckout.com/PaymentRest/Payment', [
            "KeyInfo" => "d909ba52-bb82-40db-a2b4-f9fdacc6e6dc",
            "PaymentData" => $encrypted
        ]);*/

		//if ($response_agricola->json('Satisfactorio')) {

            /*$authorizationId = $response_agricola->json('Datos')['Autorizacion'];
			$referenceId = $response_agricola->json('Datos')['Referencia'];*/

			if($incoming['customerStatus'] == 0) {
				//dd("usuario nuevo");
				$this->CreateCustomer($incoming);
			}
		
		//}  //end if response_agricola

	} // end function Payment

    
    /*
    |--------------------------------------------------------------------------
    | CreateCustomer Function
    |--------------------------------------------------------------------------
    */
    public function CreateCustomer($incoming)
    {
        //dd($incoming);

        /*try { 
            //Response to Create Customer
            $response = Http::withOptions([
                'debug' => false,
                'verify' => false
            ])->withHeaders([
                    'Authorization' => 'Splynx-EA (access_token=' . session('admin_token') . ')' 
            ])->post('https://beesys.beenet.com.sv/api/2.0/admin/customers/customer', [
                    "login" => $incoming['email'],
                    "status" => "new",
                    "partner_id" => 2,
                    "location_id" => 1,
                    "name" => $incoming['name'],
                    "email" => $incoming['email'],
                    "phone" => $incoming['telephone'],
                    "category" => "person",
                    "street_1" => $incoming['address'],
                    "city" => $incoming['city'],
                    "billing_type" => "prepaid_monthly"          
            ]);

            //$customerResponse = json_decode($response->getBody()->getContents());

		  //create session with customer ID
            //session(['customer_id' => $customerResponse->id]);
            dd($customerResponse);

        } catch (ClientException $e) {
            return back();
        } */


		//save customer id
		$customer_id = 603;
		
		if($incoming['customerStatus'] == 0) {
			//dd("usuario nuevo");
			//get the customer info 
			dd($this->RetrieveCustomer($customer_id));
			
		}

		//$this->CreateSplynxPayment($incoming); 
    }


	/*
    |--------------------------------------------------------------------------
    | RetrieveCustomer Function
    |--------------------------------------------------------------------------
    */
	public function RetrieveCustomer($id)
	{
		
		//Response list tariff plans 
		$response = Http::withOptions([
			'debug' => false,
			'verify' => false
		])->withHeaders([
			'Authorization' => 'Splynx-EA (access_token=' . session('admin_token') . ')' 
		])->get('https://beesys.beenet.com.sv/api/2.0/admin/customers/customer/' . $id, [

		]);

		$retrieveCustomerResponse = json_decode($response->getBody()->getContents());
		return $retrieveCustomerResponse->password;
		//dd($retrieveCustomerResponse->password);

	}


    /*
    |--------------------------------------------------------------------------
    | CreateSplynxPayment Function
    |--------------------------------------------------------------------------
    */

    public function CreateSplynxPayment($incoming)
	{
		try {

			$response = Http::withOptions([
				'debug' => false,
				'verify' => false
			])->withHeaders([
				'Authorization' => 'Splynx-EA (access_token=' . session('admin_token') . ')'
			])->post('https://beesys.beenet.com.sv/api/2.0/admin/finance/payments', [
					"customer_id" => "603",
					"invoice_id" => "",
					"payment_type" => 7,
					"date" => date('Y-m-d'),
					"amount" => $incoming['amount'],
					"comment" => "Pago factura Banco Agricola, Autorizacion: ",
					//"comment" => "Pago factura Banco Agricola, Autorizacion: " . $authorizationId . " Referencia: " . $referenceId
					"field_1" => "",
					"field_2" => "",
					"field_3" => "",
					"field_4" => "",
					"field_5" => ""
			]);

			$paymentResponse = json_decode($response->getBody()->getContents());
			
			// dd($paymentResponse);
		} catch (ClientException $e) {
		return back();
		}

        $this->AddService($incoming);
    }


	/*
    |--------------------------------------------------------------------------
    | AddService Function
    |--------------------------------------------------------------------------
    */
    public function AddService($incoming)
    {
		dd($incoming);
		$response = Http::withOptions([
			'debug' => false,
			'verify' => false
		])->withHeaders([
			'Authorization' => 'Splynx-EA (access_token=' . session('admin_token') . ')'
		])->post('https://beesys.beenet.com.sv/api/2.0/admin/customers/customer/603/internet-services', [
				"customer_id" => "603",
				"tariff_id" => "145",
				"status" => "active",
				"description" => "Prueba de servicio",
				"quantity" => 1,
				"unit_price" => $incoming['amount'],
				"start_date" => date('Y-m-d'),
				"end_date" => date('Y-m-d'),
				"router_id" => 0,
				"login" => "johnprueba.doe@domain.com",
				"password" => "RS18rAIx",
				"taking_ipv4" => 0,
				"ipv4" => "",
				"ipv4_route" => "",
				"ipv4_pool_id" => 0,
				"mac" => "",
				"port_id" => 0
		]);

		$TariffResponse = json_decode($response->getBody()->getContents());

		dd($TariffResponse); 
    }

	
	/*
    |--------------------------------------------------------------------------
    | MensajeError Function
    |--------------------------------------------------------------------------
    */
    public function mensajeError($codigoError){
		$codigosError = [
		'00' => 'AUTORIZADO',
		'01' => 'LLAMAR AL EMISOR',
		'02' => 'LLAMAR AL EMISOR',
		'03' => 'LLAMAR AL EMISOR',
		'04' => 'TARJETA BLOQUEADA',
		'05' => 'LLAMAR AL EMISOR',
		'07' => 'TARJETA BLOQUEADA',
		'12' => 'TRANSACCION INVALIDA',
		'13' => 'amount INVALIDO',
		'14' => 'LLAMAR AL EMISOR',
		'15' => 'EMISOR NO DISPONIBLE',
		'19' => 'REINTENTE TRANSACCION',
		'25' => 'LLAMAR AL EMISOR',
		'30' => 'ERROR DE FORMATO',
		'39' => 'NO ES CUENTA DE CREDITO',
		'31' => 'BANCO NO SOPORTADO',
		'41' => 'TARJETA BLOQUEADA',
		'43' => 'TARJETA BLOQUEADA',
		'48' => 'CREDENCIAL INVALIDA',
		'50' => 'LLAMAR AL EMISOR',
		'51' => 'FONDOS INSUFICIENTES',
		'52' => 'NO ES CUENTA DE CHEQUES',
		'53' => 'NO ES CUENTA DE AHORROS',
		'54' => 'TARJETA EXPIRADA',
		'55' => 'PIN INCORRECTO',
		'56' => 'TARJETA NO VALIDA',
		'57' => 'TRANSACCION NO PERMITIDA',
		'58' => 'TRANSACCION NO PERMITIDA',
		'59' => 'SOSPECHA DE FRAUDE',
		'61' => 'ACTIVIDAD DE LIMITE EXCEDIDO',
		'62' => 'TARJETA RESTRINGIDA',
		'65' => 'MAXIMO PERMITIDO ALCANZADO',
		'75' => 'INTENTOS DE PIN EXCEDIDO',
		'82' => 'NO HSM',
		'83' => 'CUENTA NO EXISTE',
		'84' => 'CUENTA NO EXISTE',
		'85' => 'REGISTRO NO ENCONTRADO',
		'86' => 'AUTORIZACION NO VALIDA',
		'87' => 'CVV2 INVALIDO',
		'88' => 'ERROR EN LOG DE TRANSACCIONES',
		'89' => 'RUTA DE SERVICIO NO VALIDA',
		'91' => 'EMISOR NO DISPONIBLE',
		'92' => 'EMISOR NO DISPONIBLE',
		'93' => 'TRANSACCION NO PUEDE SER PROCESADA',
		'94' => 'TRANSACCION DUPLICADA',
		'96' => 'SISTEMA NO DISPONIBLE',
		'97' => 'TOKEN DE SEGURIDAD INVALIDO',
		'D0' => 'SISTEMA NO DISPONIBLE',
		'D1' => 'COMERCIO INVALIDO',
		'H0' => 'FOLIO YA EXISTE',
		'H1' => 'CHECK IN EXISTENTE',
		'H2' => 'SERVICIO DE RESERVACION NO PERMITIDO',
		'H3' => 'RESERVA NO ENCONTRADA EN EL SISTEMA',
		'H4' => 'TARJETA NO ENCONTRADA CHECK IN',
		'H5' => 'EXCEDE SOBREGIRO DE CHECK IN',
		'N0' => 'AUTORIZACION INHABILITADA',
		'N1' => 'TARJETA INVALIDA',
		'N2' => 'PREAUTORIZACIONES COMPLETAS',
		'N3' => 'amount MAXIMO ALCANZADO',
		'N4' => 'amount MAXIMO ALCANZADO',
		'N5' => 'MAXIMO DEVOLUCIONES ALCANZADO',
		'N6' => 'MAXIMO PERMITIDO ALCANZADO',
		'N7' => 'LLAMAR AL EMISOR',
		'N8' => 'CUENTA SOBREGIRADA',
		'N9' => 'INTENTOS PERMITIDOS ALCANZADO',
		'O0' => 'LLAMAR AL EMISOR',
		'O1' => 'NEG FILE PROBLEM',
		'O2' => 'amount DE RETIRO NO PERMITIDO',
		'O3' => 'DELINQUENT',
		'O4' => 'LIMITE EXCEDIDO',
		'O7' => 'FORCE POST',
		'O8' => 'SIN CUENTA',
		'O5' => 'PIN REQUERIDO',
		'O6' => 'DIGITO VERIFICADOR INVALIDO',
		'R8' => 'TARJETA BLOQUEADA',
		'T1' => 'amount INVALIDO',
		'T2' => 'FECHA DE TRANSACCION INVALIDA',
		'T5' => 'LLAMAR AL EMISOR'
		];
		
		return $codigosError[$codigoError];

	} //fin funcion 


    
    
}
