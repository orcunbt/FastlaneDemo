<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');


//require_once($_SERVER['DOCUMENT_ROOT'].'/braintree-php-5.1.0/lib/Braintree.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/braintree-php-6.19.0/lib/Braintree.php');

$gateway = new Braintree\Gateway([
    'environment' => 'sandbox',
    'merchantId' => '3zx8km9nr9jpbwck',
    'publicKey' => '98zmj6spkz4vztgv',
    'privateKey' => '63560512fbd6cbdfea5683c1e3eec053'
  ]);


// Ensure the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Read the input JSON from the request body
    $input = json_decode(file_get_contents('php://input'), true);



    // Check if the correct method is being requested
    if (isset($input['method']) && $input['method'] === 'fastlane_auth') {
        $result = $gateway->clientToken()->generate([


        ]);
        
               // Prepare the response data
               $response = [
                'status' => 'success',
                'client_token' => $result
            ];
        
            // Set the content type to application/json
            header('Content-Type: application/json');
        
            // Return the response as JSON
            echo json_encode($response);
    } 

    

        // Check if the correct method is being requested
        if (is_array($input) && isset($input['payment_method_nonce'])) {
            

            $payment_method_nonce = $input['payment_method_nonce'];

            $result = $gateway->transaction()->sale([
                'amount' => '5.00',
                'paymentMethodNonce' => $payment_method_nonce, 
                'options' => [
                  'submitForSettlement' => true
                ]
              ]);
    
            // Prepare the response data
            $response = [
                'status' => 'success',
                'client_token' => $result
            ];
    
            // Set the content type to application/json
            header('Content-Type: application/json');
    
            // Return the response as JSON
            echo json_encode($response);
        } 

    
}


?>