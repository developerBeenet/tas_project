<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Session;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LoginForm Function
    |--------------------------------------------------------------------------
    */
    public function  loginForm (Request $request)
    {   
        $incoming = $request->all();
        //dd($incoming);
        return view('layouts.pages.login', compact('incoming'));
    }

    /*
    |--------------------------------------------------------------------------
    | Login Function
    |--------------------------------------------------------------------------
    */
    public function Login(Request $request)
    {  
        //Get user data (username , password)
        $incoming = $request->all();
        
        try {
            $response = Http::withOptions([
                'debug' => false,
                'verify' => false
            ])->post('https://beesys.beenet.com.sv/api/2.0/admin/auth/tokens', [
                    'auth_type' => "customer",
                    'login' => $incoming['username'] ,
                    'password' => $incoming['password']
            ]);

            //failed response
            if($response->failed()){ 
                //dd("fallo"); 
                toast('Credenciales invalidas ','warning');  
                return view('layouts.pages.login');
            }

            //customer token 
            $responseToken = json_decode($response->getBody()->getContents());
           // dd($responseToken);


        /*
        |--------------------------------------------------------------------------
        | LoginForm Function
        |--------------------------------------------------------------------------
        |check if the token is still valid. This conditions is met when the current 
        |timestamp is greater that the access token expiration
        */
           
            if (Carbon::now()->timestamp > $responseToken->access_token_expiration) {

                // Renew toke
                $response = Http::withOptions([
                     'debug' => false,
                     'verify' => false
                 ])->get('https://beesys.beenet.com.sv/api/2.0/admin/auth/tokens/' . $responseToken->refresh_token, [
                     
                 ]);

                 $responseToken = json_decode($response->getBody()->getContents()); 
            }

            
            //If the API call fails, It returns to main page
            if($response->failed()){     
                return back();   
            }

            return view('layouts.pages.portalCustomer.portal');

        } catch (ClientException $e) {
            return back();
        }  //end try catch  
    }


    /*
    |--------------------------------------------------------------------------
    | Logout Function
    |--------------------------------------------------------------------------
    */
    public function logout()
    {
        // Destroy the session
        Session::flush();
        // Return the login page
        return redirect('/');
    }  

}
