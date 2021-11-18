<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TariffsController extends Controller
{
  
    /*
    |--------------------------------------------------------------------------
    | ListTariffsInternet Function
    |--------------------------------------------------------------------------
    */
    public function ListTariffsInternet()
    {
        
        try {
                
            /*Response to generate Admin Token*/ 
            $response = Http::withOptions([
                'debug' => false,
                'verify' => false
            ])->withHeaders([
                
            ])->post('https://beesys.beenet.com.sv/api/2.0/admin/auth/tokens', [
                    "auth_type" => "admin",
                    "login" => "splynx",
                    "password" => "B3ne3t$21"    
            ]);

            $responseToken = json_decode($response->getBody()->getContents());

            //create sessions
            session(['admin_token' => $responseToken->access_token]);
            session(['expiration_token' => $responseToken->access_token_expiration]);
            session(['refresh_token' => $responseToken->refresh_token]);
    
        
        } catch (ClientException $e) {
            return back();
        } 



        try {

            //Response list tariff plans 
            $response = Http::withOptions([
                'debug' => false,
                'verify' => false
            ])->withHeaders([
                'Authorization' => 'Splynx-EA (access_token=' . session('admin_token') . ')' 
            ])->get('https://beesys.beenet.com.sv/api/2.0/admin/tariffs/internet', [
            ]);

            $tariffs = json_decode($response->getBody()->getContents());

            /*for($i=0;$i<count($tariffs);$i++){
                    if( $tariffs[$i]->partners_ids[0] == 2) {
                        //print_r($tariffs[$i]);
                        $tariffsInternet = $tariffs[$i];
                        return view('layouts.pages.index', compact('tariffsInternet'));
                    } 
                }*/

           return view('layouts.pages.index', compact('tariffs'));
             //return view('layouts.pages.portalCustomer.portal');
            //Retrieve partner_id
            //dd(json_decode($response->getBody()->getContents())[0]->partners_ids);
        }  catch (ClientException $e) {
            return back();
        } 
    }

}
