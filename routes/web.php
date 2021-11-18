<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Show index and list tariffs plans
Route::get('/', 'TariffsController@ListTariffsInternet')->name('index');

//show login form
Route::post('/login', 'LoginController@loginForm')->name('showLogin');

//Generate Auth  and show portal 
Route::post('/loginPortal', 'LoginController@Login')->name('loginPortal');

//show checkout form
Route::post('/internet', 'PaymentController@CheckoutForm')->name('internet');

//Create MOA Payment
Route::post('/payment', 'PaymentController@CreatePaymentMoa')->name('payment');

//Portal Logout
Route::get('/logout', 'LoginController@logout')->name('logout');

