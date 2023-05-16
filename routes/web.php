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

Route::get('/', function () {
    //Gateway
    $gateway = new Braintree\Gateway([
        'environment' => getenv('BT_ENVIRONMENT'),
        'merchantId' => getenv('BT_MERCHANT_ID'),
        'publicKey' => getenv('BT_PUBLIC_KEY'),
        'privateKey' => getenv('BT_PRIVATE_KEY')
    ]);
    $token = $gateway->ClientToken()->generate(); //token
    return view('welcome', [
        'token' => $token, //token
    ]);
});