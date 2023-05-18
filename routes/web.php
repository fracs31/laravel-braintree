<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; //request
use App\Http\Controllers\PaymentController; //Payment controller

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
    /*$gateway = new Braintree\Gateway([
        'environment' => getenv('BT_ENVIRONMENT'),
        'merchantId' => getenv('BT_MERCHANT_ID'),
        'publicKey' => getenv('BT_PUBLIC_KEY'),
        'privateKey' => getenv('BT_PRIVATE_KEY')
    ]);
    $token = $gateway->ClientToken()->generate(); //token
    return view('welcome', [
        'token' => $token, //token
    ]);*/
});

Route::resource('payments', PaymentController::class); //rotte Payment

//Hosted
Route::get('/hosted', function () {
    //Gateway
    $gateway = new Braintree\Gateway([
        'environment' => getenv('BT_ENVIRONMENT'),
        'merchantId' => getenv('BT_MERCHANT_ID'),
        'publicKey' => getenv('BT_PUBLIC_KEY'),
        'privateKey' => getenv('BT_PRIVATE_KEY')
    ]);
    $token = $gateway->ClientToken()->generate(); //token
    return view('hosted', [
        'token' => $token, //token
    ]);
});

//Braintree Checkout
Route::post("/checkout", function(Request $request) {
    //Gateway
    $gateway = new Braintree\Gateway([
        'environment' => getenv('BT_ENVIRONMENT'),
        'merchantId' => getenv('BT_MERCHANT_ID'),
        'publicKey' => getenv('BT_PUBLIC_KEY'),
        'privateKey' => getenv('BT_PRIVATE_KEY')
    ]);

    $amount = $request->amount; //quantità
    $nonce = $request->payment_method_nonce; //nonce
    $date = date("Y-m-d h:i:sa"); //data
    $firstName = isset($request->first_name) ? $request->first_name : "Mario"; //nome
    $lastName = isset($request->last_name) ? $request->last_name : "Rossi"; //cognome
    $email = isset($request->email) ? $request->email : "mariorossi@gmail.com"; //email
    $phone = isset($request->phone) ? $request->phone : "1234567890"; //telefono
    $address = isset($request->address) ? $request->address : "Via Genova 1"; //indirizzo
    $postal_code = isset($request->postal_code) ? $request->postal_code : "10100"; //codice postale

    $result = $gateway->transaction()->sale([
        'amount' => $amount, //quantità
        'paymentMethodNonce' => $nonce,//nonce
        //Cliente
        'customer' => [
            'firstName' => $firstName, //nome
            'lastName' => $lastName, //cognome
            'email' => $email, //email
        ],
        'options' => [
            'submitForSettlement' => true
        ]
    ]);
    
    if ($result->success) {
        $transaction = $result->transaction;
        //header("Location: " . $baseUrl . "transaction.php?id=" . $transaction->id);
        return back()->with('success_message', 'Transaction successful. The ID is: ' . $transaction->id);
    } else {
        $errorString = "";
    
        foreach($result->errors->deepAll() as $error) {
            $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
        }
    
        //$_SESSION["errors"] = $errorString;
        //header("Location: " . $baseUrl . "index.php");
        return back()->withErrors('An error occurred with the message: ' . $result->message);
    }
});